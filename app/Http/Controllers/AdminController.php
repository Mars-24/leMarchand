<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Depense;
use App\Models\FondDeCaisse;
use App\Models\Order;
use App\Models\Produit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManager;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function auth()
    {
        return view('admin.auth.login');
    }

    public function index()
    {
        $admins = Admin::where('role', '!=', 'admin')->get();
        return view('admin.admin.index', compact('admins'));
    }


    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt(['nom' => $request->nom, 'password' => $request->password, 'status' => 'actif', 'role' => 'admin'])) {
            return redirect()->route('admin.dashboard')->with('success', 'Bienvenue');
        } elseif (Auth::guard('admin')->attempt(['nom' => $request->nom, 'password' => $request->password, 'status' => 'actif', 'role' => 'normal'])) {
            return redirect()->route('factures.create')->with('success', 'Bienvenue');
        } elseif (Auth::guard('admin')->attempt(['nom' => $request->nom, 'password' => $request->password, 'status' => 'actif', 'role' => 'otr'])) {
            return redirect()->route('admin.otr.dashboard')->with('success', 'Bienvenue');
        } else {
            return back()->withInput($request->only('nom'))->with('error', 'Erreur du mot passe ou du nom');
        }
    }
    public function logout(Request $request)
    {
        Session::forget('user');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.connexion')
            ->with('success', 'Deconnexion reussie');
    }
    public function dashboard()
    {
        $today = Carbon::today();
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Récupérer les 5 dernières ventes avec les clients
        $ventes = Order::with('client')->latest()->take(5)->get();

        // Récupérer les 6 derniers clients ayant passé des commandes
        $clients = Client::whereHas('orders')->with('orders')->latest()->take(6)->get();

        // Récupérer les 6 meilleurs clients (ceux qui ont le plus de commandes)
        $superclients = Client::whereHas('orders')->withCount('orders')->orderByDesc('orders_count')->take(6)->get();

        // Dépenses
        $totalMontant = Depense::whereDate('created_at', $today)->sum('montant');
        $totalMontantMonth = Depense::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('montant');
        $totalMontantYear = Depense::whereYear('created_at', $currentYear)->sum('montant');

        // Chiffre d'affaires (acompte ou prix total)
        $totalPriceToday = Order::whereDate('created_at', $today)->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END'));
        $totalPriceThisMonth = Order::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END'));
        $totalPriceThisYear = Order::whereYear('created_at', $currentYear)->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END'));

        // Nombre de clients uniques ayant passé une commande aujourd'hui
        $clientsTodayCount = Order::whereDate('created_at', $today)->distinct('client_id')->count('client_id');

        // Produits en stock
        $produit_stock = Produit::where('status', 'en_stock')->count();

        // Récupération des commandes
        $ordersToday = Order::whereDate('created_at', $today)->pluck('produits');
        $ordersMonth = Order::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->pluck('produits');
        $ordersYear = Order::whereYear('created_at', $currentYear)->pluck('produits');

        $ordersTodayCount = $ordersToday->count();
        $ordersThisMonthCount = $ordersMonth->count();

        // Calcul des marges brutes
        $margeBruteToday = $this->calculerMargeBrute($ordersToday);
        $margeBruteMonth = $this->calculerMargeBrute($ordersMonth);
        $margeBruteYear = $this->calculerMargeBrute($ordersYear);

        // Marges nettes après dépenses
        $margeNetteToday = $margeBruteToday - $totalMontant;
        $margeNetteMonth = $margeBruteMonth - $totalMontantMonth;
        $margeNetteYear = $margeBruteYear - $totalMontantYear;

        // Graphique : Ventes par jour ce mois-ci
        $salesThisMonth = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%e %b") as date'),
                DB::raw('COUNT(id) as total_ventes')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'ASC')
            ->get();

        // Graphique : Ventes par mois cette année
        $salesThisYear = Order::whereYear('created_at', $currentYear)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%b") as date'),
                DB::raw('COUNT(id) as total_ventes')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'ASC')
            ->get();

        // Fonds de caisse
        $fondCaisse = FondDeCaisse::sum('montant_initial');

        return view('admin.dashboard', compact(
            'ordersTodayCount',
            'totalPriceToday',
            'clientsTodayCount',
            'ventes',
            'margeNetteToday',
            'margeBruteToday',
            'margeNetteMonth',
            'margeBruteMonth',
            'margeNetteYear',
            'margeBruteYear',
            'produit_stock',
            'clients',
            'totalMontant',
            'totalMontantMonth',
            'totalMontantYear',
            'fondCaisse',
            'totalPriceThisYear',
            'totalPriceThisMonth',
            'ordersThisMonthCount',
            'superclients',
            'salesThisMonth',
            'salesThisYear'
        ));
    }

    // ✅ Fonction séparée pour calculer la marge brute
    private function calculerMargeBrute($orders)
    {
        $margeBrute = 0;

        foreach ($orders as $produitsJson) {
            $produits = json_decode($produitsJson, true);

            if (is_array($produits)) {
                foreach ($produits as $product) {
                    if (isset($product[2], $product[5], $product[3])) {
                        $prix_vente = (float) $product[2];
                        $prix_achat = (float) $product[5];
                        $quantite = (int) $product[3];

                        $margeBrute += ($prix_vente - $prix_achat) * $quantite;
                    }
                }
            }
        }

        return $margeBrute;
    }

    public function dashboardOtr()
    {
        $today = Carbon::today();
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $ventes = Order::with('client')->latest()->take(5)->get();
        $clients = Client::whereHas('orders')->with('orders')->latest()->take(6)->get();
        $superclients = Client::whereHas('orders')->withCount('orders')->orderByDesc('orders_count')->take(6)->get();

        $totalMontant = round(Depense::whereDate('created_at', $today)->sum('montant') / 3);
        $totalMontantMonth = round(Depense::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('montant') / 3);
        $totalMontantYear = round(Depense::whereYear('created_at', $currentYear)->sum('montant') / 3);

        $totalPriceToday = round(Order::whereDate('created_at', $today)->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END')) / 3);
        $totalPriceThisMonth = round(Order::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END')) / 3);
        $totalPriceThisYear = round(Order::whereYear('created_at', $currentYear)->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END')) / 3);

        $clientsTodayCount = round(Order::whereDate('created_at', $today)->distinct('client_id')->count('client_id') / 3);
        $produit_stock = round(Produit::where('status', 'en_stock')->count() / 3);

        $ordersToday = Order::whereDate('created_at', $today)->pluck('produits');
        $ordersMonth = Order::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->pluck('produits');
        $ordersYear = Order::whereYear('created_at', $currentYear)->pluck('produits');

        $ordersTodayCount = round($ordersToday->count() / 3);
        $ordersThisMonthCount = round($ordersMonth->count() / 3);

        $margeBruteToday = round($this->calculerMargeBrute($ordersToday) / 3);
        $margeBruteMonth = round($this->calculerMargeBrute($ordersMonth) / 3);
        $margeBruteYear = round($this->calculerMargeBrute($ordersYear) / 3);

        $margeNetteToday = $margeBruteToday - $totalMontant;
        $margeNetteMonth = $margeBruteMonth - $totalMontantMonth;
        $margeNetteYear = $margeBruteYear - $totalMontantYear;

        $salesThisMonth = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%e %b") as date'),
                DB::raw('ROUND(COUNT(id) / 3) as total_ventes')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'ASC')
            ->get();

        $salesThisYear = Order::whereYear('created_at', $currentYear)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%b") as date'),
                DB::raw('ROUND(COUNT(id) / 3) as total_ventes')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'ASC')
            ->get();

        $fondCaisse = round(FondDeCaisse::sum('montant_initial') / 3);

        return view('admin.dashboardOtr', compact(
            'ordersTodayCount',
            'totalPriceToday',
            'clientsTodayCount',
            'ventes',
            'margeNetteToday',
            'margeBruteToday',
            'margeNetteMonth',
            'margeBruteMonth',
            'margeNetteYear',
            'margeBruteYear',
            'produit_stock',
            'clients',
            'totalMontant',
            'totalMontantMonth',
            'totalMontantYear',
            'fondCaisse',
            'totalPriceThisYear',
            'totalPriceThisMonth',
            'ordersThisMonthCount',
            'superclients',
            'salesThisMonth',
            'salesThisYear'
        ));
    }

    public function profil()
    {
        // $user =auth('admin')->user();
        // return dd($user);
        return view('admin.profil');
    }

    public function updateProfil(Request $request, $id = null)
    {
        $user = auth('admin')->user(); // Admin ou utilisateur connecté
    
        // Si l'ID est fourni et que l'utilisateur est ADMIN, il modifie un autre compte
        // Sinon, il met à jour son propre profil
        $targetUser = $id && $user->role === 'admin' ? Admin::findOrFail($id) : $user;
    
        // Règles de validation de base
        $rules = [
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $targetUser->id, // Vérifier l'email unique sauf pour l'utilisateur ciblé
            'password' => ['nullable', 'min:8', 'confirmed'], // Optionnel mais doit être confirmé
        ];
    
        // Si ce n'est PAS un admin qui modifie, on exige l'ancien mot de passe pour changer le mot de passe
        if ($user->role !== 'admin' && $request->filled('password')) {
            // $rules['oldPassword'] = ['required', 'current_password'];
        }
    
        // Messages d'erreur personnalisés
        $messages = [
            'email.unique' => 'Cet email est déjà utilisé par un autre compte.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'oldPassword.required' => 'L’ancien mot de passe est requis.',
            'oldPassword.current_password' => 'L’ancien mot de passe est incorrect.',
        ];

        // return dd($request->all());
        // Validation des données
        $request->validate($rules, $messages);
        // Mise à jour des informations du profil
        $targetUser->update([
            'nom' => $request->nom,
            'prenoms' => $request->prenoms,
            'email' => $request->email,
        ]);
        if ($request->filled('role')) {
            $targetUser->update([
                'role' => $request->role,
            ]);
        }
        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $targetUser->update([
                'password' => Hash::make($request->password)
            ]);
        }
    
        return back()->with('success', 'Profil mis à jour avec succès.');
    }
    


    // public function updateProfil(Request $request)
    // {
    //     // Validation des autres champs du profil
    //     $user = auth('admin')->user();

    //     return dd($request->all());
    //     $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'prenoms' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $user->id, // Exclure l'email actuel
    //         'oldPassword' => ['nullable', 'current_password'], // Optionnel mais vérifié si rempli
    //         'password' => ['nullable', 'min:8', 'confirmed'], // Optionnel mais doit être confirmé
    //     ], [
    //         'email.unique' => 'Cet email est déjà utilisé.',
    //         'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
    //         'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    //         'oldPassword.current_password' => 'L’ancien mot de passe est incorrect.',
    //     ]);

    //     // Mise à jour des autres informations
    //     $user->update([
    //         'nom' => $request->nom,
    //         'prenoms' => $request->prenoms,
    //         'email' => $request->email,
    //     ]);

    //     // Mise à jour du mot de passe si fourni
    //     if ($request->filled('password')) {
    //         $user->update([
    //             'password' => Hash::make($request->password)
    //         ]);
    //     }

    //     return back()->with('success', 'Profil mis à jour avec succès.');
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $messages = [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères valide.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'prenoms.required' => 'Le prénom est obligatoire.',
            'prenoms.string' => 'Le prénom doit être une chaîne de caractères valide.',
            'prenoms.max' => 'Le prénom ne doit pas dépasser 255 caractères.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'telephone.unique' => 'Ce numéro de téléphone est déjà enregistré.',
            'telephone.regex' => 'Le numéro de téléphone doit être valide.',

            'adresse.string' => 'L\'adresse doit être une chaîne de caractères valide.',

            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle sélectionné est invalide.',
        ];

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'telephone' => 'nullable|unique:admins,telephone',
            'adresse' => 'nullable|string|max:255',
            'role' => 'required|in:normal,admin,gerant,otr',
        ], $messages);

        $data = $request->all();
        if ($request->has('photo')) {
            $destination_path = 'public';
            $file = $request->file('photo');
            $file_name = $file->getClientOriginalName();
            $image = ImageManager::imagick()->read($file);
            $photo = $image->resize(640, 640);
            $photo->save(storage_path('app/' . $destination_path . '/' . $file_name));
            $data['photo'] = $file_name;
        }
        $data['password'] = Hash::make('leMarchand2@25');
        $status = Admin::create($data);
        if ($status) {
            return redirect()->route('admins.index')->with('success', 'Admin crée');
        } else {
            return redirect()->route('admins.index')->with('error', 'Erreur lors de la creation de admin');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $admin = Admin::find($id);
        return view('admin.admin.details', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}

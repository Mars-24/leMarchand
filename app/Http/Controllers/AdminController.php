<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Depense;
use App\Models\FondDeCaisse;
use App\Models\Order;
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

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'actif', 'role' => 'admin'])) {
            return redirect()->route('admin.dashboard')->with('success', 'Bienvenue');
        } elseif (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'actif', 'role' => 'normal'])) {
            return redirect()->route('factures.create')->with('success', 'Bienvenue');
        } else {
            return back()->withInput($request->only('email'))->with('error', 'Erreur du mot passe ou de l\'email');
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
        $ordersTodayCount = Order::whereDate('created_at', Carbon::today())->count();
        $ordersThisMonthCount = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)->count();
    
        $ventes = Order::with('client')->latest()->take(5)->get();
        $clients = Client::with('orders')->latest()->take(6)->get();
        $superclients = Client::withCount('orders')->orderBy('orders_count', 'desc')->take(6)->get();
    
        $totalMontant = Depense::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('montant');
    
        $totalPriceToday = Order::whereDate('created_at', Carbon::today())
            ->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END'));
    
        $totalPriceThisMonth = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END'));
    
        $totalPriceThisYear = Order::whereYear('created_at', Carbon::now()->year)
            ->sum(DB::raw('CASE WHEN acompte > 0 THEN acompte ELSE prix_total END'));
    
        $clientsTodayCount = Order::whereDate('created_at', Carbon::today())
            ->distinct('client_id')->count('client_id');
    
        $salesThisMonth = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%e %b") as date'),
                DB::raw('COUNT(id) as total_ventes')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'ASC')
            ->get();
    
        $salesThisYear = Order::whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%b") as date'),
                DB::raw('COUNT(id) as total_ventes')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'ASC')
            ->get();
    
        $fondCaisse = FondDeCaisse::all()->sum('montant_initial');
    
        return view('admin.dashboard', compact(
            'ordersTodayCount', 'totalPriceToday', 'clientsTodayCount', 'ventes', 
            'clients', 'totalMontant', 'fondCaisse', 'totalPriceThisYear', 
            'totalPriceThisMonth', 'ordersThisMonthCount', 'superclients', 
            'salesThisMonth', 'salesThisYear'
        ));
    }
    

    public function profil()
    {
        // $user =auth('admin')->user();
        // return dd($user);
        return view('admin.profil');
    }


    public function updateProfil(Request $request)
    {
        // Validation des autres champs du profil
        $user = auth('admin')->user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Exclure l'email actuel
            'oldPassword' => ['nullable', 'current_password'], // Optionnel mais vérifié si rempli
            'password' => ['nullable', 'min:8', 'confirmed'], // Optionnel mais doit être confirmé
        ], [
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'oldPassword.current_password' => 'L’ancien mot de passe est incorrect.',
        ]);

        // Mise à jour des autres informations
        $user->update([
            'nom' => $request->nom,
            'prenoms' => $request->prenoms,
            'email' => $request->email,
        ]);

        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
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

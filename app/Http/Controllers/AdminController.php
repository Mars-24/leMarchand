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

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'actif'])) {
            return redirect()->route('admin.dashboard')->with('success', 'Bienvenue');
        } else {
            return back()->withInput($request->only('email'));
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
        $ordersTodayCount = Order::whereDate('created_at', Carbon::today())
            ->count();

        $ordersThisMonthCount = Order::whereYear('created_at', Carbon::now()->year)
    ->whereMonth('created_at', Carbon::now()->month)
    ->count();

        $ventes = Order::with('client')->take(5)->get();

        $clients = Client::with('orders')->take(6)->get();

        $superclients = Client::withCount('orders') // Compter le nombre de commandes par client
    ->orderBy('orders_count', 'desc') // Trier par nombre de commandes décroissant
    ->take(6) // Prendre seulement les 6 premiers
    ->get();

        $totalMontant = Depense::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('montant');

        $totalPriceToday = Order::whereDate('created_at', Carbon::today())
            ->sum('prix_total');

        $totalPriceThisMonth = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('prix_total');

        $totalPriceThisYear = Order::whereYear('created_at', Carbon::now()->year)
            ->sum('prix_total');

        $clientsTodayCount = Order::whereDate('created_at', Carbon::today())
            ->distinct('client_id')
            ->count('client_id');

        $fondCaisse = FondDeCaisse::all()->sum('montant_initial');
        return view('admin.dashboard', compact('ordersTodayCount', 'totalPriceToday', 'clientsTodayCount', 'ventes', 'clients', 'totalMontant', 'fondCaisse','totalPriceThisYear','totalPriceThisMonth','ordersThisMonthCount','superclients'));
    }


    public function profil()
    {
        return view('admin.profil');
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

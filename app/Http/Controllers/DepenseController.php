<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    //


    public function index()
    {
        $now = Carbon::now();
        $depenses = Depense::whereMonth('created_at',$now->month)->whereYear('created_at',$now->year)->get();
        return view('admin.depenses.index',compact('depenses'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'motif' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
        ]);
        $validated['admin_id'] = auth()->guard('admin')->user()->id;
        // Création de la dépense
        $status = Depense::create($validated);
        if ($status) {
            return redirect()->route('depenses.index')->with('success', 'Depense ajoutée avec success');
        } else {
            # code...
        }
    }
}

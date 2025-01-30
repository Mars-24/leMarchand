<?php

namespace App\Http\Controllers;

use App\Models\FondDeCaisse;
use Illuminate\Http\Request;

class FondDeCaisseController extends Controller
{
    //
    public function index(){
        $fondDeCaisse = FondDeCaisse::all();
        return view('admin.fonds.index',compact('fondDeCaisse'));
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'montant_initial' => 'required|numeric|min:0',
        ]);
        $validated['admin_id'] = auth()->guard('admin')->user()->id;
        // Création de la dépense
        $status = FondDeCaisse::create($validated);
        if ($status) {
            return redirect()->route('fonds.index')->with('success', 'Depense ajoutée avec success');
        } else {
            # code...
        }
    }
}

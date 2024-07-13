<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFournisseurRequest;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $fournisseurs = Fournisseur::paginate(12);
        return view('admin.fournisseurs.index',compact('fournisseurs'));
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
    public function store(StoreFournisseurRequest $request)
    {
        //
        $file_name = null;
        if ($request->has('photo')) {
            $destination_path = 'public';
            $file = $request->file('photo');  
            $file_name = $file->getClientOriginalName();
            $image = ImageManager::imagick()->read($file);
            $photo = $image->resize(640,640);
            $photo->save(storage_path('app/' . $destination_path . '/' . $file_name));
        }
        $fournisseur = new Fournisseur();
        $fournisseur->nom = $request->nom;
        $fournisseur->prenoms = $request->prenoms;
        $fournisseur->telephone = $request->telephone;
        $fournisseur->email = $request->email;
        $fournisseur->photo = $file_name;
        $fournisseur->save();
        return redirect()->route('admin.fournisseur');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $fournisseur_delete = Fournisseur::find($id);

        // return dd($fournisseur_delete);
        if($fournisseur_delete){
            $status = $fournisseur_delete->delete();
            if($status){
                return redirect()->route('admin.fournisseur')->with('success','suppression du fournisseur');
            }else{
                return redirect()->route('admin.fournisseur')->with('error','Erreur lors de la suppression du fournisseur');
            }

        }else{
            return back()->with('error','fournisseur non trouvé');
        };
    }
}

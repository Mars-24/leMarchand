<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $produits = Produit::all();
        return view('admin.produits.index',compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $fournisseurs = Fournisseur::all();
        $subCategories = SubCategory::with('categorie')->get();
        return view('admin.produits.add',compact('subCategories','fournisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        $file_name = null;
        $photo_name = null;
       
        // return dd($data);
        if($data['fournisseur_id']=='absent'){
            if ($request->has('photo')) {
                $destination_path = 'public';
                $file = $request->file('photo');  
                $file_name = $file->getClientOriginalName();
                $image = ImageManager::imagick()->read($file);
                $photo = $image->resize(640,640);
                $photo->save(storage_path('app/' . $destination_path . '/' . $file_name));
            }
            $fournisseur = new Fournisseur();
            $fournisseur->nom = $data['nom'];
            $fournisseur->prenoms = $data['prenoms'];
            $fournisseur->telephone = $data['telephone'];
            $fournisseur->email = $data['email'];
            $fournisseur->photo = $file_name;
           $status= $fournisseur->save();
           if ($status) {
            $data['fournisseur_id']= $fournisseur->id;
            if ($request->has('file')) {
                $destination_path = 'public';
                $file = $request->file('file');  
                $photo_name = $file->getClientOriginalName();
                $image = ImageManager::imagick()->read($file);
                $photo = $image->resize(640,640);
                $photo->save(storage_path('app/' . $destination_path . '/' . $file_name));
            }
            $data['photo']=$photo_name;
            do {
                $code_unique = Str::random(10); // Génère un code aléatoire de 10 caractères
            } while (Produit::where('code_unique', $code_unique)->exists()); // Assure l'unicité du code
        
            $data['code_unique'] = $code_unique;
            // return dd($data);
            $statusProduct =Produit::create($data);
            if ($statusProduct) {
                return redirect()->route('produits.index')->with('success','Produit Enregistrer');
            } else {
                return redirect()->back()->with('error','Erreur lors de l enregistrement du produit');
            }
            
           } else {
            return redirect()->back()->with('error','Erreur lors de l enregistrement du produit');
        }
           
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        //
    }
}

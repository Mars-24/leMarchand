<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduitRequest;
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
        $produits = Produit::with('fournisseur')->with('subcategory')->get();
        return view('admin.produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $fournisseurs = Fournisseur::all();
        $subCategories = SubCategory::with('categorie')->get();
        return view('admin.produits.add', compact('subCategories', 'fournisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProduitRequest $request)
    {
        //
        $data = $request->all();
        $file_name = null;
        $photo_name = null;


        if ($data['fournisseur_id'] == 'absent') {
            if ($request->has('photo')) {
                $destination_path = 'public';
                $file = $request->file('photo');
                $file_name = $file->getClientOriginalName();
                $image = ImageManager::imagick()->read($file);
                $photo = $image->resize(640, 640);
                $photo->save(storage_path('app/' . $destination_path . '/' . $file_name));
            }
            $fournisseur = new Fournisseur();
            $fournisseur->nom = $data['nom'];
            $fournisseur->prenoms = $data['prenoms'];
            $fournisseur->telephone = $data['telephone'];
            $fournisseur->email = $data['email'];
            $fournisseur->photo = $file_name;
            $status = $fournisseur->save();
            if ($status) {
                $data['fournisseur_id'] = $fournisseur->id;
                if ($request->has('file')) {
                    $destination_path = 'public';
                    $file = $request->file('file');
                    $photo_name = $file->getClientOriginalName();
                    $image = ImageManager::imagick()->read($file);
                    $photo = $image->resize(640, 640);
                    $photo->save(storage_path('app/' . $destination_path . '/' . $photo_name));
                }
                $data['photo'] = $photo_name;
                do {
                    $code_bar = Str::random(10); // Génère un code aléatoire de 10 caractères
                } while (Produit::where('code_bar', $code_bar)->exists()); // Assure l'unicité du code

                $data['code_bar'] = $code_bar;
                // return dd($data);
                $statusProduct = Produit::create($data);
                if ($statusProduct) {
                    return redirect()->route('produits.index')->with('success', 'Produit Enregistrer');
                } else {
                    return redirect()->back()->with('error', 'Erreur lors de l enregistrement du produit');
                }
            } else {
                return redirect()->back()->with('error', 'Erreur lors de l enregistrement du produit');
            }
        } else {
            if ($request->has('file')) {
                $destination_path = 'public';
                $file = $request->file('file');
                $photo_name = $file->getClientOriginalName();
                $image = ImageManager::imagick()->read($file);
                $photo = $image->resize(640, 640);
                $photo->save(storage_path('app/' . $destination_path . '/' . $photo_name));
            }
            $data['photo'] = $photo_name;
            do {
                $code_bar = Str::random(10); // Génère un code aléatoire de 10 caractères
            } while (Produit::where('code_bar', $code_bar)->exists()); // Assure l'unicité du code

            $data['code_bar'] = $code_bar;
            $statusProduct = Produit::create($data);
            if ($statusProduct) {
                return redirect()->route('produits.index')->with('success', 'Produit Enregistrer');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de l enregistrement du produit');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $produit = Produit::with('fournisseur')->findOrFail($id);
        return view('admin.produits.detail', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $fournisseurs = Fournisseur::all();
        $subCategories = SubCategory::with('categorie')->get();

        return view('admin.produits.edit', compact('produit', 'fournisseurs', 'subCategories'));
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
    public function destroy($id)
    {
        //
        $produit = Produit::find($id);
        if ($produit) {
            $status = $produit->delete();
            if ($status) {
                return redirect()->route('produits.index')->with('success', 'suppression du produit');
            } else {
                return redirect()->route('produits.index')->with('error', 'Erreur lors de la suppression du produit');
            }
        } else {
            return back()->with('error', 'produit non trouvé');
        };
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Vérification simple : Si aucun paramètre n'est passé, retourner une liste vide
        if (!$query) {
            return response()->json([]);
        }

        // Rechercher les produits correspondants
        $produits = Produit::with('subcategory')
            ->where('code_bar', 'LIKE', "$query%")->Where('status', 'en_stock')
            ->orWhere('model', 'LIKE', "$query%")
            ->orWhere('prix_vente', 'LIKE', "%$query%")
            ->get();

        // Retourner les données sous forme de JSON
        return response()->json($produits);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

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
    public function store(StoreSubCategoryRequest $request)
    {
        //
        $data = $request->all();
        // return dd($data);
        $status = SubCategory::create($data);
        if ($status) {
            return redirect()->route('admin.categorie.subCategory')->with('success','Client crée');
        } else {
            return redirect()->route('admin.categorie.subCategory')->with('error','Erreur lors de la creation de la sous categorie');
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $categories = Category::all();
    $subcategories = SubCategory::with('categorie')
    ->withCount('products')
    ->withCount(['products as sold_products_count' => function ($query) {
        $query->where('status', 'vendu');
    }])
    ->get();      $editSubCategorie = SubCategory::findOrFail($id);

    return view('admin.categories.sous_category', compact('categories', 'subcategories', 'editSubCategorie'));
}
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
        ]);
    
        $subcategorie = SubCategory::findOrFail($id);
        $subcategorie->nom = $request->nom;
        $subcategorie->categorie_id = $request->categorie_id;
        $subcategorie->save();
    
        return redirect()->route('admin.categorie.subCategory')->with('success', 'Sous-catégorie mise à jour avec succès.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorie = SubCategory::find($id);
        if ($categorie) {
            $status = $categorie->delete();
            if ($status) {
                return redirect()->route('admin.categorie.subCategory')->with('success', 'suppression de la sous-catégorie');
            } else {
                return redirect()->route('categorie.index')->with('error', 'Erreur lors de la suppression de la sous-categorie');
            }
        } else {
            return back()->with('error', 'sous-catégorie non trouvé');
        };
    }
}

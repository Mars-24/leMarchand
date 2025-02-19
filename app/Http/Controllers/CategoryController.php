<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // $categories = Category::all();
        // $categories = Category::withCount(['subCategories', 'products'])->get();
        // // return dd($categories);
        // return view('admin.categories.index',compact('categories'));
        $categories = Category::withCount(['subCategories', 'products'])->get();
        $editCategorie = null;
    
        if ($request->has('edit')) {
            $editCategorie = Category::find($request->edit);
        }
    
        return view('admin.categories.index', compact('categories', 'editCategorie'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function subCategory(){
        $categories = Category::all();
        $subcategories = SubCategory::with('categorie')
        ->withCount('products')
        ->withCount(['products as sold_products_count' => function ($query) {
            $query->where('status', 'vendu');
        }])
        ->get();        // return dd($subcategories);
        return view('admin.categories.sous_category',compact('categories','subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        $data = $request->all();
        if($request->has('photo')){
            $destination_path = 'public';
            $file = $request->file('photo');  
            $file_name = $file->getClientOriginalName();
            $image = ImageManager::imagick()->read($file);
            $photo = $image->resize(640,640);
            $photo->save(storage_path('app/' . $destination_path . '/' . $file_name));
            $data['photo']= $file_name;
        }
        $status = Category::create($data);
        if ($status) {
            return redirect()->route('categories.index')->with('success','Categorie crée');
        } else {
            return redirect()->route('categories.index')->with('error','Erreur lors de la creation de la catégorie');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       // Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image optionnelle, max 2MB
    ]);

    // Récupérer la catégorie à modifier
    $categorie = Category::findOrFail($id);

    // Mettre à jour les informations
    $categorie->nom = $request->nom;

    // Gérer l'upload de la nouvelle image (si fournie)
    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo s'il y en avait une
        if ($categorie->photo) {
            Storage::delete('public/' . $categorie->photo);
        }
        
        // Stocker la nouvelle photo
        $imagePath = $request->file('photo')->store('categories', 'public');
        $categorie->photo = $imagePath;
    }

    $categorie->save();

    // Retourner sur la page avec la catégorie en mode édition
    return redirect()->route('categories.index')->with([
        'success' => 'Catégorie mise à jour avec succès.',
        'editCategorie' => $categorie
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorie = Category::find($id);
        if ($categorie) {
            $status = $categorie->delete();
            if ($status) {
                return redirect()->route('categories.index')->with('success', 'suppression de la catégorie');
            } else {
                return redirect()->route('categorie.index')->with('error', 'Erreur lors de la suppression de la categorie');
            }
        } else {
            return back()->with('error', 'catégorie non trouvé');
        };
    }
}

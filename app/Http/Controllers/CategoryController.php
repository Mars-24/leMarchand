<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $categories = Category::all();
        $categories = Category::withCount(['subCategories', 'products'])->get();
        // return dd($categories);
        return view('admin.categories.index',compact('categories'));
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
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}

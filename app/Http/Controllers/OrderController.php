<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produit;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $lastInvoice = Order::orderBy('created_at', 'desc')->first();
        $newInvoiceNumber = 'INV-000001';

        if ($lastInvoice) {
            // Extraire le dernier numéro de facture
            $lastInvoiceNumber = intval(str_replace('INV-', '', $lastInvoice->invoice_number));
            $newInvoiceNumber = 'INV-' . str_pad($lastInvoiceNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            // Si aucune facture n'existe, démarrer avec un numéro de base
            $newInvoiceNumber = 'INV-000001';
        }
        $produits = Produit::with('fournisseur')->with('subcategory')->get();
    //    dd($carts);
        return view('admin.ventes.index',compact('produits','newInvoiceNumber'));
    }

    public function cartStore(Request $request){

        $product_qty =$request->input('product_qty');
        $product_id =$request->input('product_id');
        $product=Produit::getProduit($product_id);

        $cart_array=[];

        foreach(Cart::instance('facture')->content() as $item){
            $cart_array[]=$item->id;
        }
        $result = Cart::instance('facture')->add($product_id,$product[0]['model'],$product_qty,$product[0]['prix_vente'])->associate('App\Models\Produit');
       // dd($result);
        if($result){
            $response['status']=true;
            $response['product_id']=$product_id;
            $response['total']=Cart::subtotal();
            $response['message']="Produit ajouter a la facture";
            $response['cart_count']=Cart::instance('facture')->count();
        }
        if($request->ajax()){
            $facture=view('admin.layouts._facture-list')->render();
            $response['cart']=$facture;
        }
        return json_encode($response);
    }
    public function cartDelete(Request $request){

        $id = $request->input('cart_id');
        $result= Cart::instance('facture')->remove($id);
             $response['status']=true;
             $response['total']=Cart::subtotal();
             $response['message']='produit bien supprimé de la facture';
             $response['cart_count']=Cart::instance('shopping')->count();
         if($request->ajax()){
            $facture=view('admin.layouts._facture-list')->render();
            $response['cart']=$facture;
         }
         return json_encode($response);
    }

    public function cartUpdate(Request $request){
        $this->validate($request,[
            'price'=>'required|numeric',
        ]);
        $rowId=$request->input('rowId');
        $price=$request->input('price');

        if ($price<1) {
            $message="Vous ne pouvez pas ajouter un produit avec un prix inferieur a 1";
            $response['status']=false;
        }else {
            Cart::instance('facture')->update($rowId,['price' => $price]);
            // return dd(Cart::instance('facture')->content());
            $message="Prix produit mise a jour avec success";
            $response['status']=true;
            $response['total']=Cart::subtotal();
            $response['cart_count']=Cart::instance('facture')->count();
        }
        if ($request->ajax()) {
            $facture=view('admin.layouts._facture-list')->render();
            $response['cart']=$facture;
            $response['message']=$message;
        }
        return $response;
    }

    public function paiementView(){
        return view('admin.layouts._facture-list');
    }
    public function dealView(){
        return view('admin.layouts._deal-facture-list');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

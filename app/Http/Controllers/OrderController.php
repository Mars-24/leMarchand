<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Produit;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventes = Order::with('client')->get();
        // return dd($ventes);
        return view('admin.ventes.historique', compact('ventes'));
    }

    public function cartStore(Request $request)
{
    $product_qty = $request->input('product_qty', 1); // Assurer une quantité par défaut de 1
    $product_id = $request->input('product_id');
    $mode_paiement = $request->input('mode_buy');
    $product = Produit::getProduit($product_id);
    $subCategories = SubCategory::with('categorie')->get();

    // Vérifier si le produit existe déjà dans le panier
    $cartItem = Cart::instance('facture')->search(function ($cartItem) use ($product_id) {
        return $cartItem->id == $product_id;
    })->first();

    if ($cartItem) {
        // Si le produit est déjà dans le panier, on ne l'ajoute pas à nouveau
        $response['status'] = false;
        $response['message'] = "Ce produit est déjà ajouté à la facture.";
        $response['total'] = Cart::subtotal();
        $response['cart_count'] = Cart::instance('facture')->count();
    } else {
        // Ajouter le produit seulement s'il n'est pas dans le panier
        $result = Cart::instance('facture')->add(
            $product_id,
            $product[0]['subcategory']['nom'] . ' ' . $product[0]['model'],
            1,
            $product[0]['prix_vente']
        )->associate('App\Models\Produit');

        // Ajouter la garantie
        Cart::instance('facture')->update($result->rowId, ['options' => ['garantie' => $product[0]['garantie'] ?? "1"]]);

        if ($result) {
            $response['status'] = true;
            $response['message'] = "Produit ajouté à la facture.";
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('facture')->count();
        }
    }

    // Si la requête est en AJAX, on retourne la mise à jour de l'interface
    if ($request->ajax()) {
        if ($mode_paiement == 'paiement') {
            $facture = view('admin.layouts._facture-list')->render();
        } elseif ($mode_paiement == 'deal') {
            $facture = view('admin.layouts._deal-facture-list', compact('subCategories'))->render();
        } elseif ($mode_paiement == 'acompte') {
            $facture = view('admin.layouts._acompte-list', compact('subCategories'))->render();
        }

        $response['cart'] = $facture;
    }

    return response()->json($response);
}

    public function cartDelete(Request $request)
    {

        $id = $request->input('cart_id');
        $mode_paiement = $request->input('mode_buy');

        $result = Cart::instance('facture')->remove($id);
        $response['status'] = true;
        $response['total'] = Cart::subtotal();
        $response['message'] = 'produit bien supprimé de la facture';
        $response['cart_count'] = Cart::instance('shopping')->count();
        if ($request->ajax()) {
            if ($mode_paiement == 'paiement') {
                $facture = view('admin.layouts._facture-list')->render();
            } else if ($mode_paiement == 'deal') {
                $facture = view('admin.layouts._deal-facture-list')->render();
            } else if ($mode_paiement == 'acompte') {
                $facture = view('admin.layouts._acompte-list')->render();
            }
            $response['cart'] = $facture;
        }
        return json_encode($response);
    }

    public function cartUpdate(Request $request)
    {
        $this->validate($request, [
            'price' => 'required|numeric',
        ]);
        $rowId = $request->input('rowId');
        $price = $request->input('price');
        $mode_paiement = $request->input('mode_buy');
        // return dd($mode_paiement);

        if ($price < 1) {
            $message = "Vous ne pouvez pas ajouter un produit avec un prix inferieur a 1";
            $response['status'] = false;
        } else {
            Cart::instance('facture')->update($rowId, ['price' => $price]);
            // return dd(Cart::instance('facture')->content());
            $message = "Prix produit mise a jour avec success";
            $response['status'] = true;
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('facture')->count();
        }
        if ($request->ajax()) {
            if ($mode_paiement == 'paiement') {
                $facture = view('admin.layouts._facture-list')->render();
            } else if ($mode_paiement == 'deal') {
                $facture = view('admin.layouts._deal-facture-list')->render();
            } else if ($mode_paiement == 'acompte') {
                $facture = view('admin.layouts._acompte-list')->render();
            }
            $response['cart'] = $facture;
            $response['message'] = $message;
        }
        return $response;
    }

    public function paiementView()
    {
        return view('admin.layouts._facture-list');
    }
    public function dealView()
    {
        $subCategories = SubCategory::with('categorie')->get();

        return view('admin.layouts._deal-facture-list', compact('subCategories'));
    }
   
    public function acompteView()
    {
        $subCategories = SubCategory::with('categorie')->get();

        return view('admin.layouts._acompte-list', compact('subCategories')); // Vérifiez bien le nom de la vue ici
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $lastInvoice = Order::orderBy('created_at', 'desc')->first();
        $newInvoiceNumber = 'INV-000001';

        if ($lastInvoice) {
            // Extraire le dernier numéro de facture
            $lastInvoiceNumber = intval(str_replace('INV-', '', $lastInvoice->order_number));
            $newInvoiceNumber = 'INV-' . str_pad($lastInvoiceNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            // Si aucune facture n'existe, démarrer avec un numéro de base
            $newInvoiceNumber = 'INV-000001';
        }
        // $produits = Produit::with('fournisseur')->with('subcategory')->get();
        //    dd($carts);
        $produits = [];

        return view('admin.ventes.index', compact('produits', 'newInvoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return dd($request);
        $products = [];
        $i = 0;
        $cart = Cart::instance('facture')->content();
        $total = Cart::subtotal(00, '', '') - $request->input('reduction');
        $status_save = false;
        // Définition des messages d'erreur personnalisés
        $messages = [
            'order_number.required' => 'Le numéro de commande est requis.',
            'order_number.string' => 'Le numéro de commande doit être une chaîne de caractères.',
            'order_number.unique' => 'Le numéro de commande doit être unique.',
            'produits.required' => 'Le champ des produits est requis.',
            'produits.json' => 'Le champ des produits doit être un JSON valide.',
            'prix_total.required' => 'Le prix total est requis.',
            'prix_total.numeric' => 'Le prix total doit être un nombre.',
            'prix_total.min' => 'Le prix total ne peut pas être inférieur à 0.',
            'mode_achat.required' => 'Le mode d\'achat est obligatoire.',
            'mode_achat.in' => 'Le mode d\'achat doit être l\'une des valeurs suivantes : deal, paiement, acompte.',
            'nom.required' => 'Le nom est requis.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenoms.required' => 'Les prénoms sont requis.',
            'prenoms.string' => 'Les prénoms doivent être une chaîne de caractères.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'telephone.required' => 'Le numéro de téléphone est requis.',
            'telephone.regex' => 'Le numéro de téléphone doit être valide.',
            'produits.not_empty_json' => 'Le champ produits ne doit pas être vide.',

        ];

        // Construction du tableau des produits
        foreach ($cart as $product) {
            $products['product_' . $i][] = $product->id;
            $products['product_' . $i][] = $product->name;
            $products['product_' . $i][] = $product->price;
            $products['product_' . $i][] = $product->qty;
            $products['product_' . $i][] = $product->options->garantie ?? 'Non spécifiée'; // Ajout de la garantie
            $i++;
        }

        // Préparation des données pour la validation
        $data = [
            'order_number' => $request->input('order_number'),
            'produits' => json_encode($products),
            'mode_achat' => $request->input('mode_achat'),
            'prix_total' => $total,
            'nom' => $request->input('nom'),
            'prenoms' => $request->input('prenoms'),
            'email' => $request->input('email'),
            'telephone' => $request->input('phone'),
        ];

        // Messages de validation personnalisés
        // $messages = [
        //     'produits.not_empty_json' => 'Le champ produits ne doit pas être vide.',
        // ];

        // Validation des données
        $validator = Validator::make($data, [
            'order_number' => 'required|string|unique:orders,order_number',
            
            'produits' => [
                'required',
                'json',
                function ($attribute, $value, $fail) {
                    $decoded = json_decode($value, true);
                    if (!is_array($decoded) || empty($decoded)) {
                        $fail('Le champ produits doit contenir une liste valide et ne doit pas être vide.');
                    }
                },
            ],
            
            'mode_achat' => 'required|in:deal,paiement,acompte',
            'prix_total' => 'required|numeric|min:500',
            
            'nom' => 'required|string|max:255',
            'prenoms' => 'nullable|string|max:255',
            
            'email' => 'nullable|email|max:255',
            
            'telephone' => [
                'required',
                'regex:/^(\+?\d{1,3}|\d{1,4})?\d{7,}$/', 
            ],
        ], $messages);
        


        // Si la validation échoue
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier si le client existe déjà
        $clientExiste = Client::where([
            ['nom', '=', $request->input('nom')],
            ['prenoms', '=', $request->input('prenoms')]
        ])->first();

        // Si le client n'existe pas, le créer
        if (!$clientExiste) {
            $client = new Client();
            $client->nom = $request->input('nom');
            $client->prenoms = $request->input('prenoms');
            $client->email = $request->input('email');
            $client->telephone = $request->input('phone');
            $status = $client->save();

            if (!$status) {
              return back()->with('error','Erreur lors de la création du client');
            }

            $clientExiste = $client;
        }

        // Créer la commande
        $order = new Order();
        $order->order_number = $data['order_number'];
        $order->client_id = $clientExiste->id;
        $order->reduction = $request->input('reduction');
        $order->acompte = $request->input('acompte');
        $order->produits = $data['produits'];
        $order->prix_total = $data['prix_total'];
        $order->mode_achat = $data['mode_achat'];

        // Sauvegarder la commande
        $status_save = $order->save();
        // Vérifier si la sauvegarde a réussi
        // if ($status_save) {
        //     return dd('La facture est sauvegardée avec succès');
        // } else {
        //     return dd('Erreur lors de la sauvegarde de la facture');
        // }

        if ($status_save) {
            // Mettre à jour le statut des produits
            if ($data['mode_achat'] == 'deal') {
                $produit = new Produit();
                $produit->prix_achat = $request->input('prix_achat');
                $produit->prix_vente = $request->input('prix_vente');
                $produit->prix_minimum = $request->input('prix_minimum');
                $produit->model = $request->input('model');
                $produit->subcategory_id = $request->input('subcategory_id');
                $produit->quantite = 1;
                $produit->status = 'en_stock';
                $produit->provenance = 'deal';
                do {
                    $code_bar = Str::random(10); // Génère un code aléatoire de 10 caractères
                } while (Produit::where('code_bar', $code_bar)->exists());
                $produit->code_bar = $code_bar;
                $status = $produit->save();
            }

            foreach ($cart as $product) {
                // Trouver le produit dans la base de données
                $productModel = Produit::find($product->id); // Supposons que l'ID du produit soit dans $product->id
                if ($productModel) {
                    // Mettre à jour le statut à "vendu"
                    $productModel->status = 'vendu';
                    $productModel->save();
                }
            }
            Cart::instance('facture')->destroy();
            // Retourner un message de succès
            return redirect()->route('factures.print', ['id' => $order->id])
            ->with('success', 'Commande validée. Impression en cours...');        } else {
            return back()->with('error','Erreur lors de la sauvegarde de la facture');

        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $order = Order::where('id', $id)->with('client')->first();
        //  return dd($order);

        return view('admin.ventes.detail', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function print($id)
    {
        //
        $facture = Order::with('client')->findOrFail($id);

        return view('admin.ventes.print', compact('facture'));
    }

    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $facture)
    {
       $facture->acompte+=$request->input('acompte');
       $status = $facture->update();
       if ($status) {
        return redirect()->route('factures.print', ['id' => $facture->id])
        ->with('success', 'Commande validée. Impression en cours...');  
       } else {
       return back()->with('error','Erreur lors de la mise a jour de la facture');
       }
       

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

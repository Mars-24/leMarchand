<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clients = Client::all();
        return view('admin.clients.index',compact('clients'));
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
        $status = Client::create($data);
        if ($status) {
            return redirect()->route('clients.index')->with('success','Client crée');
        } else {
            return redirect()->route('clients.index')->with('error','Erreur lors de la creation de la client');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $client = Client::find($id);
        return view('admin.clients.details',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    public function findClient(Request $request){
            // Récupérer la valeur saisie par l'utilisateur
    $client = Client::where('nom', 'like', $request->input('nom') . '%')->first();

    if ($client) {
        return response()->json([
            'exists' => true,
            'prenoms' => $client->prenoms,
            'email' => $client->email,
            'phone' => $client->telephone,
        ]);
    } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}

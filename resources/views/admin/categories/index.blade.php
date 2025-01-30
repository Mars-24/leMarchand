@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
                <h1>Categorie Principale</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Categorie Principale
                </p>
            </div>
            @include('admin.layouts.errors-infos')
            <div class="row">
                <div class="col-xl-4 col-lg-12">
                    <div class="ec-cat-list card card-default mb-24px">
                        <div class="card-body">
                            <div class="ec-cat-form">
                                <h4>Ajouter une nouvelle Categorie</h4>

                                <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Nom</label>
                                        <div class="col-12">
                                            <input id="text" name="nom" class="form-control here slug-title"
                                                type="text" placeholder="Nom de la categorie">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12 col-form-label">Description</label>
                                        <div class="col-12">
                                            <textarea id="fulldescription" name="description" cols="40" rows="4" class="form-control"
                                                placeholder="Description"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-form-label">Photo</label>
                                        <div class="col-12">
                                            <input id="text" name="photo" class="form-control here slug-title"
                                                type="file" placeholder="Ajouter une photo ">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button name="submit" type="submit"
                                                class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="ec-cat-list card card-default">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="responsive-data-table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Thumb</th>
                                            <th>Nom</th>
                                            <th>Sous Categories</th>
                                            <th>Produit</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($categories as $categorie)
                                            <tr>
                                                <td><img class="cat-thumb" src="{{ asset($categorie->photo) }}"
                                                        alt="Product Image" /></td>
                                                <td>{{ $categorie->nom }}</td>
                                                <td>
                                                    <span class="ec-sub-cat-list">
                                                        <span class="ec-sub-cat-count" title="Total Sub Categories"> {{ $categorie->sub_categories_count}}</span>

                                                    </span>
                                                </td>
                                                <td>{{ $categorie->products_count}}</td>
                                                
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
@endsection

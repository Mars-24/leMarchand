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
                                <h4>{{ isset($editCategorie) ? 'Modifier la Categorie' : 'Ajouter une nouvelle Categorie' }}</h4>
                
                                <form method="POST" 
                                    action="{{ isset($editCategorie) ? route('categories.update', $editCategorie->id) : route('categories.store') }}" 
                                    enctype="multipart/form-data">
                                    
                                    @csrf
                                    @if(isset($editCategorie))
                                        @method('PUT')
                                    @endif
                
                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Nom</label>
                                        <div class="col-12">
                                            <input id="text" name="nom" class="form-control here slug-title" type="text" 
                                                placeholder="Nom de la categorie"
                                                value="{{ isset($editCategorie) ? $editCategorie->nom : old('nom') }}">
                                        </div>
                                    </div>
                
                                    <div class="form-group row">
                                        <label class="col-12 col-form-label">Photo</label>
                                        <div class="col-12">
                                            <input id="photo" name="photo" class="form-control" type="file">
                                            @if(isset($editCategorie) && $editCategorie->photo)
                                                <img src="{{ asset('storage/' . $editCategorie->photo) }}" width="100px" class="mt-2">
                                            @endif
                                        </div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-12">
                                            <button name="submit" type="submit" class="btn btn-primary">
                                                {{ isset($editCategorie) ? 'Modifier' : 'Enregistrer' }}
                                            </button>
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
                                            <th>Image</th>
                                            <th>Nom</th>
                                            <th>Sous Categories</th>
                                            <th>Produit</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($categories as $categorie)
                                            <tr>
                                                <td>
                                                    <img class="cat-thumb" src="{{ asset('storage/' .$categorie->photo) }}"
                                                        alt="Product Image" />
                                                    </td>
                                                <td>{{ $categorie->nom }}</td>
                                                <td>
                                                    <span class="ec-sub-cat-list">
                                                        <span class="ec-sub-cat-count" title="Total Sub Categories"> {{ $categorie->sub_categories_count}}</span>

                                                    </span>
                                                </td>
                                                <td>{{ $categorie->products_count}}</td>
                                                <td>
                                                    <div class="btn-group mb-1">
                                                        <button type="button" class="btn btn-outline-success">Info</button>
                                                        <button type="button"
                                                            class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                            data-display="static">
                                                            <span class="sr-only">Info</span>
                                                        </button>
        
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('categories.index', ['edit' => $categorie->id]) }}">Éditer</a>
                                                            <form action="{{ route('categories.destroy', $categorie->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <a class="dropdown-item btn-delete-icon" href="#"
                                                                    data-id="{{ $categorie->id }}">Supprimer</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                
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
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.btn-delete-icon').click(function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();
            swal({
                    title: "êtes vous sure?",
                    text: "Une fois supprimé,vous ne pouvez plus recuperer le fichier!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! Categorie à été supprimé!", {
                            icon: "success",
                        });
                    } else {
                        swal("Suppression annulée");
                    }
                });
        });
    </script>
    <script src="{{asset('plugins/data-tables/jquery.datatables.min.js')}}"></script>
	<script src="{{asset('/plugins/data-tables/datatables.bootstrap5.min.js')}}"></script>
	<script src="{{asset('plugins/data-tables/datatables.responsive.min.js')}}"></script>
@endsection
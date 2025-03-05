@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
                <h1>Marques</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Marques
                </p>
            </div>
            @include('admin.layouts.errors-infos')
            <div class="row">
                <div class="col-xl-4 col-lg-12">
                    <div class="ec-cat-list card card-default mb-24px">
                        <div class="card-body">
                            <div class="ec-cat-form">
                                <h4>Ajouter une marque</h4>

                                <form method="POST" 
                                action="{{ isset($editSubCategorie) ? route('subCategory.update', $editSubCategorie->id) : route('subCategory.store') }}">
                                @csrf
                                @if(isset($editSubCategorie))
                                    @method('PUT')
                                @endif
                            
                                <div class="form-group row">
                                    <label for="parent-category" class="col-12 col-form-label">Categorie </label>
                                    <div class="col-12">
                                        <select id="parent-category" name="categorie_id" class="custom-select">
                                            <option value="default" disabled>Type produit</option>
                                            @foreach ($categories as $categorie)
                                                <option value="{{ $categorie->id }}" 
                                                    {{ isset($editSubCategorie) && $editSubCategorie->categorie_id == $categorie->id ? 'selected' : '' }}>
                                                    {{ $categorie->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label for="text" class="col-12 col-form-label">Nom de la marque</label>
                                    <div class="col-12">
                                        <input id="text" name="nom" class="form-control here slug-title"
                                            type="text" value="{{ old('nom', $editSubCategorie->nom ?? '') }}">
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-12">
                                        <button name="submit" type="submit" class="btn btn-primary">
                                            {{ isset($editSubCategorie) ? 'Modifier' : 'Enregistrer' }}
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
                                            <th>Icones</th>
                                            <th>Nom</th>
                                            <th>Categories</th>
                                            <th>Produits</th>
                                            <th>Total vendu</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($subcategories as $subcategorie)
                                            <tr>
                                                <td>
                                                    <img class="cat-thumb"
                                                        src="{{ asset('storage/' .$subcategorie->categorie->photo) }}"
                                                        alt="product image" />
                                                </td>
                                                <td>{{ $subcategorie->nom }}</td>
                                                <td>
                                                    <span class="ec-sub-cat-list">
                                                        <span
                                                            class="ec-sub-cat-tag">{{ $subcategorie->categorie->nom }}</span>
                                                    </span>
                                                </td>
                                                <td>{{ $subcategorie->products_count }}</td>
                                                <td>{{$subcategorie->sold_products_count}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-outline-success">Info</button>
                                                        <button type="button"
                                                            class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" data-display="static">
                                                            <span class="sr-only">Info</span>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('subCategory.edit', $subcategorie->id) }}">Éditer</a>
                                                            <form action="{{ route('subCategory.destroy', $subcategorie->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <a class="dropdown-item btn-delete-icon" href="#"
                                                                    data-id="{{ $subcategorie->id }}">Supprimer</a>
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

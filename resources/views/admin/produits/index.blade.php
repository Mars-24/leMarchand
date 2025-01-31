@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Produit</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Dashboard</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Produit
                    </p>
                </div>
                <div>
                    <a href="{{ route('produits.create') }}" class="btn btn-primary"> Ajouter Produit</a>
                </div>
            </div>
            @include('admin.layouts.errors-infos')

            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="responsive-data-table" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Nom</th>
                                            <th>Model</th>
                                            <th>Prix de vente</th>
											<th>Prix d'achat</th>
                                            <th>Prix Minimuim</th>
                                            <th>Code Bar</th>
                                            <th>Fournisseur</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($produits as $produit)
                                            <tr>
                                                <td>
                                                    @if ($produit->photo)
                                                        <img  class="tbl-thumb" src="{{ asset('storage/' . $produit->photo) }}" alt="Product Image">
                                                    @else
                                                        <img class="tbl-thumb" src="{{asset('img/products/p6.jpg')}}"
                                                            alt="Product Image" />
                                                </td>
                                        @endif
                                        <td>{{ $produit->subcategory->nom }}</td>
                                        <td>{{ $produit->model }}</td>
                                        <td>{{ number_format($produit->prix_vente,'0',',','.') }} fr</td>
										<td>{{ number_format($produit->prix_achat,'0',',','.') }} fr</td>
                                        <td>{{ number_format($produit->prix_minimum,'0',',','.') }} fr</td>
                                        <td onclick="window.print()">
                                            @php
                                                $barcode = new \Milon\Barcode\DNS1D();
                                            @endphp
                                            {!! $barcode->getBarcodeHTML($produit->code_bar, 'C128') !!}
                                        </td>
                                        <td>{{ $produit->fournisseur->nom }} {{ $produit->fournisseur->prenoms }}
                                        </td>
                                        <td>{{ $produit->status }}</td>
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
                                                    <a class="dropdown-item" href="{{route('produits.edit',$produit->id)}}">Editer</a>
                                                    <a class="dropdown-item" href="{{route('produits.show',$produit->id)}}">Details</a>
                                                    <form action="{{ route('produits.destroy', $produit->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <a class="dropdown-item btn-delete-icon" href="#"
                                                            data-id="{{ $produit->id }}">Supprimer</a>
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
                    text: "OUne fois supprimé,vous ne pouvez plus recuperer le fichier!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! le client à été supprimé!", {
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

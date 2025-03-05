@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2">
                <h1>Historique des acomptes</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Historique des acomptes
                </p>
            </div>
            @include('admin.layouts.errors-infos')
            <div class="row">
                <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                    <div class="card card-mini dash-card card-1">
                        <div class="card-body">
                            <h2 class="mb-1">{{number_format($totalRestant,'0',',','.')}} fr</h2>
                            <p>Total prix acomptes</p>
                            <span class="mdi mdi-account-arrow-left"></span>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="responsive-data-table" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Client</th>
                                            <th>Email</th>
                                            <th>produits</th>
                                            <th>Prix</th>
                                            <th>Paiement</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($ventes as $vente)
                                            <tr>
                                                <td>{{ $vente->order_number }}</td>
                                                <td>{{ $vente->client->nom }}</td>
                                                @if ($vente->client->email)
                                                    <td>{{ $vente->client->email }}</td>
                                                @else
                                                    <td>email non renseigné</td>
                                                @endif
                                                @php
                                                    $jsonString = $vente->produits;
                                                    $jsonDecoded = json_decode($jsonString, true);
                                                @endphp
                                                <td>{{ count($jsonDecoded) }}</td>
                                                <td>{{ number_format($vente->prix_total, '0', ',', '.') }} frCFA</td>
                                                <td>{{ $vente->mode_achat }}</td>
                                                <td>
                                                    @if ($vente->mode_achat == 'acompte' && $vente->acompte < $vente->prix_total)
                                                        <span class="mb-2 mr-2 badge badge-danger">Acompte</span>
                                                    @elseif ($vente->mode_achat == 'deal')
                                                        <span class="mb-2 mr-2 badge badge-primary">Deal</span>
                                                    @elseif($vente->mode_achat == 'paiement')
                                                        <span class="mb-2 mr-2 badge badge-success">Vendu</span>
                                                    @else
                                                        <span class="mb-2 mr-2 badge badge-success">Vendu</span>
                                                    @endif

                                                </td>
                                                <td>{{ $vente->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <div class="btn-group mb-1">
                                                        <button type="button" class="btn btn-outline-success">Info</button>

                                                        <button type="button"
                                                            class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" data-display="static">
                                                            <span class="sr-only">Info</span>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                                href="{{ route('factures.show', $vente->id) }}">Detail</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('factures.print', $vente->id) }}">Imprimer</a>
                                                                <form action="{{ route('factures.destroy', $vente->id) }}" style="cursor: pointer"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                <a class="dropdown-item btn-delete-icon"  data-id="{{ $vente->id }}">Supprimer</a>
                                                            </form>

                                                            <a class="dropdown-item"  href="#">Annuler</a>
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
                    swal("Poof! le client à été supprimé!", {
                        icon: "success",
                    });
                } else {
                    swal("Suppression annulée");
                }
            });
    });
</script>
    <!-- Datatables -->
    <script src="{{ asset('plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plugins/data-tables/datatables.responsive.min.js') }}"></script>
@endsection

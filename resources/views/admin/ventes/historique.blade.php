@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2">
                <h1>Historique des ventes</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Historique
                </p>
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
                                                            <a class="dropdown-item" href="#">Cancel</a>
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
    <!-- Datatables -->
    <script src="{{ asset('plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plugins/data-tables/datatables.responsive.min.js') }}"></script>
@endsection

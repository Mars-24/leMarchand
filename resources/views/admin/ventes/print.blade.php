@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-6 col-sm-12 card invoice border-radius border bg-white p-4 m-2">
        <div class="text-center print-section">
            <h3 class="text-dark font-weight-medium text-center">Le Marchand</h3>
            <p>Agbalepedo,Rond Point Oeuf près du marché cacaveli</p>
            <p>Tél: +228 92 86 06 75</p>
        </div>

        <div class="row pt-5">

            <div class="print-para invoice-header mb-3">
                <div>
                    <p><strong>Facture : {{ $facture->order_number }}</strong></p>

                </div>
                {{-- <div>
                <img src="logo.png" alt="Le Marchand">
            </div> --}}
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <p class="text-dark mb-2 no-print">A</p>
                <p class="text-dark mb-2 print-para">Client : {{ $facture->client->nom . ' ' . $facture->client->prenoms }}
                </p>
                <p class="text-dark mb-2 print-para">Tel : {{ $facture->client->telephone }}</p>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12 mb-2 mt-2">
                <p class="text-dark mb-2">Details :</p>
                <p class="text-dark mb-2 no-print">Date :     {{ ($facture->updated_at > $facture->created_at ? $facture->updated_at : $facture->created_at)->format('d/m/Y H:i') }}
                </p>
                <p class="text-dark mb-2 print-para">Paiement :

                    @switch($facture->mode_achat)
                        @case('paiement')
                            Comptant
                        @break

                        @case('acompte')
                            Acompte
                        @break

                        @case('deal')
                            Deal
                        @break

                        @default
                    @endswitch
                </p>
            </div>
        </div>
        <div id="facture-table">
            <table class="table mt-3 table-striped table-responsive table-responsive-large inv-tbl" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>produit</th>
                        <th>prix</th>
                        <th>Garantie</th>
                    </tr>
                </thead>
                @php
                    $produits = json_decode($facture->produits, true);
                @endphp
                <tbody>
                    @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $produit[1] }} </td>

                            <td>
                                {{ number_format($produit[2], '0', ',', '.') }} FR

                            </td>
                            <td>{{ $produit[3] }} semaine(s)</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="justify-end text-right mr-3">
                <div class="col-lg-3 col-xl-3 col-xl-3 ml-sm-auto">
                    <ul class="list-unstyled mt-3">
                        @if ($facture->reduction > 0)
                            <li class="mid pb-3 text-dark"> Total partiel :
                                {{ number_format($facture->prix_total + $facture->reduction, '0', ',', '.') }} FR
                            </li>

                            <li class="mid pb-3 text-dark">Réduction :
                                {{ number_format($facture->reduction, '0', ',', '.') }} FR
                            </li>

                            <li class="pb-3 text-dark">Total :
                                {{ number_format($facture->prix_total, '0', ',', '.') }} FR
                            </li>
                            @elseif ($facture->acompte > 0)
                            <li class="mid pb-3 text-dark">Acompte :
                                {{ number_format($facture->acompte, '0', ',', '.') }} FR
                            </li>

                            <li class="pb-3 text-dark">Reste à payer :
                                {{ number_format($facture->prix_total - $facture->acompte, '0', ',', '.') }} FR
                            </li>
                            @else

                            <li class="pb-3 text-dark">Total :
                                {{ number_format($facture->prix_total, '0', ',', '.') }} FR
                            </li>
                        @endif


                      
                    </ul>
                </div>
            </div>
        </div>
        <div class="invoice-footer text-center ">
            <p>Merci pour votre achat !</p>
        </div>

    </div>
    <style>
        @media print {

            footer,
            header,
            .ec-left-sidebar,
            .breadcrumb-wrapper-2,
            .del-btn {
                visibility: hidden;
                display: none;

            }

            span {
                display: flex;
                flex-direction: row;
                justify-content: flex-start;

            }

            span input {
                margin: 0;
                /* Supprime tout espace ou marge entre les inputs */
                padding: 0;
                /* Facultatif : Ajuste l'espace interne (intérieur des champs) */
                border-radius: 0;
                /* Facultatif : Pour des bords nets */
            }

            .print-para {
                display: block;
            }

            .invoice {
                display: block;
                visibility: visible;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                margin: 5px;
                padding: 0 !important;
            }
          .adresse-print {
                display: flex;
                flex-direction: row;
                justify-content: space-around;
            }

            #name_client {
                margin-right: 2px;
            }

            #prenoms_client {
                margin-left: -100px;

            }

            .input-print {
                display: inline;
            }

            address input {
                border: none;
                margin: 0;
                padding: 0;
                text-align: left;
                width: unset;
            }

            .invoice-table th {
                background: #fff !important;
            }

            body {
                color: #000;
            }

            * {
                font-size: 11.5px !important;
                background-color: #fff !important;
                color: #000;

            }
            h3{
    font-size: 19px !important;
    margin-bottom: 5px;
}
  
            .invoice-wrapper .inv-tbl tbody tr:nth-of-type(odd)>* {
                background: #fff !important;
                color: #000
            }

            .table-striped>tbody>tr:nth-of-type(odd)>* {
                --bs-table-accent-bg: white !important;
                color: #000
            }

            thead th {
                color: #000
            }

            .text-dark {
                color: #000 !important
            }

            td {
                border-style: none;
            }

            .inc-total {
                margin-top: 10px;
            }

            .invoice-header {
                margin-top: -20px;
                display: flex;
                justify-content: space-between;
            }

        }
    </style>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print(); // Lance l'impression
        window.onafterprint = function() {
            window.location.href = "{{ route('factures.create') }}"; // Redirige après impression
        };
    });
</script>
@endsection
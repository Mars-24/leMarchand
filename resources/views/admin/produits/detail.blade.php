@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Produit Detail</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Dashboard</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Produit
                    </p>
                </div>
                <div>
                    <a href="{{route('produits.edit',$produit->id)}}" class="btn btn-primary"> Edit
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Produit Detail</h2>
                        </div>

                        <div class="card-body product-detail">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6">
                                    <div class="row">
                                        <div class="single-pro-img">
                                            <div class="single-product-scroll">
                                                <div class="single-product-cover">
                                                    @if ($produit->fournisseur->photo)
                                                        <div class="single-slide zoom-image-hover">
                                                            <img class="img-responsive"
                                                                src="{{ asset('storage/' . $produit->photo) }}"
                                                                alt="">
                                                        </div>
                                                    @else
                                                        <div class="single-slide zoom-image-hover">
                                                            <img class="img-responsive"
                                                                src="{{ asset($produit->subcategory->categorie->photo) }}" alt="">
                                                        </div>
                                                    @endif
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-6">
                                    <div class="row product-overview">
                                        <div class="col-12">
                                            <h5 class="product-title">{{ $produit->model }}</h5>
                                            <div id="printableBarcode">
                                                <p class="product-rate">
                                                    @php
                                                        $barcode = new \Milon\Barcode\DNS1D();
                                                    @endphp
                                                    <img src="data:image/png;base64,{{ $barcode->getBarcodePNG($produit->code_bar, 'C128') }}"
                                                        alt="barcode" />
                                                </p>
                                            </div>
                                            <div class="ec-ofr">
                                                <h6>Prix & détails du téléphone :</h6>
                                                <ul>
                                                    <li><b>Prix minimum :</b> {{ $produit->prix_minimum }} CFA </li>
                                                    <li><b>Prix de vente :</b> {{ $produit->prix_vente }} CFA</li>
                                                    <li><b>Prix d'achat :</b> {{ $produit->prix_achat }} CFA</li>
                                                </ul>
                                            </div>
                                            <p class="product-price">Prix minimum de vente: {{ $produit->prix_minimum }} CFA
                                            </p>
                                            <ul class="product-size">
                                                <li class="size" onclick="printBarcode()"><span>Imprimer Code Bar</span>
                                                </li>
                                            </ul>
                                    
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-12 u-card">
                                    <div class="card card-default seller-card">
                                        <div class="card-body text-center">
                                            <a href="javascript:0" class="text-secondary d-inline-block">
                                                <div class="image mb-3">

                                                    @if ($produit->fournisseur->photo)
                                                        <img src="{{ asset('storage/' . $produit->fournisseur->photo) }}"
                                                            class="img-fluid rounded-circle" alt="Avatar Image">
                                                    @else
                                                        <img src="{{ asset('img/user/u-xl-4.jpg') }}"
                                                            class="img-fluid rounded-circle" alt="Avatar Image">
                                                    @endif
                                                </div>

                                                <h5 class="text-dark">Fournisseur : {{ $produit->fournisseur->nom }}</h5>
                                                <p class="product-rate">
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star"></i>
                                                </p>

                                                <ul class="list-unstyled">
                                                    <li class="d-flex mb-1">
                                                        <i class="mdi mdi-map mr-1"></i>
                                                        @if ($produit->fournisseur->adresse)
                                                        <span>{{ $produit->fournisseur->adresse }}</span>

                                                        @else
                                                        <span>Adresse non renseigné</span>
 
                                                        @endif
                                                    </li>
                                                    <li class="d-flex mb-1">
                                                        <i class="mdi mdi-email mr-1"></i>
                                                        <span>{{ $produit->fournisseur->email }}</span>
                                                    </li>
                                                    <li class="d-flex">
                                                        <i class="mdi mdi-whatsapp mr-1"></i>
                                                        <span>{{ $produit->fournisseur->telephone }}</span>
                                                    </li>
                                                </ul>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printableBarcode, #printableBarcode * {
                visibility: visible;
            }
            #printableBarcode {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                text-align: center;
                /* margin: 60px; */
            }
        }
    </style>
    
@endsection
@section('script')
    <script>
        function printBarcode() {
            window.print();
        }
    </script>
@endsection

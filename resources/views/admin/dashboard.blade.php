@extends('admin.layouts.master')
@section('content')
<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">

        <div class="row mb-4">
            <div class="col-12 text-right">
                <label for="periodeSelect">Filtrer par :</label>
                <select id="periodeSelect" class="form-control w-25 d-inline-block">
                    <option value="jour" selected>Jour</option>
                    <option value="mois" >Mois</option>
                    <option value="annee">Année</option>
                </select>
            </div>
        </div>
                                                
        <!-- Top Statistics -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <h2 class="mb-1">{{$clientsTodayCount}}</h2>
                        <p>clients Journaliers</p>
                        <span class="mdi mdi-account-arrow-left"></span>
                    </div>
                </div>
            </div>
           
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-3">
                    <div class="card-body">
                        <h2 class="mb-1">{{$ordersTodayCount}}</h2>
                        <p>Ventes journaliers</p>
                        <span class="mdi mdi-package-variant"></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <h2 class="mb-1">{{$produit_stock}}</h2>
                        <p>Produit en stock</p>
                        <span class="mdi mdi-currency-XOF"></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-2">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($fondCaisse,'0',',','.')}} FrCFA</h2>
                        <p>Fond de caisse</p>
                        <span class="mdi mdi-account-clock"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row stats-jour">
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($totalMontant,'0',',','.')}} FrCFA</h2>
                        <p>Dépenses Journalières</p>
                        <span class="mdi mdi-account-arrow-left"></span>
                    </div>
                </div>
            </div>          
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($totalPriceToday,'0',',','.')}}  FrCFA</h2>
                        <p>Chiffre d'affaire journalier</p>
                        <span class="mdi mdi-currency-XOF"></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($margeBruteToday,'0',',','.')}} FrCFA</h2>
                        <p>Marge brute Journalière</p>
                        <span class="mdi mdi-account-arrow-left"></span>
                    </div>
                </div>
            </div>          
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($margeNetteToday,'0',',','.')}}  FrCFA</h2>
                        <p>Marge nette journalière</p>
                        <span class="mdi mdi-currency-XOF"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row stats-mois" style="display: none;">
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($totalMontantMonth,'0',',','.')}} FrCFA</h2>
                        <p>Depenses mensuelle</p>
                        <span class="mdi mdi-account-arrow-left"></span>
                    </div>
                </div>
            </div>          
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($totalPriceThisMonth,'0',',','.')}}  FrCFA</h2>
                        <p>Chiffre d'affaire mensuelle</p>
                        <span class="mdi mdi-currency-XOF"></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($margeBruteMonth,'0',',','.')}} FrCFA</h2>
                        <p>Marge brute mensuelle</p>
                        <span class="mdi mdi-account-arrow-left"></span>
                    </div>
                </div>
            </div>          
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($margeNetteMonth,'0',',','.')}}  FrCFA</h2>
                        <p>Marge nette mensuelle</p>
                        <span class="mdi mdi-currency-XOF"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row stats-annee" style="display: none;">
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($totalMontantYear,'0',',','.')}} FrCFA</h2>
                        <p>Depenses Annuelle</p>
                        <span class="mdi mdi-account-arrow-left"></span>
                    </div>
                </div>
            </div>          
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($totalPriceThisYear,'0',',','.')}}  FrCFA</h2>
                        <p>Chiffre d'affaire Annuelle</p>
                        <span class="mdi mdi-currency-XOF"></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($margeBruteYear,'0',',','.')}} FrCFA</h2>
                        <p>Marge brute Annuelle</p>
                        <span class="mdi mdi-account-arrow-left"></span>
                    </div>
                </div>
            </div>          
            <div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <h2 class="mb-1">{{number_format($margeNetteYear,'0',',','.')}}  FrCFA</h2>
                        <p>Marge nette Annuelle</p>
                        <span class="mdi mdi-currency-XOF"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-md-12 p-b-15">
                <!-- Sales Graph -->
                <div id="user-acquisition" class="card card-default">
                    <div class="card-header">
                        <h2>Rapport sur les ventes</h2>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-style-border justify-content-between justify-content-lg-start border-bottom"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#todays" role="tab"
                                    aria-selected="true">Aujourd'hui</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#monthly" role="tab"
                                    aria-selected="false">Mensuelle </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#yearly" role="tab"
                                    aria-selected="false">Annuelle</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="salesReport">
                            <div class="tab-pane fade show active" id="source-medium" role="tabpanel">
                                <div class="mb-6" style="max-height:247px">
                                    <canvas id="salesChart" class="chartjs2"></canvas>
                                    <div id="acqLegend" class="customLegend mb-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-12 p-b-15">
                <!-- Doughnut Chart -->
                <div class="card card-default">
                    <div class="card-header justify-content-center">
                        <h2>Aperçu des commandes</h2>
                    </div>
                    <div class="card-body">
                        <canvas id="doChart"></canvas>
                    </div>
                    <a href="#" class="pb-5 d-block text-center text-muted"><i
                            class="mdi mdi-download mr-2"></i> Download overall report</a>
                    <div class="card-footer d-flex flex-wrap bg-white p-0">
                        <div class="col-6">
                            <div class="p-20">
                                <ul class="d-flex flex-column justify-content-between">
                                    <li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
                                            style="color: #4c84ff"></i>Order Completed</li>
                                    <li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
                                            style="color: #80e1c1 "></i>Order Unpaid</li>
                                    <li><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
                                            style="color: #ff7b7b "></i>Order returned</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 border-left">
                            <div class="p-20">
                                <ul class="d-flex flex-column justify-content-between">
                                    <li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
                                            style="color: #8061ef"></i>Order Pending</li>
                                    <li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
                                            style="color: #ffa128"></i>Order Canceled</li>
                                    <li><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
                                            style="color: #7be6ff"></i>Order Broken</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 p-b-15">
                <!-- Recent Order Table -->
                <div class="card card-table-border-none card-default recent-orders" id="recent-orders">
                    <div class="card-header justify-content-between">
                        <h2>Commandes récentes</h2>
                      
                    </div>
                    <div class="card-body pt-0 pb-5">
                        <div class="table-responsive">
                            <table id="responsive-data-table" class="table" style="width:100%">
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
                                        <td>{{$vente->order_number}}</td>
                                        <td>{{$vente->client->nom}}</td>
                                        <td>{{$vente->client->email}}</td>
                                        @php
                                            $jsonString = $vente->produits;
                                            $jsonDecoded = json_decode($jsonString, true);
                                        @endphp
                                        <td>{{count($jsonDecoded)}}</td>
                                        <td>{{$vente->prix_total}}</td>
                                        <td>{{$vente->mode_achat}}</td>
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
                                        <td>{{$vente->created_at->format('d-m-Y')}}</td>
                                        <td>
                                            <div class="btn-group mb-1">
                                                <button type="button"
                                                    class="btn btn-outline-success">Info</button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('factures.show',$vente->id)}}">Detail</a>
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

        <div class="row">
            <div class="col-xl-5">
                <!-- New Customers -->
                <div class="card ec-cust-card card-table-border-none card-default">
                    <div class="card-header justify-content-between ">
                        <h2>Nouveaux clients</h2>
                        <div>
                            <button class="text-black-50 mr-2 font-size-20">
                                <i class="mdi mdi-cached"></i>
                            </button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                    id="dropdown-customar" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" data-display="static">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item"><a href="#">Action</a></li>
                                    <li class="dropdown-item"><a href="#">Another action</a></li>
                                    <li class="dropdown-item"><a href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-15px">
                        <table class="table ">
                            <tbody>
                                @foreach ($clients as $client)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="media-image mr-3 rounded-circle">
                                                <a href="profile.html">
                                                    
                                                
                                                        @if ($client->photo)
                                                        <img src="{{ asset('storage/' . $client->photo) }}" class="profile-img rounded-circle w-45"
                                                            alt="Avatar Image">
                                                    @else
                                                        <img src="{{ asset('img/user/u-xl-6.jpg') }}" class="profile-img rounded-circle w-45" alt="Avatar Image">
                                                    @endif
                                                    
                                                    </a>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <a href="profile.html">
                                                    <h6 class="mt-0 text-dark font-weight-medium">{{ $client->nom }} {{ $client->prenoms }}</h6>
                                                </a>
                                                <small>@if ($client->email)
                                                    {{$client->email}}
                                                @else
                                                    Pas de email
                                                @endif</small>
                                            </div>
                                        </div>
                                    </td>
                                    @php
                                        $last = count($client->orders)-1;
                                        $commande = count($client->orders);
                                    @endphp
                                    <td> {{$commande}} Commande(s)</td>
                                    <td class="text-dark d-none d-md-block"> {{$client->orders[$last]->prix_total}} fr</td>
                                </tr>
                                @endforeach
                               
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <!-- New Customers -->
                <div class="card ec-cust-card card-table-border-none card-default">
                    <div class="card-header justify-content-between ">
                        <h2>Super clients</h2>
                        <div>
                            <button class="text-black-50 mr-2 font-size-20">
                                <i class="mdi mdi-cached"></i>
                            </button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                    id="dropdown-customar" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" data-display="static">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item"><a href="{{route('client.fideles')}}">Liste des client</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-15px">
                        <table class="table ">
                            <tbody>
                                @foreach ($superclients as $client)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="media-image mr-3 rounded-circle">
                                                <a href="#">
                                                    
                                                
                                                        @if ($client->photo)
                                                        <img src="{{ asset('storage/' . $client->photo) }}" class="profile-img rounded-circle w-45"
                                                            alt="Avatar Image">
                                                    @else
                                                        <img src="{{ asset('img/user/u-xl-6.jpg') }}" class="profile-img rounded-circle w-45" alt="Avatar Image">
                                                    @endif
                                                    
                                                    </a>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <a href="profile.html">
                                                    <h6 class="mt-0 text-dark font-weight-medium">{{ $client->nom }} {{ $client->prenoms }}</h6>
                                                </a>
                                                <small>@if ($client->email)
                                                    {{$client->email}}
                                                @else
                                                    Pas de email
                                                @endif</small>
                                            </div>
                                        </div>
                                    </td>
                                    @php
                                        $last = count($client->orders)-1;
                                        $commande = count($client->orders);
                                    @endphp
                                    <td> {{$commande}} Commande(s)</td>
                                    <td class="text-dark d-none d-md-block"> {{$client->orders[$last]->prix_total}} fr</td>
                                </tr>
                                @endforeach
                               
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Content -->
</div> <!-- End Content Wrapper -->
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("periodeSelect");
    const statsJour = document.querySelectorAll(".stats-jour");
    const statsMois = document.querySelectorAll(".stats-mois");
    const statsAnnee = document.querySelectorAll(".stats-annee");

    function updateStatsDisplay(value) {
        // Masquer toutes les sections
        statsJour.forEach(el => el.style.display = "none");
        statsMois.forEach(el => el.style.display = "none");
        statsAnnee.forEach(el => el.style.display = "none");

        // Afficher la section sélectionnée
        if (value === "jour") statsJour.forEach(el => el.style.display = "flex");
        else if (value === "mois") statsMois.forEach(el => el.style.display = "flex");
        else if (value === "annee") statsAnnee.forEach(el => el.style.display = "flex");
    }

    // Gestion du changement de sélection
    select.addEventListener("change", function () {
        updateStatsDisplay(this.value);
    });

    // Initialiser l'affichage correct
    updateStatsDisplay(select.value);
});

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Récupération des données PHP dans JavaScript
        var salesThisMonth = {!! json_encode($salesThisMonth) !!};
        var salesThisYear = {!! json_encode($salesThisYear) !!};

        // Transformation des données en tableaux JavaScript exploitables
        var monthlyLabels = salesThisMonth.map(sale => sale.date);
        var monthlyData = salesThisMonth.map(sale => sale.total_ventes);

        var yearlyLabels = salesThisYear.map(sale => sale.date);
        var yearlyData = salesThisYear.map(sale => sale.total_ventes);

        // Configuration de base du graphique
        var ctx = document.getElementById("salesChart").getContext("2d");
        var salesChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: monthlyLabels, // Affichage par défaut: ventes du mois
                datasets: [{
                    label: "Nombre de ventes",
                    backgroundColor: "rgba(52, 116, 212, .3)",
                    borderColor: "rgba(52, 116, 212, .7)",
                    data: monthlyData,
                    lineTension: 0.3,
                    pointBackgroundColor: "rgba(52, 116, 212, 0)",
                    pointHoverBackgroundColor: "rgba(52, 116, 212, 1)",
                    pointHoverRadius: 3,
                    pointHitRadius: 30,
                    pointBorderWidth: 2,
                    pointStyle: "rectRounded"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        grid: { color: "#eee", zeroLineColor: "#eee" },
                        ticks: { beginAtZero: true, stepSize: 5 }
                    }
                }
            }
        });

        // Gestion des onglets pour changer les données du graphique
        document.querySelectorAll(".nav-link").forEach(function (tab, index) {
            tab.addEventListener("click", function () {
                if (index === 0) { // Aujourd'hui (non géré ici car pas de données précises par heure)
                    salesChart.data.labels = monthlyLabels;
                    salesChart.data.datasets[0].data = monthlyData;
                } else if (index === 1) { // Mensuel
                    salesChart.data.labels = monthlyLabels;
                    salesChart.data.datasets[0].data = monthlyData;
                } else if (index === 2) { // Annuel
                    salesChart.data.labels = yearlyLabels;
                    salesChart.data.datasets[0].data = yearlyData;
                }
                salesChart.update();
            });
        });
    });
</script>


  <!-- Datatables -->
  <script src="{{ asset('plugins/data-tables/jquery.datatables.min.js') }}"></script>
  <script src="{{ asset('/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('plugins/data-tables/datatables.responsive.min.js') }}"></script>
@endsection
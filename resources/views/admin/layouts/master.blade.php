<!DOCTYPE html>
<html lang="en" dir="ltr">


<!-- Mirrored from maraviyainfotech.com/projects/ekka/ekka-v37/ekka-admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jun 2024 19:29:39 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="leMarchand - Admin Dashboard Gestion HTML Template.">

    <title>Le Marchand - Admin Dashboard Store Gestion</title>

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="../../../../../fonts.googleapis.com/index.html">
    <link rel="preconnect" href="../../../../../fonts.gstatic.com/index.html" crossorigin>
    <link
        href="{{ asset('fonts.googleapis.com/css21b01.css?family=Montserrat:wght@200;300;400;500;600;700;800&amp;family=Poppins:wght@300;400;500;600;700;800;900&amp;family=Roboto:wght@400;500;700;900&amp;display=swap') }}"
        rel="stylesheet">
    <link href="{{ asset('cdn.jsdelivr.net/npm/%40mdi/font%404.4.95/css/materialdesignicons.min.css') }}"
        rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/simplebar/simplebar.css') }}" rel="stylesheet" />
    <!-- Ekka CSS -->
    <link id="ekka-css" href="{{ asset('css/ekka.css') }}" rel="stylesheet" />

    <!-- FAVICON -->
    <link href="{{ asset('img/favicon.png') }}" rel="shortcut icon" />
    <!-- No Extra plugin used -->

    <link href="{{ asset('plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>

</head>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body">

    <!--  WRAPPER  -->
    <div class="wrapper">

        <!-- LEFT MAIN SIDEBAR -->
        <div class="ec-left-sidebar ec-bg-sidebar">
            <div id="sidebar" class="sidebar ec-sidebar-footer">
                @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin')
                    <div class="ec-brand">
                        <a href="{{ route('admin.dashboard') }}" title="Ekka">
                            <picture>
                                <source srcset="{{ asset('img/logo/logo.webp') }} 1x" type="image/webp" />
                                <img class="ec-brand-icon" src="{{ asset('img/logo/logo.png') }}" alt="" />

                            </picture>
                        </a>
                    </div>
                @else
                    <div class="ec-brand">
                        <a href="{{ route('factures.create') }}" title="Ekka">
                            <img class="ec-brand-icon" src="{{ asset('img/logo/logo.png') }}" alt="" />
                        </a>
                    </div>
                @endif
                <!-- begin sidebar scrollbar -->
                <div class="ec-navigation" data-simplebar>
                    <!-- sidebar menu -->
                    <ul class="nav sidebar-inner" id="sidebar-menu">

                        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role !== 'normal')

                            <!-- Dashboard -->
                            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.dashboard') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span class="nav-text">Dashboard</span>
                                </a>
                                <hr>
                            </li>

                            <!-- Vendors -->
                            <li class="{{ request()->routeIs('admin.fournisseur') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="{{ route('admin.fournisseur') }}">
                                    <i class="mdi mdi-account-group-outline"></i>
                                    <span class="nav-text">Fournisseurs</span>
                                </a>
                                <hr>
                            </li>
                            @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin')
                                <!-- Users -->
                                <li class="has-sub {{ request()->routeIs('clients.index') ? 'active' : '' }}">
                                    <a class="sidenav-item-link" href="javascript:void(0)">
                                        <i class="mdi mdi-account-group"></i>
                                        <span class="nav-text">Clients</span> <b class="caret"></b>
                                    </a>
                                    <div class="collapse">
                                        <ul class="sub-menu" id="users" data-parent="#sidebar-menu">

                                            <li class="">
                                                <a class="sidenav-item-link" href="{{ route('clients.index') }}">
                                                    <span class="nav-text">Liste des clients</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr>
                                </li>
                                <!-- Gestion d'access -->
                                <li class="has-sub {{ request()->routeIs('admins.index') ? 'active' : '' }}">
                                    <a class="sidenav-item-link" href="javascript:void(0)">
                                        <i class="mdi mdi-account-group"></i>
                                        <span class="nav-text">Gestion d'access</span> <b class="caret"></b>
                                    </a>
                                    <div class="collapse">
                                        <ul class="sub-menu" id="users" data-parent="#sidebar-menu">


                                            <li class="">
                                                <a class="sidenav-item-link" href="{{ route('admins.index') }}">
                                                    <span class="nav-text">Utilisateurs</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    <hr>
                                </li>

                                <!-- Category -->
                                <li
                                    class="has-sub  {{ request()->routeIs('categories.index') || request()->routeIs('admin.categorie.subCategory') ? 'active' : '' }}">
                                    <a class="sidenav-item-link" href="javascript:void(0)">
                                        <i class="mdi mdi-dns-outline"></i>
                                        <span class="nav-text">Categories</span> <b class="caret"></b>
                                    </a>
                                    <div class="collapse">
                                        <ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
                                            <li class="">
                                                <a class="sidenav-item-link" href="{{ route('categories.index') }}">
                                                    <span class="nav-text">Catégorie</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a class="sidenav-item-link"
                                                    href="{{ route('admin.categorie.subCategory') }}">
                                                    <span class="nav-text">Sous Categorie</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            <!-- Products -->
                            <li
                                class="has-sub {{ request()->routeIs('produits.index') || request()->routeIs('produits.create') || request()->routeIs('produits.edit') ? 'active' : '' }}">
                                <a class="sidenav-item-link" href="javascript:void(0)">
                                    <i class="mdi mdi-palette-advanced"></i>
                                    <span class="nav-text">Produits</span> <b class="caret"></b>
                                </a>
                                <div class="collapse">
                                    <ul class="sub-menu" id="products" data-parent="#sidebar-menu">
                                        <li class="">
                                            <a class="sidenav-item-link" href="{{ route('produits.index') }}">
                                                <span class="nav-text">Liste des Produits</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a class="sidenav-item-link" href="{{ route('produits.create') }}">
                                                <span class="nav-text">Ajouter Produit</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif

                        <!-- Orders -->
                        <li
                            class="has-sub {{ request()->routeIs('factures.create') || request()->routeIs('factures.index') || request()->routeIs('factures.show') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="javascript:void(0)">
                                <i class="mdi mdi-cart"></i>
                                <span class="nav-text">Ventes</span> <b class="caret"></b>
                            </a>
                            <div class="collapse">
                                <ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
                                    <li class=" {{ request()->routeIs('factures.create') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('factures.create') }}">
                                            <span class="nav-text">Factures</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="sidenav-item-link" href="{{ route('factures.index') }}">
                                            <span class="nav-text">Historique</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="has-sub {{ request()->routeIs('defectueux.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="javascript:void(0)">
                                <i class="mdi mdi-cash"></i>
                                <span class="nav-text">Produits defectueux</span> <b class="caret"></b>
                            </a>
                            <div class="collapse">
                                <ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
                                    {{-- <li class="">
                                        <a class="sidenav-item-link" href="{{ route('depenses.index') }}">
                                            <span class="nav-text">Ajo</span>
                                        </a>
                                    </li> --}}
                                    <li class="">
                                        <a class="sidenav-item-link" href="{{ route('defectueux.index') }}">
                                            <span class="nav-text">Liste des produits</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <!-- Depences-->
                        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role !== 'normal')

                        <li class="has-sub {{ request()->routeIs('fonds.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="javascript:void(0)">
                                <i class="mdi mdi-cash"></i>
                                <span class="nav-text">Fond de Caisse</span> <b class="caret"></b>
                            </a>
                            <div class="collapse">
                                <ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
                                    <li class="">
                                        <a class="sidenav-item-link" href="{{ route('fonds.index') }}">
                                            <span class="nav-text">Ajouter Fond de caisse</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
@endif
                        <!-- Depences-->
                        {{-- <div class="i-mdi:cash-remove w-1em h-1em"></div> --}}
                        <li
                            class="has-sub {{ request()->routeIs('depenses.index') || request()->routeIs('depense.liste') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="javascript:void(0)">
                                <i class="mdi mdi-cash"></i>
                                <span class="nav-text">Liste des Dépenses</span> <b class="caret"></b>
                            </a>
                            <div class="collapse">
                                <ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
                                    <li class="">
                                        <a class="sidenav-item-link" href="{{ route('depenses.index') }}">
                                            <span class="nav-text">Ajouter une depense</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="sidenav-item-link" href="{{ route('depense.liste') }}">
                                            <span class="nav-text">Liste</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <!--  PAGE WRAPPER -->
        <div class="ec-page-wrapper">

            <!-- Header -->
            <header class="ec-main-header" id="header">
                <nav class="navbar navbar-static-top navbar-expand-lg">
                    <!-- Sidebar toggle button -->
                    <button id="sidebar-toggler" class="sidebar-toggle"></button>
                    <!-- search form -->
                    <div class="search-form d-lg-inline-block">

                    </div>

                    <!-- navbar right -->
                    <div class="navbar-right">
                        <ul class="nav navbar-nav">
                            <!-- User Account -->
                            <li class="dropdown user-menu">
                                <button class="dropdown-toggle nav-link ec-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ asset('img/user/user.png') }}" class="user-image"
                                        alt="User Image" />
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right ec-dropdown-menu">
                                    <!-- User image -->
                                    <li class="dropdown-header">
                                        <img src="{{ asset('img/user/user.png') }}" class="img-circle"
                                            alt="User Image" />
                                        <div class="d-inline-block">
                                            @php
                                                $info = auth('admin')->user();
                                                $name = $info->nom;
                                                $email = $info->email;
                                            @endphp
                                            {{ $name }} <small class="pt-1">{{ $email }}</small>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.profil') }}">
                                            <i class="mdi mdi-account"></i> Mon Profil
                                        </a>
                                    </li>
                                    <li class="right-sidebar-in">
                                        <a href="javascript:0"> <i class="mdi mdi-settings-outline"></i> Parametres
                                        </a>
                                    </li>
                                    <li class="dropdown-footer">
                                        <a href="{{ route('logout.admin') }}"> <i class="mdi mdi-logout"></i>
                                            Deconnexion </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="right-sidebar-in right-sidebar-2-menu">
                                <i class="mdi mdi-settings-outline mdi-spin"></i>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            @yield('content')

            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="copyright bg-white">
                    <p>
                        Copyright &copy; <span id="ec-year"></span><a class="text-primary" href="#"
                            target="_blank"> LeMArchand Admin
                            Dashboard</a>. All Rights Reserved.
                    </p>
                </div>
            </footer>

        </div> <!-- End Page Wrapper -->
    </div> <!-- End Wrapper -->

    <!-- Common Javascript -->
    <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-zoom/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('plugins/slick/slick.min.js') }}"></script>

    <!-- Chart -->
    <script src="{{ asset('plugins/charts/Chart.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>

    <!-- Google map chart -->
    <script src="{{ asset('plugins/charts/google-map-loader.js') }}"></script>
    <script src="{{ asset('plugins/charts/google-map.js') }}"></script>

    <!-- Date Range Picker -->
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/date-range.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Option Switcher -->
    <script src="{{ asset('plugins/options-sidebar/optionswitcher.js') }}"></script>

    <!-- Ekka Custom -->
    <script src="{{ asset('js/ekka.js') }}"></script>
    <script>
        setTimeout(function() {
            const errorDiv = document.querySelector('.alert');
            console.log('erreur :', errorDiv);

            if (errorDiv) {
                // Déclenche la transition d'opacité
                errorDiv.style.opacity = '0';

                // Après la transition (1 seconde), masquer la div complètement
                setTimeout(function() {
                    errorDiv.style.display = 'none';
                }, 500); // Délai égal à la durée de la transition d'opacité
            }
        }, 5000);
    </script>
    @yield('script');
</body>



</html>

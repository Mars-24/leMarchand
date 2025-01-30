@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2">
                <h1>Factures</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Facture
                </p>
            </div>
            @include('admin.layouts.errors-infos')

            <form action="{{ route('factures.store') }}" method="POST" enctype="multipart/form-data"
                onkeydown="return event.key != 'Enter';">
                @csrf
                {{-- <form> --}}
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-group no-print">
                            <input type="text" name="query" id="search-input" class="form-control"
                                placeholder="Rechercher ..." autofocus autocomplete="off" />
                            <button type="button" name="search" id="search-btn" class="btn btn-flat">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                        <div id="search-results-container">
                            <ul id="search-results"></ul>
                        </div>

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
                                                <th>Prix Minimuim</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($produits as $produit)
                                                <tr>
                                                    <td>
                                                        @if ($produit->photo)
                                                            <img class="tbl-thumb"
                                                                src="{{ asset('storage/' . $produit->photo) }}"
                                                                alt="Product Image">
                                                        @else
                                                            <img class="tbl-thumb" src="{{ asset('img/products/p6.jpg') }}"
                                                                alt="Product Image" />
                                                    </td>
                                            @endif
                                            <td>{{ $produit->subcategory->nom }}</td>
                                            <td>{{ $produit->model }}</td>
                                            <td>{{ $produit->prix_vente }} fr</td>
                                            <td>{{ $produit->prix_minimum }} fr</td>

                                            <td>
                                                <div class="btn-group mb-1">
                                                    <button type="button" class="btn btn-outline-success add_to_cart"
                                                        data-quantity="1" data-produit-id="{{ $produit->id }} "
                                                        id="add_to_cart{{ $produit->id }}">Ajouter</button>

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
                    <div class="col-lg-6 col-sm-12 card invoice border-radius border bg-white p-4">
                        <div class="d-flex justify-content-between print-section">
                            <h3 class="text-dark font-weight-medium">Facture # <input
                                    class="text-dark font-weight-medium fac" type="text" name="order_number"
                                    id="" value="{{ $newInvoiceNumber }}" readonly></h3>

                            <div class="btn-group print-column no-print">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="mdi mdi-content-save"></i> Enregistrer
                                </button>

                                <button class="btn btn-sm btn-primary print-btn">
                                    <i class="mdi mdi-printer"></i> Imprimer
                                </button>
                            </div>
                        </div>

                        <div class="row pt-5">
                            <div class="col-xl-4 col-lg-4 col-sm-6 no-print">
                                <p class="text-dark mb-2 no-print">De</p>

                                <address>
                                    <span>Lemarchand</span>
                                    <br> Agbalepedo,Rond Point Oeuf près du marché cacaveli
                                    <br> <span>Email:</span> example@gmail.com
                                    <br> <span>Tel:</span> +228 92 86 06 75
                                </address>

                            </div>
                            <div class="print-para invoice-header">
                                <div>
                                    <p><strong>Lemarchand</strong></p>
                                    <p>Agbalepedo,Rond Point Oeuf</p>
                                    <p>Tél: +228 92 86 06 75</p>
                                </div>
                                <div>
                                    <img src="logo.png" alt="Le Marchand">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <p class="text-dark mb-2 no-print">A</p>
                                <p class="text-dark mb-2 print-para">Client :</p>

                                <address>
                                    <span>
                                        <input type="text" name="nom" id="name_client" placeholder="nom client">
                                        <br class="no-print"> <input type="text" name="prenoms" id="prenoms_client"
                                            placeholder="prenoms client"></span>
                                    <br class="no-print"> <span class="no-print">Email: <input type="text" name="email"
                                            id="email_client" class="no-print" placeholder="email client"></span>
                                    <br class="no-print"> <span class="input-print">Tel: <input type="text"
                                            name="phone" id="phone_client" placeholder="phone client"></span>
                                </address>
                            </div>
                            <div class="col-xl-1 disp-none"></div>
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <p class="text-dark mb-2">Details :</p>

                                <address class="adresse-print">
                                    <span class="no-print">Facture ID:</span>
                                    <span class="text-dark no-print">#{{ $newInvoiceNumber }}</span>
                                    <br><span>Date :</span> {{ \Carbon\Carbon::now()->toDateString() }}
                                    <br> <span class="no-print">Type:</span>
                                    <span class="print-para">Type opération:</span>
                                    <select name="mode_achat" class="paiement" id="">
                                        <option value="paiement">Paiement</option>
                                        <option value="deal">Deal</option>
                                        <option value="acompte">Acompte</option>

                                    </select>
                                </address>
                            </div>
                        </div>
                        <div id="facture-table">
                            @include('admin.layouts._facture-list')

                        </div>
                        <div class="invoice-footer ">
                            <p>Merci pour votre achat !</p>
                        </div>

                    </div>
                </div>
            </form>
        </div> <!-- End Content -->
        {{-- <div class="invoice">
            <div class="invoice-header">
                <div>
                    <h1>Facture {{ $newInvoiceNumber }} </h1>
                    <p><strong>Lemarchand</strong></p>
                    <p>Agbalepedo,Rond Point Oeuf</p>
                    <p>Tél: +228 92 86 06 75</p>
                </div>
                <div>
                    <img src="logo.png" alt="Logo Supermarché">
                </div>
            </div>

            <div class="invoice-info">
                <h2>Client:</h2>
                <p>Nom: Jean Dupont</p>
                <p>Téléphone: +33 6 12 34 56 78</p>
                <p class="date">Date: {{ \Carbon\Carbon::now()->toDateString() }}</p>
            </div>

            <div id="facture-table">
                @include('admin.layouts._facture-list')

            </div>

            <div class="invoice-footer">
                <p>Merci pour votre achat !</p>
            </div>
        </div> --}}
        <div class="no-print">
            <button onclick="window.print()">Imprimer la Facture</button>
        </div>
    </div> <!-- End Content Wrapper -->
    <style>
        .price-text,
        .paiement {
            background-color: transparent;
            /* Rend l'arrière-plan transparent */
            border: none;
            /* Supprime la bordure */
            outline: none;
            /* Supprime la bordure lors de la mise au point (focus) */
            color: #000;
            /* Couleur du texte (ajustez-la si nécessaire) */
            font-size: 16px;
            /* Taille du texte (ajustez selon vos besoins) */
            /*width: 100%;
                                                    /* Ajuste la largeur selon vos besoins */
        }

        .fac {
            background-color: transparent;
            /* Rend l'arrière-plan transparent */
            border: none;
            /* Supprime la bordure */
            outline: none;
            /* Supprime la bordure lors de la mise au point (focus) */
            color: #000;
            /* Couleur du texte (ajustez-la si nécessaire) */

        }

        address input {
            border-radius: 10px;
            margin: 5px;
            width: 100%;
            text-align: center;
        }

        .invoice {
            /* display: none; */
        }

        .print-para {
            display: none;
        }

        .invoice-header {
            display: none;
            justify-content: space-between;
        }

        /* Styles d'impression */
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
                margin: 3px;
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

            .price-td {
                width: 50%;
            }

            .price-text {
                width: 50%;

            }

            * {
                font-size: 11.5px !important;
                background-color: #fff !important;
                color: #000;

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
                margin-top: 10px
            }

            .invoice-header {
                margin-top: -20px;
                display: flex;
                justify-content: space-between;
            }

            /* Masquer tous les autres éléments du body */


            /* Afficher uniquement la facture lors de l'impression */


            /* Masquer les éléments destinés uniquement à l'écran (comme les boutons) */
            .no-print {
                display: none;
            }
        }



        .invoice-header h1 {
            font-size: 23px;
        }

        .invoice-header img {
            max-width: 150px;
        }

        .invoice-info {
            margin-bottom: 20px;
        }

        .invoice-info h2 {
            font-size: 17px;
            margin-bottom: 10px;
        }

        .invoice-info p {
            margin: 0;
        }

        .invoice-info .date {
            font-size: 14px;
            margin-top: 10px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .invoice-table th {
            /* background-color: #f4f4f4; */
        }

        .invoice-total {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
        }

        .invoice-total table {
            width: 250px;
            border-collapse: collapse;
        }

        .invoice-total th,
        .invoice-total td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .invoice-total th {
            background-color: #f4f4f4;
        }

        .invoice-total .total {
            font-size: 17px;
            font-weight: bold;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #888;
        }
    </style>
@endsection
@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).on('click', '#dealBtn', function(e) {
            e.preventDefault();
            var dealProduct = $('#modelProduit').val(); // Récupérer la valeur de l'input

            if (dealProduct) {
                // Remplacer le bouton dans le tableau par le texte et ajouter un événement de clic
                $('.btn-text-deal').html(`<span class="deal-text">${dealProduct}</span>`);

                // Ajouter un événement de clic sur le texte pour rouvrir le modal
                $('.deal-text').on('click', function() {
                    $('#modal-add-contact').modal('show');
                });
            }

            // Fermer le modal (optionnel, déjà géré par data-bs-dismiss)
            $('#modal-add-contact').modal('hide');
        });
        $(document).on('change', '#prixachat', function(e) {
            // Récupérer la valeur de la réduction
            e.preventDefault();
            // var initialTotal = {{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal(0, '', '') }};

            // var reduction = parseInt($(this).val()) || 0;
            // console.log('reduction ', reduction);
            // console.log('init ', initialTotal);

            // if (reduction > initialTotal) {
            //     swal({
            //         title: 'Erreur',
            //         text: 'Le prix du produit a dealer doit depasser le prix du produit',
            //         icon: 'error',
            //         button: 'OK'
            //     });
            //     return false;
            // } else {
            //     // Calculer le nouveau total
            //     let newTotal = initialTotal - reduction;
            //     // // Mettre à jour le total affiché
            //     $('#total').text(newTotal.toLocaleString('fr-FR') + ' fr');
            //     $('#total_partiel').text(newTotal.toLocaleString('fr-FR') + ' fr');
            //     $('#total_tab').text(newTotal.toLocaleString('fr-FR') + ' fr');
            // }
            var reduction = parseInt($(this).val()) || 0;
            console.log('valeur de la reduction ', reduction);

            $.ajax({
                url: "{{ route('cart.subtotal') }}",
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    var initialTotal = parseFloat(response.subtotal.replace(',',
                        '')); // Convertir en nombre
                    console.log('Montant initial mis à jour :', response);

                    if (reduction > initialTotal) {
                        swal({
                            title: 'Erreur',
                            text: 'Le prix de la réduction ne doit pas dépasser le prix du produit',
                            icon: 'error',
                            button: 'OK'
                        });
                        return false;
                    } else {
                        let newTotal = initialTotal - reduction;
                        // // Mettre à jour le total affiché
                        $('#total').text(newTotal.toLocaleString('fr-FR') + ' fr');
                        $('#total_partiel').text(newTotal.toLocaleString('fr-FR') + ' fr');
                        $('#total_tab').text(newTotal.toLocaleString('fr-FR') + ' fr');
                    }
                },
                error: function(err) {
                    console.error('Erreur lors de la récupération du sous-total :', err);
                    swal({
                        title: 'Erreur',
                        text: 'Impossible de récupérer le montant initial. Veuillez réessayer.',
                        icon: 'error',
                        button: 'OK'
                    });
                }
            });

        });
        $(document).on('change', '#reduction', function(e) {
            e.preventDefault();

            // Récupérer le montant initial via AJAX
            $.ajax({
                url: "{{ route('cart.subtotal') }}",
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    var initialTotal = parseFloat(response.subtotal.replace(',',
                        '')); // Convertir en nombre
                    console.log('Montant initial mis à jour :', response);

                    var reduction = parseInt($('#reduction').val()) || 0;

                    if (reduction > initialTotal) {
                        swal({
                            title: 'Erreur',
                            text: 'Le prix de la réduction ne doit pas dépasser le prix du produit',
                            icon: 'error',
                            button: 'OK'
                        });
                        return false;
                    } else {
                        // Calculer le nouveau total
                        let newTotal = initialTotal - reduction;
                        // Mettre à jour le total affiché
                        $('#total').text(newTotal.toLocaleString('fr-FR') + ' fr');
                    }
                },
                error: function(err) {
                    console.error('Erreur lors de la récupération du sous-total :', err);
                    swal({
                        title: 'Erreur',
                        text: 'Impossible de récupérer le montant initial. Veuillez réessayer.',
                        icon: 'error',
                        button: 'OK'
                    });
                }
            });
        });


        $(document).on('click', '.add_to_cart', function(e) {
            e.preventDefault();
            var produit_id = $(this).data('produit-id');
            var produit_qty = $(this).data('quantity') //  alert(produit_qty);
            var mode_buy = $('select[name="mode_achat"]').val();
            console.error('Le mode de paiement :', mode_buy);
            var search = $('#search-input');
            var tableBody = $('#responsive-data-table tbody');

            console.log('serach :', search.val());

            var token = "{{ csrf_token() }}";
            var path = "{{ route('cart.store') }}";

            $.ajax({
                url: path,
                type: "POST",
                dataType: "JSON",
                data: {
                    product_id: produit_id,
                    product_qty: produit_qty,
                    mode_buy: mode_buy,
                    _token: token,
                },

                success: function(data) {
                    console.log(data);
                    if (data['status']) {
                        swal({
                            title: 'Super',
                            text: data['message'],
                            icon: 'success',
                            button: 'OK!'
                        });
                    }
                    search.val('');
                    tableBody.html('<tr><td colspan="6">Ajouter un nouveau produit.</td></tr>');
                    $('body #facture-table').html(data['cart']);
                },
                error: function(err) {
                    console.log(err);
                    swal({
                        title: 'Erreur',
                        text: 'Une erreur est survenue. Veuillez réessayer.',
                        icon: 'error',
                        button: 'OK'
                    });
                    search.val('');

                    // window.location.href = "{{ route('factures.index') }}";

                }

            });
        });
        $(document).on('click', '.cart_delete', function(e) {
            e.preventDefault();
            const cart_id = $(this).data('id');
            const mode_buy = $('select[name="mode_achat"]').val();
            const path = "{{ route('cart.delete') }}";
            const token = "{{ csrf_token() }}";
            console.log('button :', cart_id);

            $.ajax({
                url: path,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    cart_id: cart_id,
                    mode_buy: mode_buy,
                    _token: token,
                },
                success: function(data) {
                    console.log(data);
                    if (data['status']) {
                        swal({
                            title: 'Super',
                            text: data['message'],
                            icon: 'success',
                            button: 'OK!'
                        });
                    }

                    $('body #facture-table').html(data['cart']);
                },
                error: function(err) {
                    console.log(err);
                    swal({
                        title: 'Erreur',
                        text: 'Une erreur est survenue. Veuillez réessayer',
                        icon: 'error',
                        button: 'OK'
                    });
                    // window.location.href = "{{ route('factures.index') }}";

                }
            });
        });
        $(document).ready(function() {
            // function de recherche du client
            $('#name_client').on('input', function(e) {
                e.preventDefault();
                let name_client = $(this).val();
                const path = "{{ route('client-info') }}";
                var token = "{{ csrf_token() }}";

                if (name_client.length > 2) {
                    console.log('oui oui');

                    $.ajax({
                        url: path,
                        type: 'GET',
                        data: {
                            nom: name_client,
                            _token: token,
                        },
                        success: function(data) {
                            if (data.prenoms) {
                                document.getElementById('prenoms_client').value = data.prenoms;

                            } else {
                                document.getElementById('prenoms_client').value = '';

                            }
                            if (data.email) {
                                document.getElementById('email_client').value = data.email;

                            } else {
                                document.getElementById('email_client').value = '';

                            }
                            if (data.phone) {
                                document.getElementById('phone_client').value = data.phone;

                            } else {
                                document.getElementById('phone_client').value = '';

                            }
                        }
                    })
                }

            });
            $('.print-btn').on('click', function(e) {
                e.preventDefault();

                printWindow.print();

                // Ne pas fermer la fenêtre automatiquement
                // printWindow.close(); // Supprimez ou commentez cette ligne si vous ne voulez pas fermer la fenêtre automatiquement
            });
            $('select[name="mode_achat"]').on('change', function(e) {
                e.preventDefault();
                var selectedValue = this.value;
                console.log('valeur selectionnée :', selectedValue);
                loadInvoiceTable(selectedValue);

            });

            function loadInvoiceTable(selectedValue) {
                var url = '';

                // Définir l'URL de la vue à charger en fonction de la valeur sélectionnée
                if (selectedValue === 'deal') {
                    url = "{{ route('deal-view') }}"; // URL pour charger la vue 'deal'
                } else if (selectedValue === 'paiement') {
                    url = "{{ route('paiement-view') }}"; // URL pour charger la vue 'paiement'
                } else if (selectedValue === 'acompte') {
                    url = "{{ route('acompte-view') }}"; // URL pour charger la vue 'paiement'
                }

                // Faire une requête AJAX pour charger la vue
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('facture-table').innerHTML = html; // Injecter le HTML chargé
                    })
                    .catch(error => console.log('Erreur lors du chargement de la vue :', error));
            }

        });
        document.getElementById('search-input').addEventListener('keyup', function() {
            const query = this.value;

            // Si le champ de recherche est vide, réinitialiser les résultats
            if (query.length === 0) {
                fetch(`/admin/produits/search?query=`)
                    .then(response => response.json())
                    .then(data => updateTable(data));
                return;
            }

            // Effectuer une requête AJAX
            fetch(`/admin/produits/search?query=${query}`)
                .then(response => response.json())
                .then(data => updateTable(data))
                .catch(error => console.error('Erreur :', error));
        });

        // Fonction pour mettre à jour le tableau
        function updateTable(data) {
            const tableBody = document.querySelector('#responsive-data-table tbody');
            tableBody.innerHTML = ''; // Vider le tableau

            if (data.length > 0) {
                data.forEach(produit => {
                    const row = `
                <tr>
                    <td>
                        <img class="tbl-thumb" src="/storage/${produit.photo || 'img/products/p6.jpg'}" alt="Image">
                    </td>
                    <td>${produit.subcategory ? produit.subcategory.nom : 'N/A'}</td>
                    <td>${produit.model}</td>
                    <td>${produit.prix_vente} fr</td>
                    <td>${produit.prix_minimum} fr</td>
                    <td>
                        <button type="button" class="btn btn-outline-success add_to_cart" 
                                data-quantity="1" data-produit-id="${produit.id}">
                            Ajouter
                        </button>
                    </td>
                </tr>
            `;
                    tableBody.innerHTML += row;
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="6">Aucun produit trouvé.</td></tr>';
            }
        }
    </script>
    <script>
        $(document).on('change', '.price-text', function() {
            const id = $(this).data('id');
            var spinner = $(this);
            const mode_buy = $('select[name="mode_achat"]').val();
            console.error('mde achat ', mode_buy);
            // alert(spinner.val());
            if (spinner.val() <= 0) {
                swal({
                    title: 'Erreur',
                    text: 'Le prix doit etre superieur à 0',
                    icon: 'error',
                    button: 'OK'
                });
                return false;
            }
            const price = spinner.val();
            // alert(id);
            update_cart(id, price, mode_buy)

        });

        function update_cart(id, price, mode_buy) {
            var rowId = id;
            var price = price;
            var mode_buy = mode_buy;
            var token = "{{ csrf_token() }}";
            var path = "{{ route('cart.update') }}";

            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    _token: token,
                    rowId: rowId,
                    price: price,
                    mode_buy: mode_buy,
                },
                success: function(data) {
                    console.log(data);
                    $('body #facture-table').html(data['cart']);
                    if (data['status']) {
                        swal({
                            title: 'Super',
                            text: data['message'],
                            icon: 'success',
                            buutton: 'OK!'
                        });

                    } else {
                        swal({
                            title: 'Erreur',
                            text: data['message'],
                            icon: 'success',
                            buutton: 'OK!'
                        });
                    }
                }
            });

        }
    </script>
@endsection

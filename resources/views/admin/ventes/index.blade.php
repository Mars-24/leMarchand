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
            <div class="row">
                <div class="col-lg-6 col-sm-12">
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
                                            <th>Status</th>
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
                                        <td>{{ $produit->prix_vente }}</td>
                                        <td>{{ $produit->prix_minimum }}</td>

                                        </td>
                                        <td>{{ $produit->status }}</td>
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
                <div class="col-lg-6 col-sm-12 card invoice-wrapper border-radius border bg-white p-4">
                    <div class="d-flex justify-content-between">
                        <h3 class="text-dark font-weight-medium">Facture #{{ $newInvoiceNumber }}</h3>

                        <div class="btn-group print-column">
                            <button class="btn btn-sm btn-primary">
                                <i class="mdi mdi-content-save"></i> Enregistrer
                            </button>

                            <button class="btn btn-sm btn-primary print-btn">
                                <i class="mdi mdi-printer"></i> Imprimer
                            </button>
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <p class="text-dark mb-2">De</p>

                            <address>
                                <span>Lemarchand</span>
                                <br> Agbalepedo,Rond Point Oeuf près du marché cacaveli
                                <br> <span>Email:</span> example@gmail.com
                                <br> <span>Phone:</span> +228 92 86 06 75
                            </address>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <p class="text-dark mb-2">A</p>

                            <address>
                                <span><input type="text" name="nom" id="name_client" placeholder="nom client"></span>
                                <br> <input type="text" name="prenoms" id="prenoms_client" placeholder="prenoms client">
                                <br> <span>Email</span>: <input type="text" name="email" id="email_client"
                                    placeholder="email client">
                                <br> <span>Phone:</span><input type="text" name="phone" id="phone_client"
                                    placeholder="phone client">
                            </address>
                        </div>
                        <div class="col-xl-1 disp-none"></div>
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <p class="text-dark mb-2">Details</p>

                            <address>
                                <span>Facture ID:</span>
                                <span class="text-dark">#{{ $newInvoiceNumber }}</span>
                                <br><span>Date :</span> {{ \Carbon\Carbon::now()->toDateString() }}
                                <br> <span>VAT:</span> PL6541215450
                            </address>
                        </div>
                    </div>
                    <div id="facture-table">
                        @include('admin.layouts._facture-list')

                    </div>


                </div>
            </div>
            {{-- <div class="card invoice-wrapper border-radius border bg-white p-4">
						<div class="d-flex justify-content-between">
							<h3 class="text-dark font-weight-medium">Invoice #125</h3>

							<div class="btn-group">
								<button class="btn btn-sm btn-primary">
									<i class="mdi mdi-content-save"></i> Save
								</button>

								<button class="btn btn-sm btn-primary">
									<i class="mdi mdi-printer"></i> Print
								</button>
							</div>
						</div>

						<div class="row pt-5">
							<div class="col-xl-3 col-lg-4 col-sm-6">
								<p class="text-dark mb-2">From</p>

								<address>
									<span>Ekka</span>
									<br> 47 Elita Squre, VIP Chowk,
									<br> <span>Email:</span> example@gmail.com
									<br> <span>Phone:</span> +91 5264 251 325
								</address>
							</div>
							<div class="col-xl-3 col-lg-4 col-sm-6">
								<p class="text-dark mb-2">To</p>

								<address>
									<span>John Marle</span>
									<br> 58 Jamie Ways, North Faye, Q5 5ZP
									<br> <span>Email</span>: example@gmail.com
									<br> <span>Phone:</span> +91 5264 521 943
								</address>
							</div>
							<div class="col-xl-4 disp-none"></div>
							<div class="col-xl-2 col-lg-4 col-sm-6">
								<p class="text-dark mb-2">Details</p>

								<address>
									<span>Invoice ID:</span>
									<span class="text-dark">#2365546</span>
									<br><span>Date :</span> March 25, 2018
									<br> <span>VAT:</span> PL6541215450
								</address>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table mt-3 table-striped table-responsive table-responsive-large inv-tbl"
								style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Image</th>
										<th>Item</th>
										<th>Description</th>
										<th>Quantity</th>
										<th>Unit_Cost</th>
										<th>Total</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>1</td>
										<td><img class="invoice-item-img" src="assets/img/products/p1.jpg" alt="product-image" /></td>
										<td>Baby Pink Shoese</td>
										<td>Amazing shoes with 10 day's replacement warrenty</td>
										<td>4</td>
										<td>$50.00</td>
										<td>$200.00</td>
									</tr>

									<tr>
										<td>2</td>
										<td><img class="invoice-item-img" src="assets/img/products/p2.jpg" alt="product-image"></td>
										<td>Man T-Shirt with Cap Style</td>
										<td>Long Sleeve men T-shirt with cap in Dark Blue Color</td>
										<td>10</td>
										<td>$50.00</td>
										<td>$500.00</td>
									</tr>

									<tr>
										<td>3</td>
										<td><img class="invoice-item-img" src="assets/img/products/p3.jpg" alt="product-image"></td>
										<td>Full Sleeve T-Shirt for men</td>
										<td>Amazing T-shirt in pure Cotton for both</td>
										<td>10</td>
										<td>$20.00</td>
										<td>$200.00</td>
									</tr>

									<tr>
										<td>4</td>
										<td><img class="invoice-item-img" src="assets/img/products/p4.jpg" alt="product-image"></td>
										<td>Round Hat for Men</td>
										<td>Pure Leather Hat for men with black round tap</td>
										<td>6</td>
										<td>$50.00</td>
										<td>$300.00</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="row justify-content-end inc-total">
							<div class="col-lg-3 col-xl-3 col-xl-3 ml-sm-auto">
								<ul class="list-unstyled mt-3">
									<li class="mid pb-3 text-dark"> Subtotal
										<span class="d-inline-block float-right text-default">$1200.00</span>
									</li>

									<li class="mid pb-3 text-dark">Vat(10%)
										<span class="d-inline-block float-right text-default">$100.00</span>
									</li>

									<li class="pb-3 text-dark">Total
										<span class="d-inline-block float-right">$1300.00</span>
									</li>
								</ul>

								<a href="javascript:void(0)" class="btn btn-block mt-2 btn-primary btn-pill"> Procced to
									Payment</a>
							</div>
						</div>
					</div> --}}
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
    <style>
        .price-text {
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
            width: 100%;
            /* Ajuste la largeur selon vos besoins */
        }

        address input {
            border-radius: 10px;
            margin: 5px;
            width: 100%;
            text-align: center;
        }

        @media print {
            body {
                margin: 20mm;
            }

            .print-column {
                display: none;
            }

            input[type="text"],
            input[type="number"] {
                border: none;
                background-color: transparent;
                box-shadow: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                padding: 0;
                margin: 0;
            }

            input[type="text"]::placeholder,
            input[type="number"]::placeholder {
                color: transparent;
                /* Cache le placeholder */
            }
        }
    </style>
@endsection
@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).on('click', '.add_to_cart', function(e) {
            e.preventDefault();
            var produit_id = $(this).data('produit-id');
            var produit_qty = $(this).data('quantity') //  alert(produit_qty);

            //  alert(produit_qty);

            var token = "{{ csrf_token() }}";
            var path = "{{ route('cart.store') }}";

            $.ajax({
                url: path,
                type: "POST",
                dataType: "JSON",
                data: {
                    product_id: produit_id,
                    product_qty: produit_qty,
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
                        text: 'Une erreur est survenue. Veuillez réessayer.',
                        icon: 'error',
                        button: 'OK'
                    });
                    // window.location.href = "{{ route('factures.index') }}";

                }

            });
        });
        $(document).on('click', '.cart_delete', function(e) {
            e.preventDefault();
            const cart_id = $(this).data('id');
            const path = "{{ route('cart.delete') }}";
            const token = "{{ csrf_token() }}";
            console.log('button :', cart_id);

            $.ajax({
                url: path,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    cart_id: cart_id,
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
                        text: 'Une erreur est survenue. Veuillez réessayer.',
                        icon: 'error',
                        button: 'OK'
                    });
                    // window.location.href = "{{ route('factures.index') }}";

                }
            });
        });
        $(document).ready(function() {
            // Récupérer le total initial
            let initialTotal = {{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal(0, '', '') }};

            // Écouter le changement de valeur dans l'input de réduction
            $('#reduction').on('input', function() {
                // Récupérer la valeur de la réduction
                let reduction = parseInt($(this).val()) || 0;

                // Calculer le nouveau total
                let newTotal = initialTotal - reduction;

                // Mettre à jour le total affiché
                $('#total').text(newTotal.toLocaleString('fr-FR') + ' fr');
            });


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
                            document.getElementById('prenoms_client').value = data.prenoms;
                            document.getElementById('email_client').value = data.email;
                            document.getElementById('phone_client').value = data.phone;
                        }
                    })
                }

            });
            $('.print-btn').on('click', function(e) {
                e.preventDefault(); // Empêche l'action par défaut du bouton

                // Cloner la facture pour ne pas affecter le DOM original
                var invoiceClone = document.querySelector('.invoice-wrapper').cloneNode(true);

                // Remplacer les inputs par leur valeur textuelle
                invoiceClone.querySelectorAll('input').forEach(function(input) {
                    var textNode = document.createTextNode(input.value);
                    input.parentNode.replaceChild(textNode, input);
                });

                // Ouvrir la fenêtre d'impression
                var printWindow = window.open('', '', 'width=800,height=600');

                // Ajouter le contenu de la facture
                printWindow.document.write('<html><head><title>Imprimer la Facture</title>');

                // Ajouter les styles CSS actuels
                var styles = document.querySelectorAll('link[rel="stylesheet"], style');
                styles.forEach(function(style) {
                    printWindow.document.write(style.outerHTML);
                });

                // Ajouter des marges personnalisées pour l'impression
                printWindow.document.write('<style>@media print { body { margin: 20mm; } }</style>');

                printWindow.document.write('</head><body>');
                printWindow.document.write(invoiceClone
                    .innerHTML); // Utiliser le clone modifié pour l'impression
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();

                printWindow.print();

                // Ne pas fermer la fenêtre automatiquement
                // printWindow.close(); // Supprimez ou commentez cette ligne si vous ne voulez pas fermer la fenêtre automatiquement
            });

        });
    </script>
    <script>
        $(document).on('change', '.price-text', function() {
            const id = $(this).data('id');
            var spinner = $(this);
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
            update_cart(id, price)

        });

        function update_cart(id, price) {
            var rowId = id;
            var price = price;
            var token = "{{ csrf_token() }}";
            var path = "{{ route('cart.update') }}";

            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    _token: token,
                    rowId: rowId,
                    price: price,
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

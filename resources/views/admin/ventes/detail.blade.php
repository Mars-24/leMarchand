@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
				<div class="content">
                    <div class="breadcrumb-wrapper breadcrumb-wrapper-2">
                        <h1>Vente </h1>
                        <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span>Vente
                        </p>
                    </div>
					<div class="row">
						<div class="col-12">
							<div class="ec-odr-dtl card card-default">
								<div class="card-header card-header-border-bottom d-flex justify-content-between">
									<h2 class="ec-odr">Detail facture<br>
										<span class="small">Facture ID: {{$order->order_number}}</span>
									</h2>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-xl-4 col-lg-6">
											<address class="info-grid">
												<div class="info-title"><strong>Client:</strong></div><br>
												<div class="info-content">
													{{$order->client->nom}}<br>
													{{$order->client->email}}<br>
													{{$order->client->adresse}}<br>
													<abbr title="Phone">Phone:</abbr> {{$order->client->telephone}}
												</div>
											</address>
										</div>
										<div class="col-xl-4 col-lg-6">
											<address class="info-grid">
												<div class="info-title"><strong>Methode de paiement:</strong></div><br>
												<div class="info-content">
													{{$order->mode_achat}}<br>
													@if ($order->client->email)
													<span>{{$order->client->email}}</span>
													@endif
													<br>
												</div>
											</address>
										</div>
										<div class="col-xl-4 col-lg-6">
											<address class="info-grid">
												<div class="info-title"><strong>Date vente:</strong></div><br>
												<div class="info-content">
													4:34PM,<br>
													{{$order->created_at->format('D d M Y')}}
												</div>
											</address>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<h3 class="tbl-title">RÉSUMÉ DE LA FACTURE</h3>
											<div class="table-responsive">
												<table class="table table-striped o-tbl">
													<thead>
														<tr class="line">
															<td><strong>#</strong></td>
															<td class="text-center"><strong>PRODUITS</strong></td>
															<td class="text-center"><strong>PRIX/UNIT</strong></td>
															<td class="text-right"><strong>QUANTITÈ</strong></td>
															<td class="text-right"><strong>TOTAL</strong></td>
														</tr>
													</thead>
                                                    @php
                                                        $produits = json_decode($order->produits,true)
                                                    @endphp
													<tbody>
                                                        @foreach ($produits as $produit)
                                                        
                                                        <tr>
															<td>{{$loop->index+1}}</td>
														
															<td class="text-center">{{$produit[0]}}
                                                                </td>
															<td class="text-center">{{number_format($produit[1],'0',',','.')}} FR
                                                            </td>
															<td class="text-right">{{$produit[2]}}
                                                            </td>
															<td class="text-right">{{number_format($produit[1],'0',',','.')}} FR
                                                            </td>
														</tr>
                                                        @endforeach
															
														{{-- <tr>
															<td colspan="4"></td>
															<td class="text-right"><strong>Taxes</strong></td>
															<td class="text-right"><strong>N/A</strong></td>
														</tr> --}}
														<tr>
															<td colspan="4">
															</td>
															<td class="text-right"><strong>Total</strong></td>
															<td class="text-right"><strong>{{number_format($order->prix_total,'0',',','.')}} FR</strong></td>
														</tr>

														<tr>
															<td colspan="4">
															</td>
															<td class="text-right"><strong>Status du paiement</strong></td>
															<td class="text-right"><strong>PAID</strong></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Tracking Detail -->
							{{-- <div class="card mt-4 trk-order">
								<div class="p-4 text-center text-white text-lg bg-dark rounded-top">
									<span class="text-uppercase">Tracking Order No - </span>
									<span class="text-medium">34VB5540K83</span>
								</div>
								<div
									class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped
											Via:</span> UPS Ground</div>
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Status:</span>
										Checking Quality</div>
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Expected
											Date:</span> DEC 09, 2021</div>
								</div>
								<div class="card-body">
									<div
										class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-cart"></i></div>
											</div>
											<h4 class="step-title">Confirmed Order</h4>
										</div>
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-tumblr-reblog"></i></div>
											</div>
											<h4 class="step-title">Processing Order</h4>
										</div>
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-gift"></i></div>
											</div>
											<h4 class="step-title">Product Dispatched</h4>
										</div>
										<div class="step">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-truck-delivery"></i></div>
											</div>
											<h4 class="step-title">On Delivery</h4>
										</div>
										<div class="step">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-hail"></i></div>
											</div>
											<h4 class="step-title">Product Delivered</h4>
										</div>
									</div>
								</div>
							</div> --}}
						</div>
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->
@endsection
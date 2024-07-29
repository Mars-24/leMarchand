@extends('admin.layouts.master')
@section('content')
	<!-- CONTENT WRAPPER -->
	<div class="ec-content-wrapper">
		<div class="content">
			<div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
				<div>
					<h1>Produit</h1>
					<p class="breadcrumbs"><span><a href="{{route('admin.dashboard')}}">Dashboard</a></span>
						<span><i class="mdi mdi-chevron-right"></i></span>Produit</p>
				</div>
				<div>
					<a href="{{route('produits.create')}}" class="btn btn-primary"> Ajouter Produit</a>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card card-default">
						<div class="card-body">
							<div class="table-responsive">
								<table id="responsive-data-table" class="table"
									style="width:100%">
									<thead>
										<tr>
											<th>Produit</th>
											<th>Nom</th>
											<th>Model</th>
											<th>Prix de vente</th>
											<th>Prix Minimuim</th>
											<th>Stock</th>
											<th>Fournisseur</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
									@foreach ($produits as $produit )
									<tr>
										<td><img class="tbl-thumb" src="assets/img/products/p6.jpg" alt="Product Image" /></td>
										<td>{{$produit->nom}}</td>
										<td>{{$produit->model}}</td>
										<td>{{$produit->prix_vente}}</td>
										<td>{{$produit->prix_minimum}}</td>
										<td>621</td>
										<td>ACTIVE</td>
										<td>2021-10-30</td>
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
													<a class="dropdown-item" href="#">Edit</a>
													<a class="dropdown-item" href="#">Delete</a>
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
@extends('admin.layouts.master')
@section('content')
	<!-- CONTENT WRAPPER -->
	<div class="ec-content-wrapper">
		<div class="content">
			<div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
				<h1>Sous Categorie</h1>
				<p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
					<span><i class="mdi mdi-chevron-right"></i></span>Sous Categorie</p>
			</div>
			<div class="row">
				<div class="col-xl-4 col-lg-12">
					<div class="ec-cat-list card card-default mb-24px">
						<div class="card-body">
							<div class="ec-cat-form">
								<h4>Ajouter Sous Categorie</h4>

								<form method="POST" action="{{route('subCategory.store')}}">
									@csrf
									<div class="form-group row">
										<label for="parent-category" class="col-12 col-form-label">Categorie Parent</label> 
										<div class="col-12">
											<select id="parent-category" name="categorie_id" class="custom-select">
												<option value="default" disabled selected>Type produit</option>
												@foreach ($categories as $categorie )
												<option value="{{$categorie->id}}">{{$categorie->nom}}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="form-group row">
										<label for="text" class="col-12 col-form-label">Nom</label> 
										<div class="col-12">
											<input id="text" name="nom" class="form-control here slug-title" type="text">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<button name="submit" type="submit" class="btn btn-primary">Enrégistrer</button>
										</div>
									</div>

								</form>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-8 col-lg-12">
					<div class="ec-cat-list card card-default">
						<div class="card-body">
							<div class="table-responsive">
								<table id="responsive-data-table" class="table">
									<thead>
										<tr>
											<th>Icones</th>
											<th>Nom</th>
											<th>Categories</th>
											<th>Product</th>
											<th>Total Sell</th>
											<th>Status</th>
											<th>Trending</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@foreach ($subcategories as $subcategorie)
										<tr>
											<td><img class="cat-thumb" src="assets/img/category/clothes.png" alt="product image"/></td>
											<td>{{$subcategorie->nom}}</td>
											<td>
												<span class="ec-sub-cat-list">
													<span class="ec-sub-cat-tag">{{$subcategorie->categorie->nom}}</span>
												</span>
											</td>
											<td>28</td>
											<td>2161</td>
											<td>ACTIVE</td>
											<td><span class="badge badge-success">Top</span></td>
											<td>
												<div class="btn-group">
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
@extends('admin.layouts.master')
@section('content')
	<!-- CONTENT WRAPPER -->
	<div class="ec-content-wrapper">
		<div class="content">
			<div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
					<h1>Categorie Principale</h1>
					<p class="breadcrumbs"><span><a href="{{route('admin.dashboard')}}">Home</a></span>
						<span><i class="mdi mdi-chevron-right"></i></span>Categorie Principale</p>
			</div>
			<div class="row">
				<div class="col-xl-4 col-lg-12">
					<div class="ec-cat-list card card-default mb-24px">
						<div class="card-body">
							<div class="ec-cat-form">
								<h4>Ajouter une nouvelle Categorie</h4>

								<form method="POST" action="{{route('categories.store')}}" enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="text" class="col-12 col-form-label">Nom</label> 
										<div class="col-12">
											<input id="text" name="nom" class="form-control here slug-title" type="text" placeholder="Nom de la categorie">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-12 col-form-label">Description</label> 
										<div class="col-12">
											<textarea id="fulldescription" name="description" cols="40" rows="4" class="form-control" placeholder="Description"></textarea>
										</div>
									</div> 

									<div class="form-group row">
										<label class="col-12 col-form-label">Photo</label>
										<div class="col-12">
											<input id="text" name="photo" class="form-control here slug-title" type="file" placeholder="Ajouter une photo ">
										</div>
									</div>

									<div class="row">
										<div class="col-12">
											<button name="submit" type="submit" class="btn btn-primary">Enregistrer</button>
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
											<th>Thumb</th>
											<th>Name</th>
											<th>Sub Categories</th>
											<th>Product</th>
											<th>Total Sell</th>
											<th>Status</th>
											<th>Trending</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@foreach ( $categories as $categorie )
										<tr>
											<td><img class="cat-thumb" src="{{asset('storage/'.$categorie->photo)}}" alt="Product Image" /></td>
											<td>{{$categorie->nom}}</td>
											<td>
												<span class="ec-sub-cat-list">
												<span class="ec-sub-cat-count" title="Total Sub Categories">5</span>
												<span class="ec-sub-cat-tag">T-shirt</span>
												<span class="ec-sub-cat-tag">Shirt</span>
												<span class="ec-sub-cat-tag">Dress</span>
												<span class="ec-sub-cat-tag">Jeans</span>
												<span class="ec-sub-cat-tag">Top</span>
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
@extends('admin.layouts.master')
@section('content')
	<!-- CONTENT WRAPPER -->
	<div class="ec-content-wrapper">
		<div class="content">
			<div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
					<h1>Fond de caisse</h1>
					<p class="breadcrumbs"><span><a href="{{route('admin.dashboard')}}">Acceuil</a></span>
						<span><i class="mdi mdi-chevron-right"></i></span>Fond de caisse</p>
			</div>
			@include('admin.layouts.errors-infos')
			<div class="row">
				<div class="col-xl-7 col-lg-12">
					<div class="ec-cat-list card card-default mb-24px">
						<div class="card-body">
							<div class="ec-cat-form">
								<h4>Ajouter fond de caisse</h4>

								<form method="POST" action="{{route('fonds.store')}}" enctype="multipart/form-data">
									@csrf
									
									<div class="form-group row">
										<label for="text" class="col-12 col-form-label">Montant initial</label> 
										<div class="col-12">
											<input id="montant_initial" name="montant_initial" class="form-control here slug-title" type="number" placeholder="montant initial">
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
				<div class="col-xl-5 col-lg-12">
					<div class="ec-cat-list card card-default">
						<div class="card-body">
							<div class="table-responsive">
								<table id="responsive-data-table" class="table">
									<thead>
										<tr>
											<th>N°</th>
											<th>Montant initial</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@foreach ( $fondDeCaisse as $fond )
										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{number_format($fond->montant_initial,'0',',','.')}} FrCFA</td>
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
@section('script')
    <script src="{{ asset('plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plugins/data-tables/datatables.responsive.min.js') }}"></script>
@endsection
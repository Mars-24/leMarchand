@extends('admin.layouts.master')
@section('content')
     <!-- CONTENT WRAPPER -->
	 <div class="ec-content-wrapper">
		<div class="content">
			<div class="breadcrumb-wrapper breadcrumb-contacts">
				<div>
					<h1>{{optional(auth('admin')->user())->role ?? 'Utilisateur'}} Profil</h1>
					<p class="breadcrumbs"><span><a href="{{route('admin.dashboard')}}">Dashboard</a></span>
						<span><i class="mdi mdi-chevron-right"></i></span>Profil
					</p>
				</div>
				<div>
					<a href="#" class="btn btn-primary">Editer</a>
				</div>
			</div>
			@include('admin.layouts.errors-infos')

			<div class="card bg-white profile-content">
				<div class="row">
					<div class="col-lg-4 col-xl-3">
						<div class="profile-content-left profile-left-spacing">
							<div class="text-center widget-profile px-0 border-0">
								<div class="card-img mx-auto rounded-circle">
									<img src="{{asset('img/user/u1.jpg')}}" alt="user image">
								</div>
								<div class="card-body">
									<h4 class="py-2 text-dark">{{auth('admin')->user()->nom}}</h4>
									<p>{{auth('admin')->user()->email}}</p>
									<a class="btn btn-primary my-3" href="#">{{auth('admin')->user()->role}}</a>
								</div>
							</div>

							<hr class="w-100">

							<div class="contact-info pt-4">
								<h5 class="text-dark">Contact Information</h5>
								<p class="text-dark font-weight-medium pt-24px mb-2">Email </p>
								<p>{{auth('admin')->user()->email}}</p>
								<p class="text-dark font-weight-medium pt-24px mb-2">Numéro de téléphone</p>
								@if (auth('admin')->user()->telephone)
								<p>{{auth('admin')->user()->telephone}}</p>

								@else
								<p>Numéro de téléphone non renseigné</p>
	
								@endif
							</div>
						</div>
					</div>

					<div class="col-lg-8 col-xl-9">
						<div class="profile-content-right profile-right-spacing py-5">
							<ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myProfileTab" role="tablist">
								
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="settings-tab" data-bs-toggle="tab"
										data-bs-target="#settings" type="button" role="tab"
										aria-controls="settings" aria-selected="false">Paramètres</button>
								</li>
							</ul>
							<div class="tab-content px-3 px-xl-5" id="myTabContent">


								<div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                    <div class="tab-pane-content mt-5">
                                        <form method="POST" action="{{route('update.profil')}}">
                                            @csrf
                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="firstName">Prénoms</label>
                                                        <input type="text" class="form-control" id="firstName"
                                                            name="prenoms" value="{{ auth('admin')->user()->prenoms }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="lastName">Nom</label>
                                                        <input type="text" class="form-control" id="lastName"
                                                            name="nom" value="{{ auth('admin')->user()->nom }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ auth('admin')->user()->email }}">
                                            </div>

											<div class="form-group mb-4">
												<label for="oldPassword">Ancien mot de passe</label>
												<input type="password" class="form-control @error('oldPassword') is-invalid @enderror" id="oldPassword" name="oldPassword">
												@error('oldPassword')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
											
											<div class="form-group mb-4">
												<label for="password">Nouveau mot de passe</label>
												<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
												@error('password')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
											
											<div class="form-group mb-4">
												<label for="password_confirmation">Confirmez le mot de passe</label>
												<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
											</div>
											
											<div class="d-flex justify-content-end mt-5">
												<button type="submit" class="btn btn-primary mb-2 btn-pill">Mettre à jour Profil</button>
											</div>
											
                                        </form>
                                    </div>
                                </div>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div> <!-- End Content -->
	</div> <!-- End Content Wrapper -->
@endsection

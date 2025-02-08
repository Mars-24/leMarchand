<!DOCTYPE html>
<html lang="en">
	
<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Le Marchand - Admin Dashboar">

		<title>Le Marchand- Admin Dashboard </title>
		
		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="../../../../../fonts.googleapis.com/index.html">
		<link rel="preconnect" href="../../../../../fonts.gstatic.com/index.html" crossorigin>
		<link href="../../../../../fonts.googleapis.com/css21b01.css?family=Montserrat:wght@200;300;400;500;600;700;800&amp;family=Poppins:wght@300;400;500;600;700;800;900&amp;family=Roboto:wght@400;500;700;900&amp;display=swap" rel="stylesheet">

		<link href="../../../../../cdn.jsdelivr.net/npm/%40mdi/font%404.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
		
		<!-- Ekka CSS -->
		<link id="ekka-css" rel="stylesheet" href="{{asset('css/ekka.css')}}" />
		
		<!-- FAVICON -->
		<link href="assets/img/favicon.png" rel="shortcut icon" />
	</head>
	
	<body class="sign-inup" id="body">
		<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-10">
					@include('admin.layouts.errors-infos')
					<div class="card">
						<div class="card-header bg-primary">
							<div class="ec-brand">
								<a href="{{route('admin.connexion')}}" title="Ekka">
									<h2 style="display: contents;color:white">Le Marchand</h2>
									{{-- <img class="ec-brand-icon" src="{{asset('img/logo/logo-login.png')}}" alt="" /> --}}
								</a>
							</div>
						</div>
					
						<div class="card-body p-5">
							<h4 class="text-dark mb-5">Connexion</h4>
							
							<form action="{{route('admin.login')}}" method="POST">
                                @csrf
								<div class="row">
									<div class="form-group col-md-12 mb-4">
										<input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="email" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
									</div>
									
									<div class="form-group col-md-12 ">
										<input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="mot de passe" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
									</div>
									
									<div class="col-md-12">
										<div class="d-flex my-2 justify-content-between">
											<div class="d-inline-block mr-3">
												<div class="control control-checkbox">Remember me
													<input type="checkbox" />
													<div class="control-indicator"></div>
												</div>
											</div>
											
											<p><a class="text-blue" href="#">Forgot Password?</a></p>
										</div>
										
										<button type="submit" class="btn btn-primary btn-block mb-4">Connexion</button>
										
										<p class="sign-upp">Don't have an account yet ?
											<a class="text-blue" href="sign-up.html">Sign Up</a>
										</p>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Javascript -->
		<script src="{{asset('plugins/jquery/jquery-3.5.1.min.js')}}"></script>
		<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('plugins/jquery-zoom/jquery.zoom.min.js')}}"></script>
		<script src="{{asset('plugins/slick/slick.min.js')}}"></script>
	
		<!-- Ekka Custom -->	
		<script src="{{asset('js/ekka.js')}}"></script>
	</body>

</html>
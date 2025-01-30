@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1>Profil du admin</h1>
                    <p class="breadcrumbs"><span><a href="{{route('admin.dashboard')}}">Acceuil</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Profil
                    </p>
                </div>
                <div>
                </div>
            </div>
            <div class="card bg-white profile-content">
                <div class="row">
                    <div class="col-lg-4 col-xl-3">
                        <div class="profile-content-left profile-left-spacing">
                            <div class="text-center widget-profile px-0 border-0">
                                <div class="card-img mx-auto rounded-circle">
                                    @if ($admin->photo)
                                        <img src="{{ asset('storage/' . $admin->photo) }}" alt="user image">
                                    @else
                                        <img src="{{ asset('img/user/u6.jpg') }}" alt="user image">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h4 class="py-2 text-dark">{{ $admin->nom }} {{ $admin->prenoms }}</h4>
                                    <p>{{ $admin->email }}</p>
                                </div>
                            </div>



                            <hr class="w-100">

                            <div class="contact-info pt-4">
                                <h5 class="text-dark">Admin Information</h5>
                                <p class="text-dark font-weight-medium pt-24px mb-2">Email</p>
                                <p>{{ $admin->email }}</p>
                                <p class="text-dark font-weight-medium pt-24px mb-2">Numero</p>
                                @if ($admin->telephone)
                                    <p>{{ $admin->telephone }}</p>
                                @else
                                    <p>Pas de numero</p>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-xl-9">
                        <div class="profile-content-right profile-right-spacing py-5">
                            <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myProfileTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                        aria-selected="true">Profile</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                        data-bs-target="#settings" type="button" role="tab" aria-controls="settings"
                                        aria-selected="false">Parametre</button>
                                </li>
                            </ul>
                            <div class="tab-content px-3 px-xl-5" id="myTabContent">

                                <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <div class="tab-widget mt-5">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="media widget-media p-3 bg-white border">
                                                    <div class="icon rounded-circle mr-3 bg-primary">
                                                        <i class="mdi mdi-account-outline text-white "></i>
                                                    </div>

                                                    <div class="media-body align-self-center">
                                                        <h4 class="text-primary mb-2" data-role="normal">Rôle Normal</h4>
                                                        @if ($admin->role == 'normal')
                                                            <p>Rôle Actuel</p>
                                                        @else
                                                            <p>Activer</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="media widget-media p-3 bg-white border">
                                                    <div class="icon rounded-circle bg-warning mr-3">
                                                        <i class="mdi mdi-cart-outline text-white "></i>
                                                    </div>

                                                    <div class="media-body align-self-center">
                                                        <h4 class="text-primary mb-2" data-role="gerant">Rôle Gerand</h4>
                                                        @if ($admin->role == 'gerand')
                                                            <p>Rôle Actuel</p>
                                                        @else
                                                            <p>Activer</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="media widget-media p-3 bg-white border">
                                                    <div class="icon rounded-circle mr-3 bg-success">
                                                        <i class="mdi mdi-ticket-percent text-white "></i>
                                                    </div>

                                                    <div class="media-body align-self-center">
                                                        <h4 class="text-primary mb-2" data-role="admin">Rôle Administrateur</h4>
                                                        @if ($admin->role == 'admin')
                                                            <p>Rôle Actuel</p>
                                                        @else
                                                            <p>Activer</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                    <div class="tab-pane-content mt-5">
                                        <form>
                                            <div class="form-group row mb-6">
                                                <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">User
                                                    Image</label>
                                                <div class="col-sm-8 col-lg-10">
                                                    <div class="custom-file mb-1">
                                                        <input type="file" class="custom-file-input" id="coverImage"
                                                            required>
                                                        <label class="custom-file-label" for="coverImage">Choose
                                                            file...</label>
                                                        <div class="invalid-feedback">Example invalid custom
                                                            file feedback</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="firstName">Prenoms</label>
                                                        <input type="text" class="form-control" id="firstName"
                                                            name="prenoms" value="{{ $admin->prenoms }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="lastName">Nom</label>
                                                        <input type="text" class="form-control" id="lastName"
                                                            name="nom" value="{{ $admin->nom }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $admin->email }}">
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="oldPassword">Ancien mot de passe</label>
                                                <input type="password" class="form-control" id="oldPassword">
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="newPassword">Nouveau mot de passe</label>
                                                <input type="password" class="form-control" id="newPassword">
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="conPassword">Confirmez mot de passe</label>
                                                <input type="password" class="form-control" id="conPassword">
                                            </div>

                                            <div class="d-flex justify-content-end mt-5">
                                                <button type="submit" class="btn btn-primary mb-2 btn-pill">Mettre à jour
                                                    Profil</button>
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
@section('script')
    
@endsection
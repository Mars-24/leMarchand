@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper ec-ec-content-wrapper mb-m-24px">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1>Session Administration</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Administrateur
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-contact">
                        Ajouter administrateur
                    </button>
                </div>
            </div>
 
            <div class="row">
                @foreach ($admins as $admin)
                    <div class="col-lg-6 col-xl-4 mb-24px">
                        <div class="ec-user-card card card-default p-4">
                            <a href="javascript:0" data-bs-toggle="modal" data-bs-target="#modalContact{{$admin->id}}"
                                class="view-detail"><i class="mdi mdi-eye-plus-outline"></i>
                            </a>
                            <a href="javascript:0" class="media text-secondary">
                                @if ($admin->photo)
                                    <img src="{{ asset('storage/' . $admin->photo) }}" class="mr-3 img-fluid"
                                        alt="Avatar Image">
                                @else
                                    <img src="{{ asset('img/user/u-xl-6.jpg') }}" class="mr-3 img-fluid" alt="Avatar Image">
                                @endif

                                <div class="media-body">
                                    <h5 class="mt-0 mb-2 text-dark">{{ $admin->nom }} {{ $admin->prenoms }}</h5>

                                    <ul class="list-unstyled">
                                        <li class="d-flex mb-1">
                                            <i class="mdi mdi-email mr-1"></i>
                                            <span>{{ $admin->email }}</span>
                                        </li>
                                        <li class="d-flex mb-1">
                                            <i class="mdi mdi-phone mr-1"></i>
                                            <span>{{ $admin->telephone }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>

					 <div class="modal fade modal-contact-detail" id="modalContact{{$admin->id}}" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header justify-content-end border-bottom-0">
									<button type="button" class="btn-edit-icon mr-3" title="modifier" data-bs-dismiss="modal" aria-label="Close">
										<i class="mdi mdi-pencil"></i>
									</button>
                                    <form action="{{route('admins.destroy',$admin->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn-delete-icon mr-3" title="supprimer" data-bs-dismiss="modal" data-id="{{$admin->id}}" aria-label="Close">
                                            <i class="mdi mdi-delete-forever"></i>
                                        </button>
                                    </form>
									
									<button type="button" class="btn-close-icon" title="fermer" data-bs-dismiss="modal" aria-label="Close">
										<i class="mdi mdi-close"></i>
									</button>
								</div>
		
								<div class="modal-body pt-0">
									<div class="row no-gutters">
										<div class="col-md-6">
											<div class="profile-content-left px-4">
												<div class="text-center widget-profile px-0 border-0">
													<div class="card-img mx-auto rounded-circle">
														@if ($admin->photo)
														<img src="{{asset('storage/'.$admin->photo)}}" alt="user image">
														@else
														<img src="{{asset('img/user/u6.jpg')}}" alt="user image">
														@endif
													</div>
		
													<div class="card-body">
														<h4 class="py-2 text-dark">{{ $admin->nom }} {{ $admin->prenoms }}</h4>
														<p class="my-4">{{ $admin->email }}</p>
														<a class="btn btn-primary btn-pill my-4" href="{{route('admins.show',$admin->id)}}">Details</a>
													</div>
												</div>
		
												<div class="d-flex justify-content-between ">
													<div class="text-center pb-4">
														<h6 class="text-dark pb-2">Rôle</h6>
														<p>{{ $admin->role }}</p>
													</div>												
												</div>
											</div>
										</div>
		
										<div class="col-md-6">
											<div class="contact-info px-4">
												<h4 class="text-dark mb-1">admin Details</h4>
												<p class="text-dark font-weight-medium pt-4 mb-2">Email adresse</p>
												<p>{{$admin->email}}</p>
												<p class="text-dark font-weight-medium pt-4 mb-2">Numero de telephone</p>
												<p>{{$admin->telephone}}</p>
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		
                @endforeach

            </div>

           
            <!-- Add Contact Button  -->
            <div class="modal fade modal-add-contact" id="modal-add-contact" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('admins.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header px-4">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Ajouter un administrateur</h5>
                            </div>

                            <div class="modal-body px-4">
                                <div class="form-group row mb-6">
                                    <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">
                                        Image admin</label>

                                    <div class="col-sm-8 col-lg-10">
                                        <div class="custom-file mb-1">
                                            <input type="file" name="photo" class="custom-file-input"
                                                id="coverImage">
                                            <label class="custom-file-label" for="coverImage">Choisir fichier...
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="firstName">Nom</label>
                                            <input type="text" name="nom" class="form-control" id="firstName"
                                                placeholder="John">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastName">Prenoms</label>
                                            <input type="text" name="prenoms" class="form-control" id="lastName"
                                                placeholder="Deo">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="userName">Telephone</label>
                                            <input type="text" class="form-control" name="telephone" id="userName"
                                                placeholder=" 92000000">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="johnexample@gmail.com">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="adresse">Adresse</label>
                                            <input type="text" name="adresse" class="form-control" id="adresse"
                                                placeholder="rue larimie">
                                        </div>
                                    </div>
                                 <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="role">Rôle</label>
                                            <select id="parent-category" name="role" class="form-control">
												<option value="default">Type rôle</option>
												<option value="normal">Normal</option>
                                                <option value="gerant">Gérant</option>
                                                <option value="admin">Admin</option>

											</select>
                                        </div>
                                    </div> 

                                    
                                </div>
                            </div>

                            <div class="modal-footer px-4">
                                <button type="button" class="btn btn-secondary btn-pill"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary btn-pill">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->

@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var coverImage = document.getElementById('coverImage');
        coverImage.addEventListener('change', function() {
            var fileName = this.files[0].name;
            var nextSibling = this.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    });
</script>
 <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('.btn-delete-icon').click(function (e) {
    var form = $(this).closest('form');
    var dataID = $(this).data('id');
    e.preventDefault();
    swal({
        title: "êtes vous sure?",
        text: "OUne fois supprimé,vous ne pouvez plus recuperer le fichier!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
                swal("Poof! admin à été supprimé!", {
                    icon: "success",
                });
            } else {
                swal("Suppression annulée");
            }
        });
});
</script>
@endsection
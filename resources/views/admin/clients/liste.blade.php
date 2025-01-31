@extends('admin.layouts.master')
@section('content')
   	<!-- CONTENT WRAPPER -->
       <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1>Clients Fidèles</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>clients fidèles
                    </p>
                </div>
               
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="ec-vendor-list card card-default">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="responsive-data-table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Profile</th>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Total Acheté</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($superclients as $client)

                                        <tr>
                                            <td>
                                                @if ($client->photo)
                                                <img class="vendor-thumb" src="{{ asset('storage/' . $client->photo) }}"
                                                    alt="Avatar Image">
                                            @else
                                                <img src="{{ asset('img/vendor/u1.jpg') }}" class="vendor-thumb" alt="Avatar Image">
                                            @endif
                                                                                        
                                            </td>
                                            <td>{{ $client->nom }} {{ $client->prenoms }}</td>
                                            <td>@if ($client->email)
                                                {{$client->email}}
                                            @else
                                                Pas de email
                                            @endif</td>
                                            <td>@if ($client->telephone)
                                                {{$client->telephone}}
                                            @else
                                                Pas de numero
                                            @endif</td>
                                            <td>{{$client->orders_count}}</td>
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
                                                        <a class="dropdown-item" href="{{route('clients.show',$client->id)}}">details</a>
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
            <!-- Add User Modal  -->
            <div class="modal fade modal-add-contact" id="addUser" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header px-4">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Add New User</h5>
                            </div>

                            <div class="modal-body px-4">
                                <div class="form-group row mb-6">
                                    <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">User
                                        Image</label>

                                    <div class="col-sm-8 col-lg-10">
                                        <div class="custom-file mb-1">
                                            <input type="file" class="custom-file-input" id="coverImage"
                                                required>
                                            <label class="custom-file-label" for="coverImage">Choose
                                                file...</label>
                                            <div class="invalid-feedback">Example invalid custom file feedback
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="firstName">First name</label>
                                            <input type="text" class="form-control" id="firstName" value="John">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="lastName">Last name</label>
                                            <input type="text" class="form-control" id="lastName" value="Deo">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="userName">User name</label>
                                            <input type="text" class="form-control" id="userName"
                                                value="johndoe">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                value="johnexample@gmail.com">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="Birthday">Birthday</label>
                                            <input type="text" class="form-control" id="Birthday"
                                                value="10-12-1991">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label for="event">Address</label>
                                            <input type="text" class="form-control" id="event"
                                                value="Address here">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer px-4">
                                <button type="button" class="btn btn-secondary btn-pill"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary btn-pill">Save Contact</button>
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
                swal("Poof! le client à été supprimé!", {
                    icon: "success",
                });
            } else {
                swal("Suppression annulée");
            }
        });
});
</script>
<script src="{{asset('plugins/data-tables/jquery.datatables.min.js')}}"></script>
	<script src="{{asset('/plugins/data-tables/datatables.bootstrap5.min.js')}}"></script>
	<script src="{{asset('plugins/data-tables/datatables.responsive.min.js')}}"></script>
@endsection
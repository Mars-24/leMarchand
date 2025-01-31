@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
                <h1>Depenses et sortie de caisse</h1>
                <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Acceuil</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Depenses et sortie de caisse
                </p>
            </div>
            @include('admin.layouts.errors-infos')
            <div class="row">
                <div class="col-xl-5 col-lg-12">
                    <div class="ec-cat-list card card-default mb-24px">
                        <div class="card-body">
                            <div class="ec-cat-form">
                                <h4>Ajouter une nouvelle depense</h4>

                                <form method="POST" action="{{ route('depenses.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-12 col-form-label">Argent à retirer</label>
                                        <div class="col-12">
                                            <input id="argent" name="montant" class="form-control here slug-title"
                                                type="number" placeholder="Retrait (cfa)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Motif de la depense</label>
                                        <div class="col-12">
                                            <textarea id="fulldescription" name="motif" cols="40" rows="4" class="form-control"
                                                placeholder="Motif de la depense"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button name="submit" type="submit"
                                                class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-12">
                    <div class="ec-cat-list card card-default">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="responsive-data-table" class="table">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Motif du retrait</th>
                                            <th>Somme retiré</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($depenses as $depense)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $depense->motif }}</td>
                                                <td>{{   number_format($depense->montant,'0',',','.') }} fr</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-outline-success">Info</button>
                                                        <button type="button"
                                                            class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" data-display="static">
                                                            <span class="sr-only">Info</span>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Editer</a>
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
@extends('admin.layouts.master')
@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Ajouter Produit</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin.dashboard') }}">Dashboard</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Produit
                    </p>
                </div>
                <div>
                    <a href="{{ route('produits.index') }}" class="btn btn-primary"> Liste des produits
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Ajouter Produit</h2>
                        </div>

                        <div class="card-body">
                            <div class="row ec-vendor-uploads">
                                <div class="col-lg-4">
                                    <div class="ec-vendor-img-upload">
                                        <div class="ec-vendor-main-img">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' id="imageUpload" class="ec-image-upload"
                                                        accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"><img src="{{ asset('img/icons/edit.svg') }}"
                                                            class="svg_img header_svg" alt="edit" /></label>
                                                </div>
                                                <div class="avatar-preview ec-preview">
                                                    <div class="imagePreview ec-div-preview">
                                                        <img class="ec-image-preview"
                                                            src="{{ asset('img/products/vender-upload-preview.jpg') }}"
                                                            alt="edit" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="ec-vendor-upload-detail">
                                        <form class="row g-3" action="{{route('produits.store')}}" method="POST" enctype="multipart/form-data" onsubmit="handleFormSubmit(event)">
											@csrf
											@php
											// Regrouper les sous-catégories par category_id
											$groupedSubCategories = $subCategories->groupBy('categorie_id');
											@endphp
                                            <div class="col-md-6">
                                                <label class="form-label">Select Categories</label>
                                                <select name="subcategory_id" id="Categories" class="form-select">
													<option value="default" disabled selected>Categorie</option>
                                                    @foreach ($groupedSubCategories as $categoryId => $subCategories)
                                                        <optgroup label="{{ $subCategories->first()->categorie->nom }}">
                                                            <!-- Assurez-vous que category_name est disponible -->
                                                            @foreach ($subCategories as $subCategory)
                                                                <option value="{{ $subCategory->id }}">
                                                                    {{ $subCategory->nom }}</option>
                                                                <!-- Ajustez selon les attributs disponibles -->
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputEmail4" class="form-label">Model Produit</label>
                                                <input type="text" class="form-control slug-title" id="inputEmail4" name="model">
                                            </div>
											<div class="col-md-6">
                                                <label class="form-label">Prix d'achat <span>( En CFA
                                                        )</span></label>
                                                <input type="number" class="form-control" id="price1" name="prix_achat"> 
                                            </div>
											<div class="col-md-6">
                                                <label class="form-label">Prix de vente <span>( En CFA
                                                        )</span></label>
                                                <input type="number" class="form-control" id="price2" name="prix_vente">
                                            </div>            
											<div class="col-md-6">
                                                <label class="form-label">Prix minimuin de vente <span>( En CFA
                                                        )</span></label>
                                                <input type="number" class="form-control" id="price3" name="prix_minimum">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Quantité</label>
                                                <input type="number" class="form-control" id="quantity1" name="quantite">
                                            </div>
											<div class="col-md-6">
                                                <label class="form-label">Ganrantie <span>(En Année)</span> </label>
                                                <input type="number" class="form-control" id="garantie1" name="garantie">
                                            </div>
											<div class="col-md-6">
                                                <label class="form-label">Fournisseur</label>
                                                <select name="fournisseur_id" id="Fournisseur" class="form-select" onchange="checkFournisseur(this.value)">
													<option value="default" disabled selected>Nom fournisseur</option>
                                                    @foreach ($fournisseurs as $fournisseur)
                                                                <option value="{{ $fournisseur->id }}">
                                                                    {{ $fournisseur->nom }}</option>
                                                    @endforeach
													<option value="absent">Nouveau Fournisseur</option>
                                                </select>
                                            </div>
											<div class="row" id="newFournisseurDiv" style="display: none;">
													<div class="form-group row mb-6">
														<label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">
															Image Fournisseur</label>
					
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
																<label for="firstName">Nom Fournisseur</label>
																<input type="text" name="nom" class="form-control" id="firstName"
																	placeholder="John">
															</div>
														</div>
					
														<div class="col-lg-6">
															<div class="form-group">
																<label for="lastName">Prenoms Fournisseur</label>
																<input type="text" name="prenoms" class="form-control" id="lastName"
																	placeholder="Deo">
															</div>
														</div>
					
														<div class="col-lg-6">
															<div class="form-group mb-4">
																<label for="userName">Telephone Fournisseur</label>
																<input type="text" class="form-control" name="telephone" id="userName"
																	placeholder=" 92000000">
															</div>
														</div>
					
														<div class="col-lg-6">
															<div class="form-group mb-4">
																<label for="email">Email Fournisseur</label>
																<input type="email" name="email" class="form-control" id="email"
																	placeholder="johnexample@gmail.com">
															</div>
														</div>
													</div>
												
											</div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
											 <!-- Hidden input to hold the image file -->
											 <input type="file" name="file" id="hiddenImageInput" style="display: none;">
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
<script>
	function checkFournisseur(value) {
		var newFournisseurDiv = document.getElementById('newFournisseurDiv');
		if (value === 'absent') {
			newFournisseurDiv.style.display = 'block';
		} else {
			newFournisseurDiv.style.display = 'none';
		}
	}
	function handleFormSubmit(event) {
            var imageUpload = document.getElementById('imageUpload');
            var hiddenImageInput = document.getElementById('hiddenImageInput');
            if (imageUpload.files.length > 0) {
                hiddenImageInput.files = imageUpload.files;
            }
        }
</script>
@endsection
<!-- Votre tableau -->
<table class="table mt-3 table-striped table-responsive table-responsive-large inv-tbl" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <td class="del-btn">Supprimer</td>
            <th>produit</th>
            <th>Deal</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('facture')->content() as $item)
            <tr>
                <td>1</td>
                <td class="del-btn"> <span class="cart_delete" data-id="{{ $item->rowId }}"> <i class="mdi mdi-delete-forever"></i>
                    </span></td>
                <td>{{ $item->name }}</td>
                <td class="btn-text-deal">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-contact">
                        produit deal
                    </button>
                </td>
                <td id="total_tab">{{ $item->subtotal(0, ' ', ' ') }} fr</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row justify-content-end inc-total">
    <div class="col-lg-3 col-xl-3 col-xl-3 ml-sm-auto">
        <ul class="list-unstyled mt-3">
            
            <li class="pb-3 text-dark">Total :
                <span class="d-inline-block float-right"
                    id="total">{{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal(0, ' ', ' ') }} fr</span>
            </li>
        </ul>
    </div>
</div>
<!-- Modal -->
<div class="modal fade modal-add-contact" id="modal-add-contact" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Ajouter un client</h5>
                </div>

                <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                        <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">
                            Image du produit</label>

                        <div class="col-sm-8 col-lg-10">
                            <div class="custom-file mb-1">
                                <input type="file" name="photo" class="custom-file-input" id="coverImage">
                                <label class="custom-file-label" for="coverImage">Choisir fichier...
                                </label>

                            </div>
                        </div>
                    </div>
                    @php
                    // Regrouper les sous-catégories par category_id
                    $groupedSubCategories = $subCategories->groupBy('categorie_id');
                    @endphp
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <!-- Catégories et sous-catégories -->
                            <div class="form-group">
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
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="modelProduit" class="form-label">Model Produit</label>
                                <input type="text" class="form-control slug-title" id="modelProduit" name="model">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Prix d'achat <span>( En CFA )</span></label>
                                <input type="number" class="form-control" id="prixachat" name="prix_achat"> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Prix de vente <span>( En CFA )</span></label>
                                <input type="number" class="form-control" id="price2" name="prix_vente">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Prix minimum de vente <span>( En CFA )</span></label>
                                <input type="number" class="form-control" id="price3" name="prix_minimum">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer px-4">
                    <button id="cancelBtn" type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Annuler</button>
                    <button id="dealBtn" type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .cart_delete {
        text-align: center;
        display: flex;
        justify-content: center;
        color: red;
        font-size: 20px;
        font-weight: 900;
        cursor: pointer;
    }
</style>
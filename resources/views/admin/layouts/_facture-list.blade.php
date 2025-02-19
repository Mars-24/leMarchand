<table class="table mt-3 table-striped table-responsive table-responsive-large inv-tbl" style="width:100%">
    <thead>
        <tr>
            <th class="del-btn">#</th>
            <td class="del-btn">Supprimer</td>
            <th>produit</th>
            <th>prix</th>
            <th>Garantie</th>
            <th class="del-btn">Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('facture')->content() as $item)
            <tr>
                <td class="del-btn" >{{$loop->index+1}}</td>
                <td class="del-btn"> <span class="cart_delete" data-id="{{ $item->rowId }}"> <i class="mdi mdi-delete-forever"></i>
                    </span>
                <td>{{ $item->name }} </td>

                <td class="price-td">
                    <input class="price-text" type="number" data-id="{{ $item->rowId }}"
                        id="price-input-{{ $item->rowId }}" value="{{ $item->price }}" name="price"> fr

                </td>
                <td>{{ $item->options->garantie .'Jour(s)' ?? 'Non spécifiée' }} </td>

                <td class="del-btn">{{ $item->subtotal(0, ' ', ' ') }} fr</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row justify-content-end inc-total">
    <div class="col-lg-3 col-xl-3 col-xl-3 ml-sm-auto">
        <ul class="list-unstyled mt-3">
            <li class="mid pb-3 text-dark"> Total partiel :
                <span
                    class="d-inline-block float-right text-default">{{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal(0, ' ', ' ') }}
                    fr</span>
                <input type="hidden" name="total-partiel"
                    value="{{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal(0, ' ', ' ') }} ">
            </li>

            <li class="mid pb-3 text-dark" style="display: flex;">Réduction
                <span class="d-inline-block float-right text-default"> :<input id="reduction" type="number"
                        name="reduction" value="0" min="0"
                        style="width: 85%;background-color: transparent;border: none;outline: none;text-align:right">fr</span>
            </li>

            <li class="pb-3 text-dark">Total :
                <span class="d-inline-block float-right"
                    id="total">{{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal(0, ' ', ' ') }} fr</span>
            </li>
        </ul>
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

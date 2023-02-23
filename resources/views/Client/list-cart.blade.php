
<div class="cart-table">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th class="p-name">Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody id="change-list">
            @if (Session::has('cart') != null)
@foreach (Session::get('cart')->dulieu as $item)
            <tr>
                <td class="cart-pic first-row"><img src="{{ asset('uploads/') }}/{{ $item['productinfo']->image_product }}" alt=""></td>
                <td class="cart-title first-row">
                    <h5>{{ $item['productinfo']->name_product }}</h5>
                </td>
                <td class="p-price first-row">₫{{ $item['productinfo']->price }} </td>
                <td class="qua-col first-row">
                    <div class="quantity">
                        <div class="pro-qty">
                            <input type="text" value="{{ $item['quanty'] }}">
                        </div>
                    </div>
                </td>
                <td class="total-price first-row">₫{{ $item['price'] }}</td>
                <td class="close-td first-row"><i class="ti-close" onclick="Deletelist({{ $item['productinfo']->id_product }});"></i></td>
                <td class="close-td first-row"><i class="ti-save"></i></td>
                @endforeach
                @endif
        </tbody>
      
    </table>
</div>


<div class="row">
    <div class="col-lg-4 offset-lg-8">
        <div class="proceed-checkout">
            <ul>
                <li class="subtotal">Tổng tiền <span>{{Session::get('cart')->totalprice }}</span></li>
              
            </ul>
            <a href="#" class="proceed-btn">PROCEED TO CHECK OUT</a>
        </div>
    </div>
</div>
<script src="{{ asset('assets/demo/demo.js') }}"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery.zoom.min.js"></script>
<script src="js/jquery.dd.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
   function Dletelist(id_product){
    console.log(id_product);
   }
</script>
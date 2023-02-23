@extends('Layout_client')
@section('body')


<body>
 <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                      
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                  
<div class="cart-table" style="background-color: rgb(232, 232, 232)">
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
        <tbody>
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
                <td class="close-td first-row"><i class="ti-close"></i></td>
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
                @if (Session::has('cart') != null)
                <li class="subtotal">Tổng tiền <span>{{Session::get('cart')->totalprice }}</span></li>
             
            </ul>
            <a href="#" class="proceed-btn">Thanh toán</a>
        </div>
        @endif
    </div>
</div>

                </div>
            </div>
        </div>
    </section>
   


</body>

    
@endsection
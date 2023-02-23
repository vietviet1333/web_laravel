@if (Session::has('cart') != null)



    <div class="select-items" style="width: 300px">
        <table>
            <tbody>
                @foreach (Session::get('cart')->dulieu as $item)
                    <tr>
                        <td class="si-pic"><img src="{{ asset('uploads/') }}/{{ $item['productinfo']->image_product }}"
                                alt="" style="width: 80px"></td>
                        <td class="si-text">
                            <div class="product-selected" style="padding: 10px 10px">
                                <p>₫{{ $item['productinfo']->price }} x {{ $item['quanty'] }}</p>
                                <h6>{{ $item['productinfo']->name_product }}</h6>
                            </div>
                        </td>
                        <td class="si-close">
                            <i class="ti-close"  onclick="Delete({{ $item['productinfo']->id_product }})"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="select-total" style="display: flex">
        <span style="padding-right: 100px">Tổng tiền:</span>
        <h5>{{Session::get('cart')->totalprice }}</h5>
    </div>
@endif
<div class="select-button">
    <a href="/cart" class="primary-btn view-card">Xem giỏ hàng</a>
    
</div>

<script>
    function Delete(id_product){
        $.ajax({
  type: "GET",
  url: "/deletepro/"+id_product
}).done(function(reponse){

$("#change").html(reponse);
alertify.success('Đã xóa sản phẩm');
});
    }
</script>
@extends('Client.Layout')
@section('body')
<div class="sp" style="margin: auto;padding-top:200px"> 
    <ul>
        @foreach ($items as $item)
            <li>
                <div class="product-item">
                    <div class="product-top">
                        <a href="" class="product-thumb"><img
                                src="{{ asset('uploads/') }}/{{ $item->image_product }}" alt=""></a>
                        <a href="/show/{{ $item->id_product }}" class="seennow">Xem chi tiết</a>
                    </div>
                    <div class="product-info">
                        <a href="" class="product-name">{{ $item->name_product }}</a>

                        <div class="product-price" style="font-size: 0.7rem;color:red">{{ $item->price }}$</div>
                        <a href="javascript:" onclick="AddCart({{ $item->id_product }})" style="color: black"> <i
                                class="fa-sharp fa-solid fa-cart-plus"></i></a>

                    </div>
                </div>
            </li>
        @endforeach
        @csrf

    </ul>
        
         <div >
             {!! $items->links() !!}
         </div> 
    
   </div>
    {{-- <div class="container"><a href="/load" class="button" id="load_more">LOAD MORE ...</a></div> --}}
@endsection
@section('scripts')
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
function AddCart(id_product){
$.ajax({
type: "GET",
url: "/addcart/"+id_product
}).done(function(reponse){
console.log(reponse)
$("#change").empty();
$("#change").html(reponse);
alertify.success('Đã thêm vào giỏ hàng');
});
}

</script>
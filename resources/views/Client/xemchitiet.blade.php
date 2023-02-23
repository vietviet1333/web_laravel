@extends('Client.Layout')
@section('body')
<div>
   @foreach ($products as $product )
       <div style="display: flex">
         <div style="width: 30%;padding-bottom:30px;padding-left:30px">  <img src="{{ asset('uploads/') }}/{{ $product->image_product }}" class="card-img-top"
            style="max-height: 20rem"alt="..." ></div>
           <div style="padding-left: 200px">
             <div><h1>{{$product->name_product}}</h1></div>
             <div style="height: 100px">{{$product->price}}đ</div>
             <p class="card-text"> @php
              echo html_entity_decode($product->ingredient);
          @endphp</p>
             <a href="" class="btn btn-primary" style="background-color: black">Mua Ngay</a>
             <i class="fa-sharp fa-solid fa-cart-plus" style="padding-left: 50px"></i>
           </div>
       </div>
   @endforeach
</div>

@endsection
@extends('Layout_client')
@section('body')
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel"
        style="z-index: -10;max-height:800px">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
        aria-label="Slide 2"></button>

        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="{{ asset('picture/slider_2.jpg') }}" class="d-block w-100" alt="..." style="height: 700px;width:100%;overflow:hidden">
                <div class="carousel-caption d-none d-md-block">
                    <h5>What's your fashion</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="{{ asset('picture/ms_banner_img1.jpg') }}" class="d-block w-100" alt="..."style="height: 700px;width:100%;overflow:hidden">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="tieu">NEW ARRIVALS</div>

    <div style="padding: 0;margin:auto" class="sp">
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
  
    <div class="al" style="text-align: center">
        <button>
            <a href="/allproduct">TẤT CẢ SẢN PHẨM</a>
        </button>

    </div>
    <div class="tieu">NTV.JR</div>
    <div class="news">
        <img src="{{ asset('picture/03c229f5e7ae20f079bf.jpg') }}" alt="">
        <img src="{{ asset('picture/7fe15d39ab626c3c3573.jpg') }}" alt="">
        <img src="{{ asset('picture/63e1ff950fcec89091df.jpg') }}" alt="">
        <img src="{{ asset('picture/966ddf2c1277d5298c66.jpg') }}" alt="">
    </div>
</div>
<div>
    <div class="tieu">Feedback</div>
    <div class="fe">
        <img src="{{ asset('picture/index-evo-icon-1.jpg') }}" alt="">
        <img src="{{ asset('picture/index-evo-icon-2.jpg') }}" alt="">
        <img src="{{ asset('picture/index-evo-icon-3.jpg') }}" alt="">
        
    </div>
</div>
<div style="text-align: center">
    <img src="{{asset('picture/db1b16c209b6cee897a7.jpg')}}" alt="" style="width: 80%">
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function AddCart(id_product) {
            $.ajax({
                type: "GET",
                url: "/addcart/" + id_product
            }).done(function(reponse) {
                $("#change").empty();
                $("#change").html(reponse);
                alertify.success('Đã thêm vào giỏ hàng');
            });
        }
    </script>
@endsection

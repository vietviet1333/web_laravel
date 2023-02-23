<!DOCTYPE html>
<html lang>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>VIET</title>
    <link href="images/1.png" rel="shorcut icon">
    {{-- <link rel="stylesheet" href="{{ asset('css/ap.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.1.1-web/fontawesome-free-6.1.1-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('js/bootstrap.js') }}">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">

    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/newap.css') }}">
</head>

<body>


    <div id="header">
        <div style="padding: 10px 10px">
            <div style="display: flex">
                <div><a href="https://www.facebook.com/viet1333" style="color: rgb(0, 0, 0);margin-right:10px"><i
                            class="fa-brands fa-facebook"></i></a></div>
                <div><a href="https://www.instagram.com/ntv1333/" style="color: rgb(0, 0, 0)"><i
                            class="fa-brands fa-instagram"></i></a></div>
            </div>
        </div>
        <div class="logo" style="text-align: center;margin:0"><img src="{{ asset('picture/NTV JR.png') }}"
                alt="" style="width: 200px;height:50px;padding-top:0"></div>
        <div class="main-menu">
            <div class="menu-left" style="margin-left: 30px">
                <ul class="menu" style="display: flex;list-style: none">
                    <li><a href="/">TRANG CHỦ</a></li>

                    <li class="down"><a href="">SẢN PHẨM</a>
                        <ul class="drop" style="border-radius: 10px">
                            <li><a href="/allproduct">TẤT CẢ</a></li>
                            <li><a href="/adidas">OXFORD</a></li>
                            <li><a href="/nike">LOAFER</a></li>
                            <li><a href="/jordan">DERBY</a></li>
                            <li><a href="/newbalance">BOOTS</a></li>

                        </ul>
                    </li>
                    <li class="down"><a href="">HỖ TRỢ</a>
                        <ul class="drop" style="border-radius: 10px">
                            <li><a href="/hdmuahang">HƯỚNG DẪN MUA HÀNG</a></li>
                            <li><a href="/csdoitra">CHÍNH SÁCH ĐỔI TRẢ</a></li>
                        </ul>
                    </li>
                    <li><a href="">GIỚI THIỆU</a></li>
                    <li><a href="/lienhe">LIÊN HỆ</a></li>
                </ul>
            </div>
            <div class="menu-left" style="margin-right: 30px">
                <ul class="menu" style="display: flex;list-style: none">

                    <li class="down"><i class="fa-solid fa-magnifying-glass"
                            style="color: rgb(181, 178, 178);padding:0px 20px"></i>
                        <ul class="drop" style="right: 0;border-radius:30px">
                            <li><input type="text" placeholder="Tìm kiếm..."
                                    style="border-radius: 15px;max-width:200px" id="search"></li>
                            <li> @csrf
                                <div id="show"></div>
                            </li>
                        </ul>
                    </li>


                    <li class="down"><i class="fa-solid fa-user"
                            style="color: rgb(181, 178, 178);padding:0px 20px"></i>
                        <ul class="drop" style="right: 0;border-radius:10px">
                            @php
                                if (Session::get('id')) {
                                    $show = '<li><a href="/profile" > TÀI KHOẢN </a></li>' . '<li><a href="/logout"> ĐĂNG XUẤT</a></li>';
                                    echo $show;
                                } else {
                                    echo '<li style="padding:0"><a id="btnopen"  href="javascript:" >ĐĂNG NHẬP</a></li>' . '<li style="padding:0"><a href="/register" >ĐĂNG KÝ</a></li>';
                                    echo Session::get('id');
                                }
                            @endphp
                        </ul>
                    </li>
                    <li class="down"><i class="fa-solid fa-cart-shopping"
                            style="color: rgb(181, 178, 178);padding:0px 20px"></i>
                        <ul class="drop" style="right: 0;border-radius:10px">
                            <div id="change" style="width:300px">
                                @if (Session::has('cart') != null)
                                    <div class="select-items" style="width: 300px">
                                        <table>
                                            <tbody>
                                                @foreach (Session::get('cart')->dulieu as $item)
                                                    <tr>
                                                        <td class="si-pic"><img
                                                                src="{{ asset('uploads/') }}/{{ $item['productinfo']->image_product }}"
                                                                alt="" style="width: 80px"></td>
                                                        <td class="si-text">
                                                            <div class="product-selected" style="padding: 10px 10px">
                                                                <p>₫{{ $item['productinfo']->price }} x
                                                                    {{ $item['quanty'] }}</p>
                                                                <h6>{{ $item['productinfo']->name_product }}</h6>
                                                            </div>
                                                        </td>
                                                        <td class="si-close">
                                                            <i class="ti-close"
                                                                onclick="Delete({{ $item['productinfo']->id_product }})"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total" style="display: flex">
                                        <span style="padding-right: 100px">Tổng tiền:</span>
                                        <h5>{{ Session::get('cart')->totalprice }}</h5>
                                    </div>
                                @endif
                                <div class="select-button" style="text-align: center;height:50px">
                                    <a href="/cart">Xem giỏ hàng</a>

                                </div>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        @yield('body')
    </div>

    <div id="backtop">
        <i class="fa-solid fa-arrow-up"></i>
    </div>
    <div id="modall_container">
        <div id="modall">
            <form action="/client/login" method="get" id="form-login">
                <i class="fa-solid fa-rectangle-xmark" id="cl"></i>
                <h1 class="form-heading">TÀI KHOẢN </h1>
                @if (Session::get('notifications'))
                <h3 class="text-success text-center mb-3">@php echo Session::get('notifications');
                    Session::put('notifications', null);
                @endphp</h3>
            @endif
               <h6 style="color: red"> @php
                if( Session::get('fail')){
                 echo Session::get('fail');
                 Session::put('fail',null);
                } 
                
             @endphp</h6>
                <div class="form-group">
                    <i class="far fa-user"></i>
                    <input type="email" class="form-input" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" class="form-input" placeholder="Mật khẩu">
                    <div id="eye">
                        <i class="far fa-eye"></i>
                    </div>
                </div>
                <input type="" value="Đăng nhập" class="form-submit" id="btnLogin">
            </form>
        </div>
    </div>
    <footer>
        <img src="{{ asset('picture/NTV.JR.png') }}" alt="" class="ifo">

        <div style="color:rgb(0, 0, 0);display:flex;background-color:rgb(255, 255, 255);padding-top:30px">
            <div class="center" style="margin: auto;width: 200px;height:50px"><img
                    src="{{ asset('picture/NTV JR.png') }}" alt=""></div>
            <div class="right" style="margin: auto">
                <div style="display:flex;padding:10px 10px"><i class="fa-solid fa-location-dot"
                        style="padding-right: 10px"></i>
                    <h6 style="font-size: 0.7rem;font-weight:bold">300/15 Nguyen Van Linh</h6>
                </div>
                <div style="display:flex;padding:10px 10px"><i class="fa-sharp fa-solid fa-phone"
                        style="padding-right: 10px"></i>
                    <h6 style="font-size: 0.7rem;font-weight:bold">0393035090</h6>
                </div>
                <div style="display:flex;padding:10px 10px"><i class="fa-solid fa-envelope"
                        style="padding-right: 10px"></i>
                    <h6 style="font-size: 0.7rem;font-weight:bold">vietviet1333@gmail.com</h6>
                </div>
            </div>
            <div class="left" style="margin: auto">
                <h6>Chính Sách</h6>
                <h6 style="font-size: 0.6rem"><a href="/hdmuahang" style="color: black">Hướng Dẫn Mua Hàng</a></h6>
                <h6 style="font-size: 0.6rem"><a href="/csdoitra" style="color: black">Chính Sách Đổi Trả</a></h6>
            </div>

        </div>

        <div
            style="text-align: center;color:rgb(0, 0, 0);background-color:rgb(255, 255, 255);padding-top:30px;padding-bottom:20px">
            <h3>Cảm ơn bạn đã tin tưởng và sử dụng sản phẩm </h3>
            <h6>Mọi thắc mắc xin vui lòng liên hệ để được hỗ trợ tốt nhất bạn nhé</h6>
            <img src="{{ asset('picture/payment-method.png') }}" alt="" style="width: 20%;padding-top:20px">
        </div>
    </footer>
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap-material-design.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Plugin for the momentJs  -->
    <script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('assets/js/plugins/jquery.validate.min.js') }}"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{ asset('assets/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{ asset('assets/js/plugins/bootstrap-selectpicker.js') }}"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{ asset('assets/js/plugins/bootstrap-tagsinput.js') }}"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('assets/js/plugins/jasny-bootstrap.min.js') }}"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{ asset('assets/js/plugins/jquery-jvectormap.js') }}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('assets/js/plugins/nouislider.min.js') }}"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{ asset('assets/js/plugins/arrive.min.js') }}"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chartist JS -->
    <script src="{{ asset('assets/js/plugins/chartist.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/material-dashboard.js?v=2.1.2') }}" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
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
        AOS.init();
    </script>
    <script>
        @section('scripts')
        @endsection <
        script src = "https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js" >
    </script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#search').keyup(function() {
                $value = $(this).val();
                $.ajax({
                    type: 'get',
                    url: '{{ URL::to('/search/product') }}',
                    data: {
                        'search': $value,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(reponse) {
                        $('#show').html(reponse);
                    }
                });
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('header').hidden = true;
            $(window).scroll(function() {
                if ($(this).scrollTop()) {
                    $('#header').addClass('sticky');
                    document.getElementById('header').hidden = false;
                } else {
                    $('#header').removeClass('sticky');
                    document.getElementById('header').hidden = true;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#backtop').fadeOut();
            $(window).scroll(function() {
                if ($(this).scrollTop()) {
                    $('#backtop').fadeIn();
                } else {
                    $('#backtop').fadeOut();
                }
            });
            $('#backtop').click(function() {
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#eye').click(function() {
                $(this).toggleClass('open');
                $(this).children('i').toggleClass('fa-eye-slash fa-eye');
                if ($(this).hasClass('open')) {
                    $(this).prev().attr('type', 'text');
                } else {
                    $(this).prev().attr('type', 'password');
                }
            });
        });
    </script>
    <script>
    const btn_open =  document.getElementById('btnopen');
    const btnclose =  document.getElementById('cl');
    btn_open.addEventListener('click', ()=>{
        modall_container.classList.add('hien');
    });
    btnclose.addEventListener('click', ()=>{
        modall_container.classList.remove('hien');
    });
    $("#btnLogin").click(function (e) { 
        console.log("A");
        $.ajax({
        type: "POST",
        url: "ajLogin",
        data: "data",
        dataType: "dataType",
        success: function (response) {
            
        }
    });
    });
    
    
   

</script>
    
    <style>
        .ti-close:hover {
            cursor: pointer;
        }
    </style>
</body>

</html>

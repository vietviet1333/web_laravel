@extends('Client.Layout')
@section('body')
 <form action="/client/register" method="get">
    <div  data-aos="zoom-in">
        <div style="padding-bottom: 30px"><h3 style=" font-weight: bold;text-align:center">Đăng Kí Tài Khoản</h3></div>
        <div style="text-align: center"><h5 style="color: red">
            @php
                if (Session::get('erros')) {
                    echo Session::get('erros');
                    Session::put('erros', null);
                }
            @endphp
            </h5></div>
        <div style="background-color: rgb(188, 188, 188);height:300px;width:30%;margin:auto;text-align:center">
            <div style="padding: 10px 10px"><input type="text" name="name" placeholder="Tên"></div>
           <div style="padding: 10px 10px">  <input type="text" name="address" placeholder="Địa chỉ"></div>
           <div style="padding: 10px 10px"> <input type="email" name="email" placeholder="Email"></div>
          <div style="padding: 10px 10px">  <input type="text" name="password" placeholder="Mật khẩu"></div>
           <div style="padding: 10px 10px"> <input type="phone" name="phone" placeholder="Số điện thoại"></div>
        </div >
        <div style="text-align: center;padding-top:30px;padding-bottom:30px"><button type="submit" style="color: white;background-color:black"> Đăng Kí</button></div>
     </div>
 </form>

                            
                            
@endsection

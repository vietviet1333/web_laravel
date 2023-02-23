<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use NunoMaduro\Collision\Adapters\Phpunit\Style;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function homepage()
    {
        $products = DB::table('music.product')->simplePaginate(6);
        return view('Client.Home', ['items' => $products]);
    }
    public function authLogin()
    {
        $re = Session::get('id');
        if ($re) {
            return Redirect::to('/profile');
        } else {
            return Redirect::to('/client/login')->send();
        }
    }
    //LOGIN
    public function login()
    {
        return view('Client.Login');
    }
    public function cllogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $check = DB::table('music.user')->where('email', $email)->where('password', $password)->first();
        if ($check) {
            Session::put('id', $check->id);
            return redirect()->action([UserController::class, 'homepage']);
        } else {
            Session::put('fail', 'wrong email or password');
        }
        return back();
    }
    public function register()
    {
        return view('Client.Register');
    }
    public function clregister(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $check = DB::table('music.user')->where('email', $email)->first();
        if ($check) {
            Session::put('erros', 'Email already exists');
            return back();
        } else {
            DB::insert('INSERT INTO music.user(name,email,address,phone,password) VALUES (?,?,?,?,?)', [$name, $email, $address, $phone, $password]);
            Session::put('notifications', ' Register Success');
            return redirect()->action([UserController::class, 'login']);
        }
    }
    public function logout()
    {
        $this->authLogin();
        session::put('id', null);
        return redirect()->action([UserController::class, 'homepage']);
    }

    //profile
    public function profile()
    {
        $this->authLogin();
        $id = session::get('id');
        $profile = DB::select('SELECT*FROM music.user where id=?', [$id]);
        return view('Client.Profile', ['profilee' => $profile]);
    }
    public function editprofile($i)
    {
        $this->authLogin();
        $edit = DB::select('select * from music.user where id=?', [$i]);
        return view('Client.editprofile', ['edits' => $edit]);
    }
    public function save(Request $request)
    {
        $name = $request->input('name');
        $address = $request->input('address');
        $password = $request->input('password');
        $phone = $request->input('phone');
        DB::update('update  music.user set name=?, address=?,password=?, phone=? where id=?', [$name, $address, $password, $phone, Session::get('id')]);
        return redirect()->action([UserController::class, 'profile']);
    }

    //email
    public function sendemail(Request $request)
    {
        $emaill = DB::table('music.user')->where('email', $request->input('email'))->first();
        if ($emaill) {
            mail::send('Client.sendmail', compact('emaill'), function ($email) use ($emaill) {
                $email->from('ntviet133@gmail.com', 'VIETONE');
                $email->to($emaill->email, 'toi');
            });
            return redirect()->action([UserController::class, 'login']);
        } else {
            session::put('f', 'wrong email ');
            return back();
        };
    }
    // newpass
    public function newpass($mail)
    {

        return view('Client.newpass', ['phong' => $mail]);
    }
    public function savepass(Request $request, $phong)
    {
        $new = $request->input('newpass');
        DB::update('update  music.user set password=? where email=?', [$new, $phong]);
        return redirect()->action([UserController::class, 'login']);
    }
    public function hdmuahang()
    {
        return view('Client.csmuahang');
    }
    public function csdoitra()
    {
        return view('Client.csdoitra');
    }
    public function sale()
    {
        return view('Client.sale');
    }
    public function lienhe()
    {
        return view('Client.lienhe');
    }
    public function cart()
    {
        return view('cart');
    }
    public function addcart( Request $request, $id)
    {
     
        $product = DB::table('music.product')->where('id_product', $id)->first();
        if ($product != null) {
            $oldcart = Session('cart') ? Session('cart') : null;
            $newcart = new Cart($oldcart);
            $newcart->AddCart($product, $id);
            $request->session()->put('cart',$newcart);
           
        }
        return view('Client.cart-item');
       
    }
    public function deletepro( Request $request , $id){
        $oldcart = Session('cart') ? Session('cart') : null;
        $newcart = new Cart($oldcart);
        $newcart->Delete($id);
        if(count($newcart->dulieu)>0){
            $request->session()->put('cart',$newcart); 
        }else{
            $request->Session()->forget('cart');
        }
        return view('Client.cart-item');
    }
    public function deletelist( Request $request , $id){
        $oldcart = Session('cart') ? Session('cart') : null;
        $newcart = new Cart($oldcart);
        $newcart->Delete($id);
        if(count($newcart->dulieu)>0){
            $request->session()->put('cart',$newcart); 
        }else{
            $request->Session()->forget('cart');
        }
        return view('Client.list-cart');
    }
    public function ho(){
        return view('Client.Home');
    }
    public function gioithieu(){
        return view('Client.gioithieu');
    }
}

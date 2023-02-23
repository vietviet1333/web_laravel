<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\SESSION;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;


class OrderController extends Controller
{
    public function __construct(){
        $cates=DB::table('music.category')->get();
        View::share('cates',$cates);
    }
    public function authLoginClient()
    {
        $re = Session::get('id_user');
        if ($re) {
            return Redirect::to('/profile');
        } else {
            return Redirect::to('/client/login')->send();
        }
    }
    public function authLogin(){
        $chk = DB::table('music.admin')->where('admin_username',Session::get('admin_username'))->where('password',Session::get('password'))->first();
        if($chk) {
            return Redirect::to('/admin/accept/{id}');
            return Redirect::to('/admin/no-accept/{id}');
        } else {
            return Redirect::to('/admin/login')->send();
        }
    }
    //admin order
    public function index(){
        $order = DB::table('music.ordersss')->join('music.user','user.id','=',
        'ordersss.id_user')->join('music.product','product.id_product','=',
        'orderss.id_product')->orderByDesc('ordersss.id_order')
        ->simplePaginate(10);

        return view('Admin.view_order',['order'=>$order]);
    }
    public function Browser($id){
        $this->authLogin();
        DB::update('UPDATE music.ordersss set payment=? where id_order = ?',[1,$id]);
        return redirect()->back();
    }
    public function NoBrowser($id){
        $this->authLogin();
        DB::update('update music.ordersss set payment=? where id_order=?',[null,$id]);
        return redirect()->back();
    }

    //client order
    public function PurchaseHistorys(){
        if(Session::get('id_user')){
            DB::insert('insert into music.ordersss (id_user,id_product) values (?,?)',[Session::get('id'),Session::get('id_product')]);

            Session::put('notification','Payment success');
        }
        return redirect()->action([OrderController::class, 'PurchaseHistory']);

    }
    public function PurchaseHistory(){
        $order = DB::table('music.ordersss')->join('music.user','user.id_user','=',
        'ordersss.id_user')->join('music.product','product.id_product','=',
        'ordersss.id_product')->where('ordersss.id_user',Session::get('id'))
        ->get();
        return view('Client.purchase_history',['order'=>$order]);

    }
   

    public function orderAccess(Request $request){
        $id=$request->ids;
        foreach($id as $i){
            DB::update('update music.ordersss set payment=? where id_order=?',[1,$i]);
        }
        return redirect()->back();
    }
}

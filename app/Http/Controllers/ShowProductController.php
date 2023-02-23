<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
class ShowProductController extends Controller
{
  public function allproduct(){
    $items=DB::table('music.product')->simplePaginate(6);
    return view('Client.showproduct',['items'=>$items]);
  }
  public function jordan(){
    $items=DB::table('music.product')->where('id_category',8)->simplePaginate(6);
    return view('Client.showproduct',['items'=>$items]);
  }
  public function adidas(){
    $items=DB::table('music.product')->where('id_category',9)->simplePaginate(6);
    return view('Client.showproduct',['items'=>$items]);
  }
  public function nike(){
    $items=DB::table('music.product')->where('id_category',10)->simplePaginate(6);
    return view('Client.showproduct',['items'=>$items]);
  }
  public function newbalance(){
    $items=DB::table('music.product')->where('id_category',11)->simplePaginate(6);
    return view('Client.showproduct',['items'=>$items]);
  }
  // public function balenciaga(){
  //   $items=DB::table('music.product')->where('id_category',7)->simplePaginate(6);
  //   return view('Client.showproduct',['items'=>$items]);
  // }
  // public function mlb(){
  //   $items=DB::table('music.product')->where('id_category',4)->simplePaginate(6);
  //   return view('Client.showproduct',['items'=>$items]);
  // }
  public function xemchitiet($id){
    $items=DB::table('music.product')->where('id_product',$id)->get();
    return view('Client.xemchitiet',['products'=>$items]);
  }
}

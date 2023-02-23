<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Php;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class SearchController extends Controller
{
    public function __construct()
    {
        $cates = DB::table('music.category')->get();
        View::share('cates', $cates);
    }

    public function searchProduct(Request $request)
    {
       
                if ($request->ajax()) {
                    $output = '';
                    $upload = asset('uploads/');
                    $products = DB::table('music.product')->where('name_product', 'LIKE', '%' . $request->search . '%')->get();
                    if ($products) {
                        $i = 1;
                        foreach ($products as $product) {
                            $Ingredient = html_entity_decode($product->ingredient);
                            
                            $output .= '<tr>
                            <td><input type="checkbox" name="ids['.$product->id_product.']" value="'.$product->id_product.'" class="checkbox"></td>
                            <td>' . $i++ . '</td>
                                <td>' . $product->name_product . '</td>
                                <td><img src="' . $upload . '/' . $product->image_product . '" style="width: 100px; height: 100px"></td>
                                <td>' . $Ingredient . '</td>
                              
                             
                                <td><a href="/admin/edit-product/' . $product->id_product . '"class="btn btn-success">Edit</a></td>
                                <td><a href="/admin/delete-product/' . $product->id_product . '"class="btn btn-danger">Delete</a></td>
                                </tr>';
                        }
                    
                    return Response($output);
                }
            }
        }
    
    //search client product
    public function search()
    {
        $all = DB::table('music.product')->paginate(9);
        return view('Client.search_product', ['items' => $all]);
    }

    public function searchclient(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $upload = asset('uploads/');
            $products = DB::table('music.product')->where('name_product', 'LIKE', '%' . $request->search . '%')->paginate(3);
            if ($products) {
                foreach ($products as $product) {
                    $output .= '<div >
                      <a href="/show/'. $product->id_product .'" style="display:flex">  <div><img src="' . $upload . '/' . $product->image_product . '"  style="height:50px;width:50px"alt="..."></div>
                      <div> '. $product->name_product .'</div>
                      <div style="padding-left:10px"> '. $product->price .'$</div></a>
                       <hr></hr>
                       <div>';
                }
            }
            return Response($output);
        }
    }
    //search oder
    public function a(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $a = $request->search;
            $order = DB::table('music.order')->join(
                'music.user',
                'user.id_user',
                '=',
                'order.id_user'
            )->join(
                'music.product',
                'product.id_product',
                '=',
                'oder.id_product'
            )->where('id_order', 'LIKE', '%' . $request->search . '%')->paginate(6);
            if ($order) {
                $i = 1;
                foreach ($order as $orde) {
                    $output .= '<tr>
                    <td><input type="checkbox" name="ids[' . $orde->id_order . ']" value="' . $orde->id_order . '" class="checkbox"></td>
                        <td>
                            ' . $i++ . '
                        </td>
                        <td>
                            ' . $orde->name_user . '
                        </td>
                        <td>
                            ' . $orde->name_product . '
                        </td>
                        <td>
                            ' . $orde->price . '
                        </td>';
                    if ($orde->payment) {
                        $output .= '<td class="text-center">
                            <a href="/admin/no-accept/' . $orde->id_order . '" class="btn btn-danger">No Accept</a>
                        </td>';
                    } else {
                        $output .= '<td class="text-center">
                            <a href="/admin/accept/' . $orde->id_order . '" class="btn btn-success">Accept</a>
                        </td>';
                    }
                    $output .= '</tr>';
                }
            }
            return Response($output);
        }
    }
    public function adminSearchUser(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $users = DB::table('music.user')->where('email', 'LIKE', '%' . $request->search . '%')->get();
            if ($users) {
                $i = 1;
                foreach ($users as $item) {
                    $output .= '<tr>
                    <td>
                        ' . $i++ . '
                    </td>
                    <td>' . $item->name . '
                    </td>
                    <td>' . $item->address . '
                    </td>
                    <td>' . $item->email . '
                    </td>
                    <td>' . $item->phone . '</td>
                </tr>';
                }
            }else{
                $output .='<div>khong tim thay</div>';
            }
            return Response($output);
        }
    }

    public function ajaxLogin(Request $request){
        try {
            if ($request->ajax()) {
                # code...
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
}

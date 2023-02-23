<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;


class ProductController extends Controller
{

    public function __construct(){
        $cates=DB::table('music.category')->get();
        View::share('cates',$cates);
    }
    public function authLogin(){
        $chk = DB::table('music.admin')->where('admin_username',Session::get('admin_username'))->where('password',Session::get('password'))->first();
        if($chk) {
            return Redirect::to('/admin/edit-product/{ID_product}');
            return Redirect::to('/admin/update-product/{ID_product}');
            return Redirect::to('/admin/edit-product/{ID_product}');
            return Redirect::to('/admin/category/{Name}');
        } else {
            return Redirect::to('/admin/login')->send();
        }
    }
    public function category($category){
        $this->authLogin();
        $nameCategory=str_replace('-',' ',$category);
        $idCategory=DB::table('music.category')->where('name_category',$nameCategory)->first();
        Session::put('idCategory',$idCategory->id_category);
        $all = DB::table('music.category')->where('id_category',$idCategory->id_category)->simplePaginate(6);
        return view('Admin.view_product', ['products' => $all]);
    }
    public function productDelete(Request $request){
        $this->authLogin();
        DB::table('music.product')->whereIn('id_product',$request->ids)->delete();
        return redirect()->back();
    }
    public function post()
    {
        $products=DB::table('music.product')->simplePaginate(10);
        return view('admin.post_management',['products'=>$products]);
    }

// ===========
    public function index()
    {
        //
        $products=DB::table('music.product')->simplePaginate(10);
        return view('Admin.view_product',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category=DB::select('SELECT * FROM music.category');
        return view('Admin.create_product',['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // function convertData($body_content) {
        //     $body_content = trim($body_content);
        //     $body_content = stripslashes($body_content);
        //     $body_content = htmlspecialchars($body_content);
        //     return $body_content;
        // }
        
            DB::beginTransaction();
            $name = $request->input('inputName');

            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $image);

            $ingredient = $request->input('inputIngredient');
           
            $IDcategory = $request->input('inputIDCategory');
            $price= $request->input('inputPrice');
            DB::insert('INSERT INTO music.product (name_product,image_product,ingredient,id_category ,price) VALUES (?,?,?,?,?)', [$name,$image,$ingredient,$IDcategory,$price]);
        DB::commit();
        Session()->flash('success', 'Insert product success.');
        return redirect()->action( [ProductController::class, 'create']);
        
           
               
            }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $this->authLogin();
        $products=DB::select('SELECT * FROM music.product WHERE id_product = ?',[$id]);
        return view('Admin.update_product',['products'=>$products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authLogin();
        DB::beginTransaction();
        $id = $request->input('inputID');
        $name = $request->input('inputName');

        if($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $image);
        } else {
            $products=DB::select('SELECT image_product FROM music.product WHERE id_product = ?',[$id]);
            if ($products){
                foreach ($products as $product) {
                    $image = "$product->image_product";
                    }
            }

        }
            $ingredient = $request->input('inputIngredient');
           
            $IDcategory = $request->input('inputIDCategory');
           
            DB::update('UPDATE music.product SET  name_product = ?,image_product = ?,ingredient = ?,
            id_category = ? WHERE id_product = ?',[$name,$image,$ingredient,$IDcategory,$id]);
        DB::commit();
        return redirect()->action([ProductController::class,'index']);
    }


    public function destroy($id)
    {
        //
        $this->authLogin();
        DB::delete('DELETE FROM music.product WHERE id_product = ?',[$id]);
        return back()->withInput();
    }
}


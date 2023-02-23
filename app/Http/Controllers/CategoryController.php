<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class CategoryController extends Controller
{
    public function __construct(){
        $cates=DB::table('music.category')->get();
        View::share('cates',$cates);
    }
    public function authLogin(){
        $chk = DB::table('music.admin')->where('admin_username',Session::get('admin_username'))->where('password',Session::get('password'))->first();
        if($chk) {
            return Redirect::to('/admin/edit-category/{ID_category}');
            return Redirect::to('/admin/update-category/{ID_category}');
            return Redirect::to('/admin/delete-category/{ID_category}');
        } else {
            return Redirect::to('/admin/login')->send();
        }
    }
    public function index()
    {
        //
        $category=DB::select('SELECT * FROM music.category');
        return view('Admin.view_category',['category'=>$category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.create_category');
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
        DB::beginTransaction();
                $name = $request->input('inputCategory');
                DB::insert('INSERT INTO music.category (name_category) VALUES (?)', [$name]);
            DB::commit();
            Session()->flash('success', 'Insert category success.');
            return redirect()->action([CategoryController::class,'create']);
            // return redirect()->action([CategoryController::class,'index']);
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
        $category=DB::select('SELECT * FROM music.category WHERE id_category = ?',[$id]);
        return view('Admin.update_category',['category'=>$category]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->authLogin();
        $id=$request->input('inputID');
        $name=$request->input('inputCategory');
        DB::update('UPDATE music.category set id_category=?, name_category = ? where id_category = ?',[$id,$name,$id]);
        return redirect()->action([CategoryController::class,'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->authLogin();
        DB::delete('DELETE FROM music.product WHERE id_category = ?',[$id]);
        DB::delete('DELETE FROM music.category WHERE id_category = ?',[$id]);
        return redirect()->action([CategoryController::class,'index']);
    }
}

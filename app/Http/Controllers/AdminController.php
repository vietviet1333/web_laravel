<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use NunoMaduro\Collision\Adapters\Phpunit\Style;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $cates = DB::table('music.category')->get();
        View::share('cates', $cates);
    }
    public function login()
    {
        return view('Admin.login_admin');
    }

    public function check_login(Request $request)
    {
        $admin = DB::table('music.admin')->where('admin_username', $request->username)->where('password', $request->password)->first();
        if ($admin) {
            Session::put('admin_username', $admin->admin_username);
            Session::put('password', $admin->password);
            Session::put('id_admin',$admin->admin_id);
            return redirect()->action([AdminController::class, 'dashboard']);
        } else {
            Session::put('messenger', 'Incorrect username or password.');
            return redirect()->action([AdminController::class, 'login']);
        }
    }

    public function logout(Request $request)
    {
        Session::put('admin_username', null);
        Session::put('password', null);;
        return redirect()->action([AdminController::class, 'login']);
    }
public function dashboard(){
  if(Session::get('id_admin')){
    return view('Admin.dashboard');
  }else{
    return view ('Admin.login_admin');
  }
}
public function usermanagement()
{
    $users = DB::select('SELECT * FROM music.user');
    return view('Admin.user_management', ['users' => $users]);
}
public function editProfile()
{
    $admin = DB::select('SELECT * FROM music.admin');
    return view('admin.edit_profile', ['admin' => $admin]);
}
public function updateProfile(Request $request)
{
    $name = $request->input('inputUsername');
    $email = $request->input('inputEmail');
    $pass = $request->input('inputPass');
    DB::update('UPDATE music.admin set admin_username = ?,password = ?,email = ? where admin_id = 1', [$name, $pass,$email]);
    return redirect()->action([AdminController::class, 'profile']);
}
//


public function forgotPassword()
{
    $emaill = DB::table('music.admin')->first();
    if ($emaill) {
        mail::send('admin.admin_sendMail', compact('emaill'), function ($email) use ($emaill) {
            $email->from('vietviet1333@gmail.com', 'VIETONE');
            $email->to($emaill->email, 'toi');
        });
        Session()->flash('forgot', 'Please check your email.');
        return back();
    } else {
        session::put('f', 'Wrong email ');
        return back();
    };
}

public function newPassword($email)
{
    return view('admin.newpassword', ['email' => $email]);
}
public function savePassword(Request $request, $phong)
{
    $new = $request->input('newpass');
    DB::update('update music.admin set password =? where email = ?', [$new, $phong]);
    return view('Admin.login_admin');
}
}

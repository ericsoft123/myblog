<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET,POST,DELETE');

Route::get('/', function () {
    return view('/components/auth/users/login');
    
});

//post Controller
Route::get('/load_post','postController@load_post')->name('load_post');
Route::get('/search_post','postController@search_post')->name('search_post');
Route::post('/create_post','postController@create_post')->name('create_post');
Route::post('/edit_post','postController@edit_post')->name('edit_post');
Route::get('/delete_post','postController@delete_post')->name('delete_post');
//post Controller


//Admin Controller
Route::get('/admin_load_count','AdminController@admin_load_count')->name('admin_load_count');
Route::get('/admin_search_user','AdminController@admin_search_user')->name('admin_search_user');
Route::get('/admin_view_users','AdminController@admin_view_users')->name('admin_view_users');
Route::get('/admin_count_user','AdminController@admin_count_user')->name('admin_count_user');
//admin Controller






Route::get('/users_loginpage','RegisterController@users_loginpage')->name('users_loginpage');
Route::get('/admins_loginpage','RegisterController@admins_loginpage')->name('admins_loginpage');

Route::get('/users_resendemailpage','RegisterController@users_resendemailpage')->name('users_resendemailpage');
Route::get('/admins_resendemailpage','RegisterController@admins_resendemailpage')->name('admins_resendemailpage');
Route::post('/Admin_forgetpassword','RegisterController@Admin_forgetpassword')->name('Admin_forgetpassword');
Route::post('/resend_email','RegisterController@resend_email')->name('resend_email');
Route::get('/users_newpasswordpage','RegisterController@users_newpasswordpage')->name('users_newpasswordpage');
Route::get('/admins_newpasswordpage','RegisterController@admins_newpasswordpage')->name('admins_newpasswordpage');
Route::post('/new_password','RegisterController@new_password')->name('new_password');





Route::get('/profile','ProfileController@profile')->name('profile');

Route::get('/users_resend_confirmationpage','RegisterController@users_resend_confirmationpage')->name('users_resend_confirmationpage');
Route::get('/admins_resend_confirmationpage','RegisterController@admins_resend_confirmationpage')->name('admins_resend_confirmationpage');
Route::post('/reset_with_phone','RegisterController@reset_with_phone')->name('reset_with_phone');
Route::post('/User_forgetpassword','RegisterController@User_forgetpassword')->name('User_forgetpassword');
Route::get('/unverified','RegisterController@unverified')->name('unverified');
Route::get('/logout','RegisterController@logout')->name('logout');
//Route::get('/logout','RegisterController@logout')->name('logout');
Route::get('/logintest','RegisterController@logintest')->name('logintest');

/* users Action */
/*user Authentiation */
Route::get('/confirm_email','RegisterController@confirm_email')->name('confirm_email');
Route::post('/User_newpassword','RegisterController@User_newpassword')->name('User_newpassword');
Route::get('/sendemail','RegisterController@sendemail')->name('sendemail');
Route::post('/login','RegisterController@login')->name('login');

Route::get('/otppage','RegisterController@otppage')->name('otppage');
Route::post('/otp_confirmation','RegisterController@otp_confirmation')->name('otp_confirmation');
Route::get('/adminforgetpage','RegisterController@adminforgetpage')->name('adminforgetpage');
Route::get('/forgetpage','RegisterController@forgetpage')->name('forgetpage');
Route::get('/loginpage','RegisterController@loginpage')->name('loginpage');
Route::post('/register','RegisterController@register')->name('register');
Route::get('/registerpage','RegisterController@registerpage')->name('registerpage');
/*user Authentiation */


/*admin Authentication*/
Route::post('/signin','RegisterController@signin')->name('signin');
Route::get('/signinpage','RegisterController@signinpage')->name('signinpage');
Route::post('/signup','RegisterController@signup')->name('signup');
Route::get('/signuppage','RegisterController@signuppage')->name('signuppage');

/*admin Authentication*/











<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class AdminController extends Controller
{
    //
    public function admin_load_count(Request $request){
        if(Auth::guard('Admin')->check()){
            $check = DB::select("SELECT (SELECT COUNT('id') FROM users) as a, (SELECT COUNT('id') FROM blogposts ) as b");
            if($check)
            {
               return response([
                   "status"=>true,
                   "result"=>[
                       "user_count"=>$check[0]->a,
                       "blog_count"=>$check[0]->b,
                       
                   ],
               
                   
                  
               
               ],200);
            }
            else{
               return response([
                   "status"=>false,
                 
               
               ],201);
            }

        }
    }
    public function admin_count_user(Request $request){
        $userid=$request->input('userid');   
        if(Auth::guard('Admin')->check()){
            $check = DB::select("SELECT (SELECT COUNT('id') FROM blogposts where userid='$userid') as a");
            if($check)
            {
               return response([
                   "status"=>true,
                   "result"=>[
                       
                       "blog_count"=>$check[0]->a,
                       
                   ],
               
                   
                  
               
               ],200);
            }
            else{
               return response([
                   "status"=>false,
                 
               
               ],201);
            }

        }
    

    }
    public function admin_search_user(Request $request)//admin search clients
    {
        $search_input=$request->input('search_input');
        if(Auth::guard('Admin')->check()){
            $check = DB::select("select *from users where name LIKE '%$search_input%'  limit 10");
            if($check)
            {
               return response([
                   "status"=>true,
                   "result"=>$check
               
                   
                  
               
               ],200);
            }
            else{
               return response([
                   "status"=>false,
                 
               
               ],201);
            }
        }
        else{
            return response([
                "status"=>false,
                "error"=>"0",
                    ],201);
        }
    }
    public function admin_view_users(Request $request)//view all clients
    {
        if(Auth::guard('Admin')->check()){
            $check = DB::select("select *from users order by id desc limit 10");
            if($check)
            {
               return response([
                   "status"=>true,
                   "result"=>$check
               
                   
                  
               
               ],200);
            }
            else{
               return response([
                   "status"=>false,
                 
               
               ],201);
            }
        }
        else{
            return response([
                "status"=>false,
                "error"=>"0",
                    ],201);
        }
    }
}

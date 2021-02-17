<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth;
use DB;


class postController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set(env('TIME_ZONE'));
        $this->today = date('Y-m-d H:i:s', time());
        $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
        

    }
    public function load_post(Request $request)
    {
       
        if(Auth::check()){
            return $this->user_load_post();
        }
        else if(Auth::guard('Admin')->check()){//super Admin
            return $this->admin_load_post();
        }
        else{
            return response([
                "status"=>false,
                "message"=>"invalid authentication data"
               ],404);
        }
        
    }
    public function user_load_post()
    {
        $userid=Auth::user()->userid;
        $check=DB::select("select *from blogposts where userid=:userid order by id desc",array(
            "userid"=>$userid
        ));
        if($check)
        {
            return response([
                "status"=>true,
                "result"=>$check //this is data
               ],200);
        }
        else{
            return response([
                "status"=>false,
                "result"=>'no data found' //this is data
               ],201);
        }
    }
    public function admin_load_post()
    {
        
        $check=DB::select("select *from blogposts order by id desc");
        if($check)
        {
            return response([
                "status"=>true,
                "result"=>$check //this is data
               ],200);
        }
        else{
            return response([
                "status"=>false,
                "result"=>'no data found' //this is data
               ],201);
        }
    }
    public function create_post(Request $request){
        $input=$request->all();
        if(Auth::check()){
            return $this->user_create_post($input);
        }
        else if(Auth::guard('Admin')->check()){//here you can also scale your app easily by adding how admin will be able to create a post
            //return $this->admin_create_post($input);
        }
        else{
            return response([
                "status"=>false,
                "message"=>"invalid authentication data"
               ],404);
          }
        
    }
    public function user_create_post($input){
        
      $uid=Str::random(3)."_".date(time());
      $uid=strtolower($uid);
      $check=DB::table('blogposts')
      ->insert([
       'uid'=>$uid,
       'userid'=>Auth::user()->userid,
       'title'=>$input['title'],
       'content'=>$input['content'],
       'created_at'=>$this->today,
      ]);
      if($check)
      {
        return response([
            "status"=>true,
            "result"=>'post created successfuly'
           ],200);
      }
      else{
        return response([
            "status"=>false,
            "result"=>'error please contact system admin'
           ],201);
      }
    }

   
  

    public function edit_post(Request $request){
        $input=$request->all();
        if(Auth::check()){
            return $this->user_edit_post($input);
        }
        else if(Auth::guard('Admin')->check()){///here you can also scale your app easily by adding how admin will be able to edit a post
            //return $this->admin_edit_post($input);
        }
        else{
            return response([
                "status"=>false,
                "message"=>"invalid authentication data"
               ],404);
          }
        
    }
    public function user_edit_post($input)
    {
        $userid=Auth::user()->userid;
        $title=$input['title'];
        $content=$input['content'];
        $check=DB::update("update blogposts set title='$title',content='$content'  where uid=:uid and userid=:userid limit 1",array(//this will speed up our query
            "userid"=>$userid,
            "uid"=>$input['uid'],
           
        ));
        if($check)
        {
          return response([
              "status"=>true,
              "result"=>'data successfuly updated'
             ],200);
        }
        else{
          return response([
              "status"=>false,
              "result"=>'Error please contact your system admin'
             ],201);
        }
    }

   
    public function search_post(Request $request){
        $input=$request->all();
        if(Auth::check()){
            return $this->user_search_post($input);
        }
        else if(Auth::guard('Admin')->check()){//super Admin
            return $this->admin_search_post($input);
        }
        else{
            return response([
                "status"=>false,
                "message"=>"invalid authentication data"
               ],404);
          }
        
    }
    public function user_search_post($input)
    {
        $userid=Auth::user()->userid;
        $search_input=$input['search_input'];
        $check=DB::select("select *from blogposts where userid=:userid and title Like '%$search_input%' order by id limit 10",array(
            "userid"=>$userid,
            
        ));
        if($check)
        {
            return response([
                "status"=>true,
                "result"=>$check
               ],200);
        }
       
    }
    public function admin_search_post($input)
    {
      
        $search_input=$input['search_input'];
        $check=DB::select("select *from blogposts where title Like '%$search_input%' order by id limit 10");
        if($check)
        {
            return response([
                "status"=>true,
                "result"=>$check
               ],200);
        }
       
    }
    public function delete_post(Request $request){
        $input=$request->all();
        if(Auth::check()){
            return $this->user_delete_post($input);
        }
        else if(Auth::guard('Admin')->check()){//super Admin
           
        }
        else{
            return response([
                "status"=>false,
                "message"=>"invalid authentication data"
               ],404);
          }
        
    }
    public function user_delete_post($input)
    {
        $check=DB::delete("delete from blogposts where uid=:uid and userid=:userid limit 1",array(
         'uid'=>$input['uid'],
         'userid'=>Auth::user()->userid
        ));
        if($check)
        {
            return response([
                "status"=>true,
               ],200);
        }
    }
}

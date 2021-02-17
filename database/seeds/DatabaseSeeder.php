<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder

{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        return $this->insert_user();
      
    }
    public function insert_user(){
        $password="1";
        $userid="test@gmail.com";
        
        $check=DB::table('users')->insert([
            'name' =>Str::random(10),
            'userid'=>$userid,
            'email' =>"test@gmail.com",
            'platform'=>env('Client'),//this will help us to have multiple users with differents roles
            'password' =>bcrypt($password),
        ]);
        if($check)//create post
        {
            return $this->create_post($userid);
        }
    }
    public function create_post($userid){
        $uid=Str::random(10)."_".$userid;
        $check=DB::table('blogposts')->insert([
            'uid' =>$uid,
            'userid'=>$userid,
            'title'=>"first title",
            'content' =>"content",
            'created_at'=>Carbon::now()
           
        ]);
        if($check)
        {
            return $this->create_super_admin();
        }
    }
    public function create_super_admin(){
        $password="1";
        $check=DB::table('admins')->insert([
            'name' =>"super",
            'userid'=>"super@gmail.com",
            'email' =>'super@gmail.com',
            'platform'=>env('Super'),//this will make us having multiple admins with differents roles
            'password'=>bcrypt($password),
        ]);
    }
}

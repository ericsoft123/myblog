<template>

<div class="container pt-4">
     
 <h3 class="text-center">{{Action_title}}</h3>
 <div class="cover-spin"  v-if="spin_show"></div>
   <div class="row">
<div class="col-md-4 pt-3">
<ul class="list-group" >

<li class="list-group-item d-flex justify-content-between align-items-center activex" @click="load_post()">
    Total Posted 
    
<span class="badge badge-primary badge-pill">{{countdata.posted}} </span>
  </li>
 
 
  <li class="list-group-item d-flex justify-content-between align-items-center" @click="admin_view_users()">
    View Clients
    <span class="badge badge-primary badge-pill">{{countdata.users}}</span>
  </li>

   
</ul>

<div class="pt-2" v-if="show_visible.user_posted">
    <h3 class="text-center">{{client_data.name}}</h3>
    <ul class="list-group" >
<li class="list-group-item d-flex justify-content-between align-items-center activex">
 Posted 
    
<span class="badge badge-primary badge-pill">{{client_data.countpost}}</span>
  </li>


</ul>
</div>

</div>
  
         <div class="col-md">
     <div class="col-md">
           <div class="form-group">
              <button class="btn btn-danger" @click="back_btn()" v-if="show_visible.back">Back</button>
    
</div>
     </div>
           <!--search Input-->
<div class="col-md" v-if="show_visible.search_show">
    <input type="text" class="form-control" v-model="search_input_data" @input="SearchAction()" :placeholder="placeholder_search" >


</div>
           <!--search Input-->
<!--table-->
<div class="col-md pt-2">
 <table class="table table-inbox table-hover" v-if="show_visible.table_show">

    <thead>
    <tr>
      
      <th scope="col">Post ID</th>
      <th scope="col">title</th>
      <th scope="col">Content</th>
      <th scope="col">Created At</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
          <tbody v-bind:key="post_item.id" v-for="post_item in post_data">
            <tr class="unread" >
            
              <td class="view-message  dont-show">{{post_item.uid}}</td>
              <td class="view-message ">{{post_item.title}}</td>
              <td class="view-message  cut_text">{{post_item.content}}</td>
              <td class="view-message  ">{{post_item.created_at}}</td>
              <td class="view-message  ">
                      <a href="#" @click="View_postdata(`${post_item.uid}`,`${post_item.title}`,`${post_item.content}`)"><i class="fa fa-edit"></i></a>
              </td>
        
              
              
            </tr>
            
        
          </tbody>
        </table>
    </div>
<!--table-->

<!--table clients-->
<div class="col-md pt-2"  v-if="show_visible.table_client">

 <table class="table table-inbox table-hover">
     <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      
      <th scope="col">Created At</th>
    </tr>
  </thead>
          <tbody v-bind:key="user.id" v-for="user in user_data">
            <tr class="unread" @click="View_user(`${user.name}`,`${user.userid}`)">
              
              <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
              <td class="view-message  dont-show">{{user.name}}</td>
              <td class="view-message ">{{user.email}}</td>
          
            
              <td class="view-message ">{{user.created_at}} AM</td>
            </tr>
            
        
          </tbody>
        </table>
    </div>
<!--table clients-->
<div class="col-md">
  <form  v-if="show_visible.form_show" @submit.prevent="submit">

<div class="form-group d-none">
<label for="">ID</label>
<input type="text" class="form-control" v-model="fields.uid" >
</div>
<div class="form-group">
<label for="">Title</label>
<input type="text" class="form-control" v-model="fields.title" required>
</div>

<div class="form-group">
<label for="">Content</label>
<textarea class="form-control" id="" cols="30" rows="10"  v-model="fields.content" required></textarea>
</div>



</form>

</div>






       </div>


    

   </div>
</div>
</template>

<script>



export default {
    data:function(){
        return{
             post_data:[],
             search_input_data: '',
             SearchActionName:'post',
             Action_title:'',
             show_visible:[],
              fields:{},
              countdata:{},
             spin_show:true,
             user_data:[],
             client_data:[],
             placeholder_search:'seach by  title',
            
             
            
        }
    },
    mounted(){
      this.load_post();
      this.admin_load_count();

    },
    methods:{
      back_btn(){
          this.spin_show=true;
this.load_post();
      },
         admin_load_count(){

     try {
               
   axios.get('/admin_load_count').then((response) => {

  
      if(response.data.status)
      {
         this.show_visible.push(this.show_visible.countshow=true);
    this.countdata.posted=response.data.result.blog_count;
    this.countdata.users=response.data.result.user_count;


      }
      else{
      
         this.spin_show=false;
      }
    

   
        });



       
    } catch (error) {
        console.log(error);
    }

      },
        admin_view_users(){
              try {
                   this.spin_show=true;
               
   axios.get('/admin_view_users').then((response) => {

          
    
      if(response.data.status)
      {
     this.SearchActionName="search_user";
this.user_data=response.data.result;
this.show_visible=[];//empty an array before adding new
 this.show_visible.push(this.show_visible.table_client=true);
 this.show_visible.push(this.show_visible.search_show=true);
 this.spin_show=false;
 this.placeholder_search='seach by  user';
console.log(this.show_visible);
      }
    

      
        });



       
    } catch (error) {
        console.log(error);
    }

      },
      View_user(name,userid){
           this.spin_show=true;
         try {
               
   axios.get('/admin_count_user', {
    params: {
     
      userid:userid
    }
  }).then((response) => {

          
      //this.email_data=response.data.result;
      if(response.data.status)
      {
       console.log(response.data.result);
 this.client_data.name=name;
 this.client_data.countpost=response.data.result.blog_count;
 this.show_visible=[];//empty an array before adding new
  this.show_visible.push(this.show_visible.user_posted=true);
   this.show_visible.push(this.show_visible.table_client=true);
 this.show_visible.push(this.show_visible.search_show=true);
  
   this.spin_show=false;

      }
    

      //console.log(response.data.result.length);
        });



       
    } catch (error) {
        console.log(error);
    }
      },

         load_post(){

     try {
               
   axios.get('/load_post').then((response) => {

           this.placeholder_search='seach by  title';
      //this.post_data=response.data.result;
      if(response.data.status)
      {
      this.post_data=[];
      this.post_data=response.data.result;
      this.spin_show=false;
      console.log(this.post_data);
   this.show_visible=[];
          this.show_visible.push(this.show_visible.table_show=true);      
          this.show_visible.push(this.show_visible.search_show=true);    
          this.show_visible.push(this.show_visible.createpost=true);    
            this.Action_title="";
            this.SearchActionName='post';


      }
      else{
        this.post_data=[];
         this.spin_show=false;
      }
    

      //console.log(response.data.result.length);
        });



       
    } catch (error) {
        console.log(error);
    }

      },

  
 
     View_postdata(uid,title,content){
       
         this.Action_title="View Post";

this.show_visible=[];
          this.show_visible.push(this.show_visible.form_show=true);
          this.show_visible.push(this.show_visible.back=true);
//this.show_visible.push(this.show_visible.postdata_view_show=true);

this.fields.uid=uid;
this.fields.title=title;
this.fields.content=content;





      },
 
         
          SearchAction(){
            if(this.SearchActionName=='post')
            {
             this.search_post();
            }
            else{
            this.search_user();
            }
            
         },
        search_post(){

          this.spin_show=true;
              try {
               
   axios.get('/search_post',{
     params:{
       search_input:this.search_input_data,
     }
   }).then((response) => {

          this.post_data=[];
      this.post_data=response.data.result;
      this.spin_show=false;
      console.log(this.post_data);
   this.show_visible=[];
          this.show_visible.push(this.show_visible.table_show=true);      
          this.show_visible.push(this.show_visible.search_show=true);
      //console.log(response.data.result.length);
        });



       
    } catch (error) {
        console.log(error);
    }
      

        },
        search_user(){
this.spin_show=true;
              try {
               
   axios.get('/admin_search_user',{
     params:{
      
       search_input:this.search_input_data,
     }
   }).then((response) => {

 this.user_data=response.data.result;
this.show_visible=[];//empty an array before adding new
 this.show_visible.push(this.show_visible.table_client=true);
 this.spin_show=false;
//console.log(this.show_visible);         
 this.show_visible.push(this.show_visible.search_show=true);


        });



       
    } catch (error) {
        console.log(error);
    }
        }


    }
}
</script>
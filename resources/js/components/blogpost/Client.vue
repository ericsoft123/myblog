<template>

<div class="container pt-4">
     
 <h3 class="text-center">{{Action_title}}</h3>
 <div class="cover-spin"  v-if="spin_show"></div>
   <div class="row">

    <div class="container">
         <div class="col-md">
     <div class="col-md">
           <div class="form-group">
              <button class="btn btn-danger" @click="back_btn()" v-if="show_visible.back">Back</button>
    <button class="btn btn-danger" @click="Add_new_post()"  v-if="show_visible.createpost">Create Post</button>
</div>
     </div>
           <!--search Input-->
<div class="col-md" v-if="show_visible.search_show">
    <input type="text" class="form-control" v-model="search_input_data" @input="SearchAction()" placeholder="seach by  title">


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
                      <a href="#" @click="View_postdata(`${post_item.uid}`,`${post_item.title}`,`${post_item.content}`)"><i class="fa fa-edit"></i></a>  |   <a href="#" @click="delete_postdata(`${post_item.uid}`,`${post_item.title}`)"><i class="fa fa-trash text-danger"></i></a>
              </td>
        
              
              
            </tr>
            
        
          </tbody>
        </table>
    </div>
<!--table-->


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

<div class="form-group">
<button class="btn btn-primary">Submit</button>
</div>

</form>

</div>






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
             ActionName:'create_post',
             Action_title:'',
             show_visible:[],
              fields:{},
             spin_show:true,
             
            
        }
    },
    mounted(){
      this.load_post();

    },
    methods:{
      back_btn(){
          this.spin_show=true;
this.load_post();
      },
         load_post(){

     try {
               
   axios.get('/load_post').then((response) => {

          
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


      }
      else{
        this.post_data=[];
             
          this.show_visible.push(this.show_visible.createpost=true);  
         this.spin_show=false;
      }
    

      //console.log(response.data.result.length);
        });



       
    } catch (error) {
        console.log(error);
    }

      },

   
      submit(){
        if(this.ActionName=='create_post')
        {
          this.create_post();
        }
        else{
          this.edit_post();
        }
       
    },
    create_post(){
        this.spin_show=true; 
axios.post('/create_post',this.fields)
  .then((response) => {
   this.fields={};//to reset forms
   
     this.load_post();
  
  }).catch(error=>{
console.log('error');
  });
      
      
    },
     edit_post(){
        this.spin_show=true;
axios.post('/edit_post',this.fields)
  .then((response) => {
   this.fields={};//to reset forms
   
     this.load_post();
    //this.spin_show=false;
  }).catch(error=>{
console.log('error');
  });
      
      
    },
     View_postdata(uid,title,content){
       this.ActionName="edit_post";
         this.Action_title="Edit this Post";

this.show_visible=[];
          this.show_visible.push(this.show_visible.form_show=true);
          this.show_visible.push(this.show_visible.back=true);
//this.show_visible.push(this.show_visible.postdata_view_show=true);

this.fields.uid=uid;
this.fields.title=title;
this.fields.content=content;





      },
                delete_postdata(uid,title){
            //console.log(this.search_input_data);
         if(confirm(`Are you sure you want to delete ${title}?`))
         {
this.spin_show=true;
              try {
               
   axios.get('/delete_post',{
     params:{
       uid:uid,
     }
   }).then((response) => {

     this.load_post();     
     
      //console.log(response.data.result.length);
        });



       
    } catch (error) {
        console.log(error);
        this.spin_show=false;
    }
         }   

        },
  
        Add_new_post(){
          this.ActionName='create_post';
          this.Action_title="Create New Post";
          this.fields={};
          this.show_visible=[];
          this.show_visible.push(this.show_visible.form_show=true);
          this.show_visible.push(this.show_visible.back=true);
     
       
        },
         
          SearchAction(){
            //console.log(this.search_input_data);
            
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

    }
}
</script>
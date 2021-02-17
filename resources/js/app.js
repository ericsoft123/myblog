require('./bootstrap');

window.Vue=require('vue');
Vue.component('client-page',require('./components/blogpost/Client.vue').default);
Vue.component('admin-page',require('./components/blogpost/Admin.vue').default);


const app=new Vue({
    el:'#app',
});

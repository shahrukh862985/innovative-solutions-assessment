require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import store from './store';
import VueRouter from 'vue-router';
import {
    routes
} from './routes';

Vue.use(VueRouter);
Vue.use(VueToast);

Vue.component('app', require('./components/App.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    // document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
    if(to.meta.middleware === "guest"){
        next()
    }
    else{
        let token = JSON.parse(localStorage.getItem('vuex'));
        if(typeof token === 'object' && token.hasOwnProperty('auth') && token.auth.authenticated){
            next()
        }
        else
            next({name:"login"})
    }
})


Vue.mixin({
    methods: {
      parseValidationErrors: function(error) {
        let errorText = '<ul style="list-style:none" class="pl-0"></ul>';
        if(typeof error === 'string' || error instanceof String){
            errorText += '<li>'+error+'</li>';
            errorText += '</ul>'
            return errorText;
        }
        for (const item of error) {
            errorText += '<li>'+item+'</li>';
        }
        errorText += '</ul>'
        return errorText
      }
    }
  });

const app = new Vue({
    el: '#app',
    router: router,
    store:store
});

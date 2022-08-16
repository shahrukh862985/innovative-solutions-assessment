import Vue from 'vue'
import Vuex from 'vuex'
import {createVuexPersistedState}  from 'vue-persistedstate'
import auth from './auth'

Vue.use(Vuex)


export default new Vuex.Store({
    plugins:[
        createVuexPersistedState ({
            key:'vuex',
            storage:window.localStorage,
            whiteList:[],
            blackList: [],
          })
    ],
    modules:{
        auth
    }
})
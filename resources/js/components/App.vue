<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-dark  navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Innovative Solutions Assessment</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <router-link to="/" class="nav-link">Films</router-link>
                    </div>
                    <div class="navbar-nav" v-if="!authenticate">
                        <router-link to="/login" class="nav-link">Login</router-link>
                        <router-link to="/register" class="nav-link">Register</router-link>
                    </div>
                    <div class="navbar-nav" v-else>
                        <a href="javascript:void(0)" class="nav-link" v-on:click="logoutRequest">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container mt-3">
            <router-view> </router-view>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { mapActions } from 'vuex'

const url = process.env.MIX_BASE_URL
export default {
    data() {
        return {
            authenticate: false
        }
    },
    created(){
        this.changeAuthentication()
    },
    methods:{
        ...mapActions({
            signOut:"auth/logout"
        }),
        changeAuthentication(){
            console.log('change authentication');
            this.authenticate = this.$store.state.auth.authenticated
            this.$router.push({name:'films'})
        },
        logoutRequest(){
            let _this = this
            axios.post(`${url}/api/logout`,{})
                .then(response => {
                    _this.signOut()
                    Vue.$toast.open({
                        message: response.data.message,
                        type: 'success',
                        position: 'top-right'
                    });
                    setTimeout(function(){
                        _this.$router.push({name:"login"})
                    },700)
                    
                })
                .catch(err => {
                    Vue.$toast.open({
                        message: this.parseValidationErrors(err.response.data.error),
                        type: 'error',
                        position: 'top-right'
                    });
                })
        }
    }
}
</script>
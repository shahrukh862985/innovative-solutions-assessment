<template>
    <div>
        <h3 class="text-center">ACCOUNT LOGIN</h3>
        <div class="row justify-content-center">
            <div class="col-md-4 mt-4">
                <div class="p-4 bg-dark text-light rounded">
                    <form method="post" @submit.prevent="loginFormSubmit">
                        <input type="hidden" v-model="form._token">
                        <div class="form-group mb-2">
                            <label for="">Email</label>
                            <input type="email" v-model="form.email"  class="form-control"
                                placeholder="Enter Email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Password</label>
                            <input type="password" v-model="form.password" class="form-control"
                                placeholder="Enter Password">
                        </div>
                        <input type="submit" value="Login" class="btn btn-primary">
                        <p class="mt-3">Don't have an account? <router-link :to="{ 'name': 'register' }"
                                :class="'text-info'">SignUp</router-link>
                        </p>
                    </form>
                </div>

            </div>
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
            form: {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    },
    created() {

    },
    methods: {
        ...mapActions({
            signIn:'auth/login'
        }),
        loginFormSubmit() {
            const _this = this
            axios.post(`${url}/api/login`,_this.form)
                .then(response => {
                    if(!response.data.status){
                        Vue.$toast.open({
                            message: response.data.error.message,
                            type: 'error',
                            position: 'top-right'
                        });
                        return;
                    }
                     _this.signIn()
                    Vue.$toast.open({
                        message: response.data.message,
                        type: 'success',
                        position: 'top-right'
                    });
                    setTimeout(function(){
                        _this.$parent.changeAuthentication()
                        _this.$router.push({name:'films'})
                    },500)
                    
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
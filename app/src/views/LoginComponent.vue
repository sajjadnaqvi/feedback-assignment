<template>
      <section class="container mt-5">
        <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
            <div class="card-header">
                <h3 class="text-center">Login</h3>
            </div>
            <div class="card-body">
                <form id="loginForm">
                <!-- Username Input -->
                <div class="mb-3">
                    <input type="text" v-model="payload.email" class="form-control" id="login__email" placeholder="Email" />
                    <span class="text-danger" v-if="$v.payload.email.$error">Email Required</span>

                </div>
                <!-- Password Input -->
                <div class="mb-3">
                    <input type="password" v-model="payload.password" class="form-control" id="login__password" placeholder="Password" />
                   <span class="text-danger" v-if="$v.payload.password.$error">Password Required</span>
                </div>
                <!-- Login Button -->
                <button v-on:click="LoginUser()" class="btn btn-success btn-block" id="login__submit">Login</button>
                </form>
                <!-- Registration Message -->
                <p class="mt-3 text-center">
                Not a member yet? <a v-on:click="signupRedirect()" class="toggleForms">Signup here</a>
                </p>
            </div>
            </div>
        </div>
        </div>
        <LoaderComponent :processing="processing"/>
    </section>
</template>

<script>
import {login} from '../apiService';
import {getAuthenticatedUser} from '../utils';
import LoaderComponent from "../components/LoaderComponent.vue";
import { required } from 'vuelidate/lib/validators';

export default {
    name:"LoginComponent",
    components:{
        LoaderComponent
    },

    data(){
        return {
            payload: {
                email: null,
                password: null
            },
            processing: false,
        }
    },

    validations:{
        payload: {
            email: {required},
            password: {required}
        },
    },

    methods: {
        async LoginUser ()
        {
            this.$v.payload.$touch();
            if(this.$v.payload.$invalid){
                return;
            }
            this.processing = true;
            await login(this.payload).then((response)=>{
                this.$store.commit('setAccessToken', response.result.access_token);
                getAuthenticatedUser();
                this.$router.push('/');

            }).catch((err)=>{
                console.log("error",err);
            }).finally(()=>{
                this.processing = false;
            });
        },

        signupRedirect()
        {
            this.$router.push('/signup')
        }
    }

}
</script>


<template>
<section class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Signup</h3>
        </div>
        <div class="card-body">
          <form id="signupForm">
            <div class="mb-3">
              <input type="text" v-model="payload.first_name" class="form-control" id="signup__firstName" maxlength="50" placeholder="First Name" />
              <span class="text-danger" v-if="$v.payload.first_name.$error">First Name Required</span>
            </div>
            <div class="mb-3">
              <input type="text" v-model="payload.last_name" class="form-control" id="signup__lastName" maxlength="50" placeholder="Last Name"  />
              <span class="text-danger" v-if="$v.payload.last_name.$error">Last Name Required</span>
            </div>
            <div class="mb-3">
              <input type="email" v-model="payload.email" class="form-control" id="signup__email" placeholder="Email"  />
              <span class="text-danger" v-if="$v.payload.email.$error">{{ $v.payload.email.$dirty ? 'Invalid email' : 'Email Required' }}</span>
            </div>
            <div class="mb-3">
              <input type="password" v-model="payload.password" class="form-control" id="signup__password" minlength="6" maxlength="16" placeholder="Password"  />
              <span class="text-danger" v-if="$v.payload.password.$error">Password Required</span>
            </div>
            <div class="mb-3">
              <input type="password" v-model="payload.confirm_password" class="form-control" id="signup__confirmPassword" minlength="6" maxlength="16" placeholder="Confirm Password"  />
              <span class="text-danger" v-if="$v.payload.confirm_password.$error">Confirm Passsword Required</span>

            </div>
            <button v-on:click="RegisterUser()" class="btn btn-success btn-block" id="signup__submit">Signup</button>
          </form>
          <p class="mt-3 text-center">
            Already have an account? <a v-on:click="loginRedirect()" class="toggleForms">Login here</a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <LoaderComponent :processing="processing"/>
</section>

</template>

<script>
import {register } from '../apiService';
import LoaderComponent from "../components/LoaderComponent.vue";
import { required, email, sameAs } from 'vuelidate/lib/validators';

export default {
    name:"SignupComponent",
    components:{
      LoaderComponent
    },
    data(){
        return {
            payload: {
                email: null,
                password: null,
                first_name: null,
                last_name: null,
                confirm_password: null,
            },
            processing: false
        }
    },

    validations: {
      payload: {
         email: {
          required,
          email
        },
        password: {
          required
        },
        first_name: {
          required
        },
        last_name: {
          required
        },
        confirm_password: {
          required,
          sameAsPassword: sameAs('password')
        }
      }
   
  },

    methods: {
        async RegisterUser ()
        {
          this.$v.payload.$touch();
          if(this.$v.payload.$invalid){
            return;
          }

          const data = {
            email: this.payload.email,
            password: this.payload.password,
            first_name: this.payload.first_name,
            last_name: this.payload.last_name,
          }

          this.processing = true;
          await register(data).then(()=>{
            this.loginRedirect();
            }).catch((err)=>{
              console.log(err);
            }).finally(()=>{
              this.processing = false;
            });

        },

        loginRedirect()
        {
            this.$router.push('/login')
        }
    }

}
</script>


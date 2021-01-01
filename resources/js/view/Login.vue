<template>
    <div>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Login Form</h6>
                        </div>
                        <div class="card-body">
                           <form @submit="signIn">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Masukkan Email" v-model="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" placeholder="Masukkan Password" v-model="password">
                                </div>
                                <div class="form-group">
                                    <p>{{message}}</p>
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-primary" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'Login',
    data () {
      return {
        email: '',
        password: '',
        emailError: false,
        passwordError: false,
        message: '',
        url: 'http://localhost:8000/api'
      }
    },
    methods: {
      signIn (e) {
        e.preventDefault()
        if(this.email == '' || this.password == ''){
        return this.message = 'Email atau Password tidak boleh kosong!'
        }
        axios.post('http://localhost:8000/api/login', {
            email: this.email,
            password: this.password
        }, {
            headers: {
                'content-type': 'application/json',
            },
        })
        .then(res => {
            console.log(res)
        })
        .catch(err => {
            console.log(err.response)
        })

      }
    }
}
</script>

<style>

</style>

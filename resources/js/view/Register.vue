<template>
    <div>
        <div class="container">
            <div class="row justify-content-center mt-3">
                <div class="col-md-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Register Form</h6>
                        </div>
                        <div class="card-body">
                           <form @submit="signIn">
                                <div class="form-group">
                                    <label for="email">Fullname</label>
                                    <input type="text" class="form-control" id="email" placeholder="Masukkan Email" v-model="email">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Masukkan Email" v-model="email">
                                </div>
                                <div class="form-group">
                                    <label for="email">Phone</label>
                                    <input type="text" class="form-control" id="email" placeholder="Masukkan Email" v-model="email">
                                </div>
                                <div class="form-group">
                                    <label for="email">Address</label>
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
                                    <button class="btn btn-primary" type="submit">Register</button>
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
export default {

}
</script>

<style>

</style>

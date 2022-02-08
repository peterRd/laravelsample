<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="col-md-12 text-center">
                        <p v-if="errors.length">
                            <b>Please correct the following error(s):</b>
                        <ul class="list-group">
                            <li v-for="error in errors" class="list-group-item list-group-item-danger">{{ error }}</li>
                        </ul>
                        </p>
                    </div>

                    <div class="card-body">
                        <form @submit="checkForm" id="createAdministrator">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                                    <input  v-model="email" type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                    <input v-model="password" type="password" class="form-control" id="password" placeholder="********" name="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
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
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            errors: [],
            email: '',
            password: ''
        }
    },
    methods:{
        checkForm: function (e) {
            this.errors = [];
            if (!this.email) {
                this.errors.push('Email required.');
            }

            if (!this.password) {
                this.errors.push('Password required.');
            }

            if (!this.errors.length){
                axios.post('/login', {'email': this.$data.email, 'password': this.$data.password}).then(function(response, status, request) {
                    window.location.href = "/home";
                }, function() {
                    console.log('failed');
                });
            }

            e.preventDefault();
        }
    }
}
</script>

<template>
    <div class="container">

        <div class="section__header" style="border-bottom: 2px solid rgba(255, 255, 255, 0.05); padding-bottom: 10px; margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col">
                    <h1>Account</h1>
                </div>
                <div class="col-auto">
                    <router-link to="/account">Account</router-link>
                </div>
                <div class="col-auto">
                    <router-link to="/account/billing">Billing</router-link>
                </div>
            </div>
        </div>

        <div class="loading d-flex justify-content-center" v-if="loading">
            <div class="spinner-grow"></div>
        </div>
        <div class="error" v-if="error">
            {{ error }}
        </div>

        <div class="card" v-if="user.email">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-1">
                        <font-awesome-icon :icon="['fas', 'user']" size="3x"></font-awesome-icon>
                    </div>
                    <div class="col">
                        <h2 class="card-title mb-0">{{ user.first_name + ' ' + user.last_name }}</h2>
                        <p>{{ user.email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="row">
                <div class="col">
                    <h2>Password</h2>
                    <p>••••••••</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary" href="#">Change Password</a>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    <h2>Theme</h2>
                    <p>Dark mode</p>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> On
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="option2" autocomplete="off"> Off
                        </label>
                        </div>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary" href="#">Change Password</a>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    <h2>Delete account</h2>
                    <p>This will completely erase your account information as well as cancel any active subscriptions. Please backup your information if you plan on keeping it. It will be inaccesible after your account is deleted.</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-danger" href="#">Delete Account</a>
                </div>
            </div>
        </div>

                

    </div>
</template>
<script>
    export default {
        data() {
            return {
                loading: false,
                error: null,
                user: [],
            }
        },
        created() {
            this.getGoals();
        },
        methods: {
            getGoals() {
                // this.error = this.goals = null;
                this.loading = true;
                axios
                    .get('/api/user')
                    .then(response => {
                        console.log(response);
                        this.loading = false;
                        this.user = response.data;
                    }).catch(error => {
                        this.loading = false;
                        console.error(error);
                        this.error = error.response.data.message || error.message;
                    });
            },



        },
    }
</script>

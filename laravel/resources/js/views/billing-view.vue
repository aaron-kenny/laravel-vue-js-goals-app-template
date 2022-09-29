<template>
    <div class="container">

        <div class="section__header" style="border-bottom: 2px solid rgba(255, 255, 255, 0.05); padding-bottom: 10px; margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col">
                    <h1>Billing</h1>
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

        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-1">
                        <font-awesome-icon :icon="['fas', 'credit-card']" size="3x"></font-awesome-icon>
                    </div>
                    <div class="col">
                        <h2 class="card-title mb-0">XXXX-{{ user.card_last_four }}</h2>
                        <p>{{ user.card_brand }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="row">
                <div class="col">
                    <h2>Subscription</h2>
                    <p>Product Three Pro $5/mo</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary" href="#">Change Plan</a>
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
                    .get('/api/billing')
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

<template>
    <div>
        <!-- LEFT NAVIGATION -->
        <nav id="primaryNav" class="primary-navigation--achieve">
            <div class="primary-navigation__logo-container">
                <router-link to="/"><img class="img-fluid primary-navigation__logo" src="INSERT_PATH_TO_PRODUCT_LOGO" alt="Logo" /></router-link>
            </div>
            <ul class="primary-navigation__list nav flex-column">
                <li class="nav-item"><router-link class="nav-link" to="/goals">Goals</router-link></li>
                <li class="nav-item"><router-link class="nav-link" to="/notes">Notes</router-link></li>
                <div v-if="!(isSubscribed)">
                    <hr>
                    <li class="nav-item">Trial Version<br><small>{{ trialTimeLeft }}</small></li>
                    <li class="text-center mt-3"><a class="btn btn-primary" href="/subscribe">Subscribe Now</a></li>
                </div>
            </ul>
        </nav>
        <!-- END LEFT NAVIGATION -->
        <!-- RIGHT CONTENT -->
        <section style="padding-left: 270px;">
            <header class="header--achieve">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header__search-container">
                                <i class="fas fa-search"></i>
                                <input id="search" class="header__search" type="text" placeholder="Search">
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="dropdown">
                                <a id="dropdownAppLink" href="#" data-toggle="dropdown">
                                    <font-awesome-icon :icon="['fas', 'th']"></font-awesome-icon>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <router-link class="dropdown-item" to="/account">Account</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" id="dropdownMenuLink" class="header__avatar-link" data-toggle="dropdown">
                                    <img class="header__avatar" :src="this.gravatar">
                                </a>
                                <!-- <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown">
                                    <font-awesome-icon :icon="['fas', 'user']"></font-awesome-icon>
                                </a> -->

                                <div class="dropdown-menu dropdown-menu-right">
                                    <router-link class="dropdown-item" to="/account">Account</router-link>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        <input type="hidden" name="_token" :value="csrf">
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </header>
            <div style="padding-top: 100px;">
                <main class="py-4">
                    <router-view></router-view>
                </main>
            </div>
        </section>
        <!--END RIGHT CONTENT -->
    </div>
</template>
<script>
    export default {
        props: ['user', 'isSubscribed', 'trialTimeLeft', 'gravatar'],
        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        created() {
            console.log(this.user);
            console.log(this.isSubscribed);
            console.log(this.gravatar);
        },
    };
</script>
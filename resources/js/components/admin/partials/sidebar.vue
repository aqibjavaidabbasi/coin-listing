<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <router-link class="sidebar-brand brand-logo" to="/admin/dashboard"><img src="/assets/images/logo.png" alt="logo"></router-link>
            <router-link class="sidebar-brand brand-logo-mini" to="/admin/dashboard"><img src="/assets/images/logo.webp" alt="logo"></router-link>
        </div>
        <ul class="nav">
            <li class="nav-item nav-category">
                <span class="nav-link">Navigation</span>
            </li>
            <li class="nav-item menu-items" :class="{ active: active === 'dashboard' }">
                <router-link class="nav-link" to="/admin/dashboard">
                    <span class="menu-icon">
                        <i class="mdi mdi-speedometer"></i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </router-link>
            </li>
            <li class="nav-item menu-items"  :class="{ active: active === 'coins' }">
                <a class="nav-link" data-bs-toggle="collapse" href="#coins-options" aria-expanded="false"
                    aria-controls="coins-options">
                    <span class="menu-icon">
                        <i class="mdi mdi-view-list"></i>
                    </span>
                    <span class="menu-title">Coins</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" :class="{ show: active === 'coins' }" id="coins-options">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> 
                            <router-link class="nav-link" to="/admin/coins">List</router-link>
                        </li>
                        <li class="nav-item"> 
                            <router-link class="nav-link" to="/admin/coins/create">Create</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/admin/coins/requests">Requests</router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item menu-items"  :class="{ active: active === 'blogs' }">
                <a class="nav-link" data-bs-toggle="collapse" href="#blogs-options" aria-expanded="false"
                    aria-controls="blogs-options">
                    <span class="menu-icon">
                        <i class="mdi mdi-view-list"></i>
                    </span>
                    <span class="menu-title">Blogs</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" :class="{ show: active === 'blogs' }" id="blogs-options">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> 
                            <router-link class="nav-link" to="/admin/blogs">List</router-link>
                        </li>
                        <li class="nav-item"> 
                            <router-link class="nav-link" to="/admin/blogs/create">Create</router-link>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item menu-items"  :class="{ active: active === 'network-change' }">
               
                <a class="nav-link" data-bs-toggle="collapse" href="#network-change" aria-expanded="false"
                    aria-controls="network-change">
                    <span class="menu-icon">
                        <i class="mdi mdi-view-list"></i>
                    </span>
                    <span class="menu-title">Network Change</span>
                    <i class="menu-arrow"></i>
                </a>
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> 
                            <router-link class="nav-link" to="/admin/networks">List</router-link>
                        </li>
                        <li class="nav-item"> 
                            <router-link class="nav-link" to="/admin/network/create">Create</router-link>
                        </li>
                    </ul>
                </div>
            </li>

           
        </ul>
    </nav>
</template>

<script>
    export default {
        name: 'Sidebar',
        data() {
            return {
                active: ''
            }
        },
        created() {
            // check current route
            // check if the route has - then split and assign first
            // else assign the route name
            this.active = this.$route.path.split('/')[2] ? this.$route.path.split('/')[2] : this.$route.name;
        },
    }
</script>
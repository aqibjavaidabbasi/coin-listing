import Vue from 'vue'
import Router from 'vue-router'
import NProgress from 'nprogress' // Make sure to import NProgress



import Home from './../components/front-end/index.vue'
import News from './../components/front-end/News.vue'
import ContactUs from './../components/front-end/Contact.vue'
import ListCoin from './../components/front-end/coins/ListCoin.vue'
import NewsDetail from './../components/front-end/NewsDetail.vue'
import AdminLogin from './../components/admin/auth/Login.vue'
import Dashboard from './../components/admin/dashboard/index.vue'
import Coins from './../components/admin/coins/index.vue'
import CreateCoin from './../components/admin/coins/create.vue'
import CoinRequests from './../components/admin/coins/requests.vue'
import Blogs from './../components/admin/blogs/index.vue'
import CreateBlog from './../components/admin/blogs/create.vue'
import EditCoin from './../components/admin/coins/edit.vue'
import EditBlog from './../components/admin/blogs/edit.vue'
import ViewBlog from './../components/admin/blogs/view.vue'

import NetworkChange from './../components/admin/network-change/index.vue'

import CreateNetworkChange from './../components/admin/network-change/create.vue'
import EditNetworks from './../components/admin/network-change/edit.vue'



Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      name: 'home',
      path: '/home',
      component: Home
    },
    {
      name: 'news',
      path: '/news',
      component: News
    },
    {
      name: 'list-coin',
      path: '/list-coin',
      component: ListCoin
    },
    {
      name: 'contact-us',
      path: '/contact-us',
      component: ContactUs
    },
    {
      name: 'news-detail',
      path: '/news-detail/:slug',
      component: NewsDetail
    },
    {
      path: '/admin',
      component: {
        render(c) {
          return c('router-view')
        }
      },
      children: [
        {
          name: 'login',
          path: 'login',
          component: AdminLogin
        },
        {
          path: 'networks',
          name: 'networks',
          component: NetworkChange,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'networks/edit/:id',
          name: 'networks-edit',
          component: EditNetworks,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'network/create',
          name: 'network/create',
          component: CreateNetworkChange,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'dashboard',
          name: 'dashboard',
          component: Dashboard,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'coins',
          name: 'coins',
          component: Coins,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'coins/create',
          name: 'coins-create',
          component: CreateCoin,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'coins/requests',
          name: 'coins-requests',
          component: CoinRequests,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'blogs',
          name: 'blogs',
          component: Blogs,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'blogs/create',
          name: 'blogs-create',
          component: CreateBlog,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'coin/edit/:id',
          name: 'coin-edit',
          component: EditCoin,
          meta: {
            requiresAuth: true
          }
        },

        {
          path: 'blogs/edit/:id',
          name: 'blogs-edit',
          component: EditBlog,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'blogs/view/:id',
          name: 'blogs-view',
          component: ViewBlog,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'analytics',
          name: 'analytics',
          component: Dashboard,
          meta: {
            requiresAuth: true
          }
        }
      ]
    },
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // This route requires authentication

    // Check if the user is logged in
    const token = localStorage.getItem('token');

    if (!token) {
      // User is not logged in and no token exists
      next({
        name: 'login'
      });
    } else {
      // User is logged in
      next();
    }
  } else {
    // This route does not require authentication
    next();
  }
});


router.afterEach((to, from) => {
  // Finish the route progress bar
  NProgress.done()
})

export default router

import Home from './../components/front-end/index.vue'
import News from './../components/front-end/News.vue'
import ContactUs from './../components/front-end/Contact.vue'
import ListCoin from './../components/front-end/coins/ListCoin.vue'
import NewsDetail from './../components/front-end/NewsDetail.vue'
import AdminLogin from './../components/admin/auth/Login.vue'
import Dashboard from './../components/admin/dashboard/index.vue'
import Coins from './../components/admin/coins/index.vue'
import CoinRequests from './../components/admin/coins/requests.vue'

export const routes = [
    {
        path: '/',
        redirect: '/home'
    },
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
          render (c) { return c('router-view') }
        },
        children: [
            {
                name: 'login',
                path: 'login',
                component: AdminLogin
            },
            {
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard,
                meta: { requiresAuth: true }
            },
            {
                path: 'coins',
                name: 'coins',
                component: Coins,
                meta: { requiresAuth: true }
            },
            {
                path: 'coins/create',
                name: 'coins-create',
                component: Coins,
                meta: { requiresAuth: true }
            },
            {
                path: 'coins/requests',
                name: 'coins-requests',
                component: CoinRequests,
            },
            {
                path: 'analytics',
                name: 'analytics',
                component: Dashboard,
                meta: { requiresAuth: true }
            }
        ]
    }    
];
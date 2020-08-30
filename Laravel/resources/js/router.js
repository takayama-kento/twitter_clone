import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポート
import Top from './pages/Top.vue'
import Login from './pages/Login.vue'
import Users from './pages/UserList.vue'
import UserDetail from './pages/UserDetail.vue'
import Tweets from './pages/TweetList.vue'
import TweetForm from './pages/TweetForm.vue'
import SystemError from './pages/System.vue'

import store from './store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: Top
    },
    {
        path: '/login',
        component: Login,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        }
    },
    {
        path: '/users',
        component: Users,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/login')
            }
        }
    },
    {
        path: '/users/:id',
        component: UserDetail,
        props: true,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/login')
            }
        }
    },
    {
        path: '/tweets',
        component: Tweets,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/login')
            }
        }
    },
    {
        path: '/tweets/create',
        component: TweetForm,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next('/login')
            }
        }
    },
    {
        path: '/500',
        component: SystemError
    }
]

// VueRouterインスタンスを作成
const router = new VueRouter({
    mode: 'history',
    routes
})

export default router
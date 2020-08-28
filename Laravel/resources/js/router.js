import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポート
import Top from './pages/Top.vue'
import Login from './pages/Login.vue'

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
]

// VueRouterインスタンスを作成
const router = new VueRouter({
    mode: 'history',
    routes
})

export default router
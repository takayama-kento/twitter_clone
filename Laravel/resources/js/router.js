import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポート
import Login from './pages/Login.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: Login
    }
]

// VueRouterインスタンスを作成
const router = new VueRouter({
    mode: 'history',
    routes
})

export default router
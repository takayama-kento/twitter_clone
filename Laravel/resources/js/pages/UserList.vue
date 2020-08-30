<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <User
                v-for="user in users"
                :key="user.id"
                :item="user"
                @follow="onFollowClick"
            />
        </div>
    </div>
</template>

<script>
import { OK } from '../util'
import User from '../components/User.vue'

export default {
    components: {
        User
    },
    data () {
        return {
            users: []
        }
    },
    methods: {
        async fetchUsers() {
            const response = await axios.get('/api/users')
            
            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.users = response.data.data
        },
        onFollowClick ({ id, followed }) {
            if (followed) {
                this.unfollow(id)
            } else {
                this.follow(id)
            }
        },
        async follow(id) {
            const response = await axios.put(`/api/users/${id}/follow`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.users = this.users.map(user => {
                if (user.id === response.data.user_id) {
                    user.following_to_user = true
                }
                return user
            })
        },
        async unfollow(id) {
            const response = await axios.delete(`/api/users/${id}/follow`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.users = this.users.map(user => {
                if (user.id === response.data.user_id) {
                    user.following_to_user = false
                }
                return user
            })
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchUsers()
            },
            immediate: true
        }
    }
}
</script>
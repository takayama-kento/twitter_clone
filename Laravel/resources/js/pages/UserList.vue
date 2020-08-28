<template>
    <div class="user-list">
        <div class="grid">
            <User
                class="grid__item"
                v-for="user in users"
                :key="user.id"
                :item="user"
            />
        </div>
    </div>
</template>

<script>
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
            this.users = response.data.data
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
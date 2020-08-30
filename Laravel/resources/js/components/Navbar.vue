<template>
    <nav class="navbar">
        <RouterLink class="navbar__brand" to="/">
            Twitter Clone
        </RouterLink>
        <div class="navbar__menu">
            <div v-if="isLogin">
                <RouterLink class="button button--link" :to="`/users/${this.userId}`">
                    {{ username }}
                </RouterLink>
                <RouterLink class="button button--link" to="/users">
                    Users
                </RouterLink>
                <RouterLink class="button button--link" to="/tweets">
                    Tweets
                </RouterLink>
                <RouterLink class="button button--link" to="/tweets/create">
                    Tweetする
                </RouterLink>
            </div>
            <div v-else class="navbar__item">
                <RouterLink class="button button--link" to="/login">
                    Login /Register
                </RouterLink>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    computed: {
        isLogin () {
            return this.$store.getters['auth/check']
        },
        username () {
            return this.$store.getters['auth/username']
        },
        userId () {
            return this.$store.getters['auth/userId']
        }
    }
}
</script>
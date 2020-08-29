<template>
    <div class="container--small">
        <div class="panel">
            <form class="form" @submit.prevent="submit">
                <label for="tweet_content">Tweet Content</label>
                <textarea class="form__item" id="content" v-model="Tweet.tweet"></textarea>
                <div class="form__button">
                    <button type="submit" class="button button--inverse">submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            Tweet: {
                tweet: ''
            }
        }
    },
    methods: {
        async submit() {
            const response = await axios.post('/api/tweets/create', this.Tweet)
            if (response.status === 201) {
                this.$router.push('/tweets')
            }
        }
    }
}
</script>
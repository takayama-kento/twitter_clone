<template>
    <div class="tweet-list">
        <Tweet
            v-for="tweet in tweets"
            :key="tweet.id"
            :item="tweet"
            @like="onLikeClick"
        />
    </div>
</template>

<script>
import { OK } from '../util'
import Tweet from '../components/FollowingTweet.vue'

export default {
    components: {
        Tweet
    },
    data () {
        return {
            tweets: []
        }
    },
    methods: {
        async fetchTweets () {
            const response = await axios.get('/api/tweets')

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.tweets = response.data.data
        },
        onLikeClick ({ id, liked }) {
             if (liked) {
                this.unlike(id)
            } else {
                this.like(id)
            }
        },
        async like(id) {
            const response = await axios.put(`/api/tweets/${id}/like`)

            if (response.status !== OK) {
                return false
            }

            this.tweets = this.tweets.map(tweet => {
                if (tweet.id === response.data.tweet_id) {
                    tweet.likes_count += 1
                    tweet.liked_by_user = true
                }
                return tweet
            })
        },
        async unlike(id) {
            const response = await axios.delete(`/api/tweets/${id}/like`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.tweets = this.tweets.map(tweet => {
                if (tweet.id === response.data.tweet_id) {
                    tweet.likes_count -= 1
                    tweet.liked_by_user = false
                }
                return tweet
            })
        }
    },
    watch: {
        $route: {
            async handler() {
                await this.fetchTweets()
            },
            immediate: true
        }
    }
}
</script>
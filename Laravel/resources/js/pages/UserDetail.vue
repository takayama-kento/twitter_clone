<template>
    <div class="row justify-content-center">
        <!-- ユーザー詳細 -->
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="d-inline-flex">
                    <div class="p-3 d-flex flex-column">
                        <img src="https://drive.google.com/uc?id=1tRwOMX-PoWhp1dFhuV2wpe5_cOc6699W" class="rounded-circle" width="100" height="100">
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="mb-0 font-weight-bold">{{ user.name }}</h4>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex">
                            <div class="px-2" v-show="user.followed_by_user">
                                <span class="px-1 bg-secondary text-light">フォローされています</span>
                            </div>
                            <div v-if="user.id === userId" class="d-flex justify-content-end flex-grow-1">
                                <button class="btn btn-dark">
                                    あなた
                                </button>
                            </div>
                            <div v-else-if="user.following_to_user" class="d-flex justify-content-end flex-grow-1">
                                <button class="btn btn-danger" @click.prevent="onFollowClick">
                                    フォロー解除
                                </button>
                            </div>
                            <div v-else class="d-flex justify-content-end flex-grow-1">
                                <button class="btn btn-primary" @click.prevent="onFollowClick">
                                    フォローする
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">ツイート数</p>
                                <span>{{ user.tweets_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロー数</p>
                                <span>{{ user.follows_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロワー数</p>
                                <span>{{ user.followers_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ツイート一覧 -->
        <Tweet
             v-for="tweet in tweets"
            :key="tweet.id"
            :item="tweet"
            @like="onLikeClick"
        />

    </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Tweet from '../components/Tweet.vue'

export default {
    computed: {
        userId () {
            return this.$store.getters['auth/userId']
        }
    },
    components: {
        Tweet
    },
    props: {
        id: {
            type: String,
            required: true,
        }
    },
    data () {
        return {
            user: null,
            tweets: []
        }
    },
    methods: {
        async fetchUser () {
            const response = await axios.get(`/api/users/${this.id}`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.user = response.data
        },
        async fetchTweets () {
            const response = await axios.get(`/api/users/${this.id}/tweets`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.tweets = response.data.data
        },
        onFollowClick () {
            if (this.user.following_to_user) {
                this.unfollow(this.id)
            } else {
                this.follow(this.id)
            }
        },
        async follow(id) {
            const response = await axios.put(`/api/users/${id}/follow`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.user.following_to_user = true
            this.user.followers_count += 1
        },
        async unfollow(id) {
            const response = await axios.delete(`/api/users/${id}/follow`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.user.following_to_user = false
            this.user.followers_count -= 1
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
                await this.fetchUser()
                await this.fetchTweets()
            },
            immediate: true
        }
    }
}
</script>
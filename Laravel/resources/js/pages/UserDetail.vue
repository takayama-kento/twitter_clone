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
                            <div v-if="user.following_to_user">
                                <button class="btn btn-danger" @click.prevent="onFolllowClick">
                                    フォロー解除
                                </button>
                            </div>
                            <div v-else>
                                <button class="btn btn-primary" @click.prevent="onFollowClick">
                                    フォローする
                                </button>
                            </div>
                            <div v-show="user.followed_by_user">
                                <span class="mt-2 px-1 bg-secondary text-light">
                                    フォローされています
                                </span>
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
        />

    </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Tweet from '../components/Tweet.vue'

export default {
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
                this.follow(this.id)
            } else {
                this.unfollow(this.id)
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
            async handler() {
                await this.fetchUser()
                await this.fetchTweets()
            },
            immediate: true
        }
    }
}
</script>
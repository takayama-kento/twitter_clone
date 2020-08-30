<template>
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header p-3 w-100 d-flex">
                <img src="https://drive.google.com/uc?id=1tRwOMX-PoWhp1dFhuV2wpe5_cOc6699W" class="rounded-circle" width="50" height="50">
                <div class="ml-2 d-flex flex-column flex-grow-1">
                    <RouterLink
                        class="text-secondary"
                        :to="`/users/${tweet.author.id}`"
                    >
                        {{ tweet.author.name }}
                    </RouterLink>
                </div>
                <div class="d-flex justify-content-end flex-grow-1">
                    <p class="mb-0 text-secondary">
                        {{ tweet.formatted_created_at }}
                    </p>
                </div>
            </div>
            <div class="card-body">
                {{ tweet.tweet }}
            </div>
            <div class="card-footer py-1 justify-content-end bg-white">
                <div v-if="tweet.liked_by_user" class="mr-2 d-flex align-items-center">
                    <button class="btn p-0 border-0" @click.prevent="onLikeClick">
                        <span class="fa fa-heart like-btn-unlike"></span>
                    </button>
                    <p class="mb-0 text-secondary">{{ tweet.likes_count }}</p>
                </div>
                <div v-else class="mr-2 d-flex align-items-center">
                    <button class="btn p-0 border-0" @click.prevent="onLikeClick">
                        <span class="fa fa-heart like-btn"></span>
                    </button>
                    <p class="mb-0 text-secondary">{{ tweet.likes_count }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

export default {
    props: {
        id: {
            type: String,
            required: true,
        }
    },
    data () {
        return {
            tweet: null,
        }
    },
    methods: {
        async fetchTweet () {
            const response = await axios.get(`/api/tweets/${this.id}`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.tweet = response.data
        },
        onLikeClick () {
             if (this.tweet.liked_by_user) {
                this.unlike(this.id)
            } else {
                this.like(this.id)
            }
        },
        async like(id) {
            const response = await axios.put(`/api/tweets/${id}/like`)

            if (response.status !== OK) {
                return false
            }

            if (this.tweet.id === response.data.tweet_id) {
                this.tweet.likes_count += 1
                this.tweet.liked_by_user = true
            }
        },
        async unlike(id) {
            const response = await axios.delete(`/api/tweets/${id}/like`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            if (this.tweet.id === response.data.tweet_id) {
                this.tweet.likes_count -= 1
                this.tweet.liked_by_user = false
            }
        }
    },
    watch: {
        $route: {
            async handler() {
                await this.fetchTweet()
            },
            immediate: true
        }
    }
}
</script>
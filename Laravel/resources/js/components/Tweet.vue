<template>
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header p-3 w-100 d-flex">
                <img src="https://drive.google.com/uc?id=1tRwOMX-PoWhp1dFhuV2wpe5_cOc6699W" class="rounded-circle" width="50" height="50">
                <div class="ml-2 d-flex flex-column flex-grow-1">
                    <RouterLink
                        class="text-secondary"
                        :to="`/users/${item.author.id}`"
                    >
                        {{ item.author.name }}
                    </RouterLink>
                </div>
                <div class="d-flex justify-content-end flex-grow-1">
                    <p class="mb-0 text-secondary">
                        {{ item.formatted_created_at }}
                    </p>
                </div>
            </div>
            <div class="card-body">
                <RouterLink :to="`/tweets/${item.id}`" class="button button--link">
                    {{ item.tweet }}
                </RouterLink>
            </div>
            <div class="card-footer py-1 justify-content-end bg-white">
                <div v-if="item.liked_by_user" class="mr-2 d-flex align-items-center">
                    <button class="btn p-0 border-0" @click.prevent="like">
                        <span class="fa fa-heart like-btn-unlike"></span>
                    </button>
                    <p class="mb-0 text-secondary">{{ item.likes_count }}</p>
                </div>
                <div v-else class="mr-2 d-flex align-items-center">
                    <button class="btn p-0 border-0" @click.prevent="like">
                        <span class="fa fa-heart like-btn"></span>
                    </button>
                    <p class="mb-0 text-secondary">{{ item.likes_count }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    methods: {
        like () {
            this.$emit('like', {
                id: this.item.id,
                liked: this.item.liked_by_user,
            })
        }
    }
}
</script>
<template>
    <div class="card">
        <div class="card-header p-3 w-100 d-flex">
            <img src="https://drive.google.com/uc?id=1tRwOMX-PoWhp1dFhuV2wpe5_cOc6699W" class="rounded-circle" width="50" height="50">
            <div class="ml-2 d-flex flex-column">
                <RouterLink
                    class="button button--link"
                    :to="`/users/${item.id}`"
                    :title="`${item.name}`"
                >{{ item.name }}</RouterLink>
            </div>
            <div class="px-2" v-show="item.followed_by_user">
                <span class="px-1 bg-secondary text-light">フォローされています</span>
            </div>
            <div v-if="item.following_to_user" class="d-flex justify-content-end flex-grow-1">
                <button class="btn btn-danger" @click.prevent="follow">
                    フォロー解除
                </button>
            </div>
            <div v-else class="d-flex justify-content-end flex-grow-1">
                <button class="btn btn-primary">
                    フォローする
                </button>
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
        follow () {
            this.$emit('follow', {
                id: this.item.id,
                followed: this.item.following_to_user
            })
        }
    }
}
</script>
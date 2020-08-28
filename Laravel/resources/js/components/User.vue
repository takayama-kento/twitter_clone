<template>
    <div class="user">
        <figure class="user-wrapper">
            {{ item.name }}
        </figure>
        <RouterLink
            class="user__overlay"
            :to="`/users/${item.id}`"
            :title="item.name"
        >
            <div class="user__controls">
                <button
                    class="user__action user__action--like"
                    title="Like user"
                >
                    <i class="icon ion-md-heart"></i>12
                </button>
            </div>
        </RouterLink>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            required: true
        }
    }
}
</script>
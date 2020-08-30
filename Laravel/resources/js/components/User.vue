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
    }
}
</script>
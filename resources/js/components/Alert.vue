<template>
    <div class="alert" :class="type">
        <h1>{{ title }}</h1>
        <p>{{ message }}</p>
    </div>
</template>

<script>
    export default {
        name: "Alert",

        props: [
            'type',
            'title',
            'message'
        ],
    }
</script>

<style scoped>

</style>
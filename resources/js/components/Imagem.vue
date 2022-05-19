<template>

    <div>
        <img :src="'storage/'+src" alt="">
    </div>
</template>

<script>
    export default {
        props: ['src']
    }
</script>

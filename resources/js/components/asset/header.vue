<template>
    <heading class="mb-6 font-bold ">{{ type.charAt(0).toUpperCase() + type.slice(1) }} Report
        <button class="btn btn-sm float-right text-sm" @click="goBack">Go back</button></heading>
</template>

<script>
export default {
    name: "header",
    props:["type"],
    methods:{
        goBack(){
            this.$emit('goBack');
        }
    }
}
</script>

<style scoped>

</style>

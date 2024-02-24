<script setup>
import {Head} from '@inertiajs/vue3';
import Login from "@/Pages/Auth/Login.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Welcome"/>
    <Login></Login>

</template>

<style>
</style>

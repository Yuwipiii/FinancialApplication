<script setup>
import {Head} from '@inertiajs/vue3';
import Login from "@/Pages/Auth/Login.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

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
        <Login></Login>
</template>

<style>
</style>

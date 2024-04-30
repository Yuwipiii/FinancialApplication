<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-lg text-red-700/80">
            {{ message }}
        </p>
    </div>
</template>

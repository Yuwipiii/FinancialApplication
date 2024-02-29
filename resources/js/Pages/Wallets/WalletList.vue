<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Card from "@/Components/Card.vue";
import SimplePaginator from "@/Components/Pagination.vue";


defineProps(['wallets']);


</script>

<template>
    <Head title="Wallets List"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Wallets</h2>
                <a class="" :href="route('wallets.create')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </a>
            </div>

        </template>

        <template #main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 gap-2">
                        <div v-for="(wallet,index) in this.wallets['data']" :key="index">
                            <Card  :balance="wallet.balance"
                                  :card-name="wallet.name" :card-type="wallet.type"
                                  :card-id="wallet.id"
                                  :currency-type="wallet.currency"></Card>
                        </div>
                    </div>
                    <SimplePaginator class="flex justify-self-center"
                                     :paginator="wallets"></SimplePaginator>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
<style>

</style>

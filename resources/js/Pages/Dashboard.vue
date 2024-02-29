<script>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";

export default {
    components: {Card, AuthenticatedLayout, Head},
    props: {
        'netWorthUSD': {
            type: Number,
            required: true
        }, 'netWorthKGS': {
            type: Number,
            required: true
        }
        , 'wallets': {
            required: true
        }
    },
    methods: {
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }
    },
    data() {
        return {
            showNetWorth: 0
        }
    }
}
</script>

<template>
    <Head title="Dashboard"></Head>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-center">
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Welcome to My Budget Dashboard</h2>
                </div>
            </div>
        </template>
        <template #main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <div
                                class="flex justify-around bg-slate-400 p-4 rounded-lg shadow-2xl hover:scale-95 hover:bg-slate-400/50"
                                @click="this.showNetWorth  = !this.showNetWorth">
                                <p>Net Worth</p>
                                <div>
                                    <p class="text-emerald-800">{{ formatPrice(this.netWorthUSD) + ' USD' }}</p>
                                    <p class="text-emerald-800">{{ formatPrice(this.netWorthKGS) + ' KGS' }}</p>
                                </div>
                            </div>
                            <Transition name="bounce">
                                <div
                                    v-if="this.showNetWorth">
                                    <div v-for="(wallet,index) in this.wallets" :key="index">
                                        <div
                                            class="flex mt-3 justify-around bg-slate-200 pt-2 pb-2 rounded-lg shadow-2xl hover:scale-95 hover:bg-slate-400/50 ">
                                            <div>
                                                <p>{{ wallet.name }}</p>
                                                <p>{{ wallet.type }}</p>
                                            </div>
                                            <div>
                                                <p class="text-emerald-800">
                                                    {{ formatPrice(wallet.balance) + " " + wallet.currency }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                        <div class="col-span-2">
                            <div
                                class="flex justify-around bg-slate-400 pt-2 pb-2 rounded-lg shadow-2xl hover:scale-95 hover:bg-slate-400/50 ">
                                >

                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.bounce-enter-active {
    animation: bounce-in 0.5s;
}

.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.25);
    }
    100% {
        transform: scale(1);
    }
}
</style>

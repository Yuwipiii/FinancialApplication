<script>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import ExpenseCreateForm from "@/Components/ExpenseCreateForm.vue";

export default {
    components: {ExpenseCreateForm, Card, AuthenticatedLayout, Head},
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
        }, 'categories': {
            required: true
        }, 'currencies': {
            required: true
        }
    },
    methods: {
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }, showWallet(cardId) {
            router.get(route('wallets.show', cardId))
        }
    },
    data() {
        return {
            showNetWorth: false,
            showExpense: false,
            showTransfer: false,
            showIncome: false
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
                        <div><h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center mb-4">Net
                            Worth</h2>

                            <div
                                class="flex flex-col bg-slate-400 p-4 rounded-lg shadow-2xl hover:scale-95 hover:bg-slate-400/50 ps-5 pe-5"
                                @click="this.showNetWorth  = !this.showNetWorth">
                                <div class="flex justify-between">
                                    <p class="text-emerald-800 text-2xl">{{
                                            formatPrice(this.netWorthUSD)
                                        }}</p>
                                    <p class="text-emerald-800 text-2xl">USD</p>
                                </div>
                                <div class="flex justify-between">
                                    <p class="text-emerald-800 text-2xl">{{
                                            formatPrice(this.netWorthKGS)
                                        }}</p>
                                    <p class="text-emerald-800 text-2xl">KGS</p>
                                </div>
                            </div>
                            <Transition name="bounce">
                                <div
                                    v-if="this.showNetWorth">
                                    <div v-for="(wallet,index) in this.wallets" :key="index">
                                        <div @click="showWallet(wallet.id)"
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
                            <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center mb-4">New
                                Transaction</h2>
                            <div class="grid grid-cols-3 gap-1">
                                <div
                                    @click="this.showExpense  = !this.showExpense;this.showTransfer =false;this.showIncome =false"
                                    class="flex justify-center rounded-lg  border-2 border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50 ">
                                    01
                                </div>
                                <div
                                    @click="this.showIncome  = !this.showIncome;this.showTransfer =false;this.showExpense =false"
                                    class="flex justify-center rounded-lg border-2  border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50 ">
                                    02
                                </div>
                                <div
                                    @click="this.showTransfer = !this.showTransfer;this.showIncome = false; this.showExpense =false"
                                    class="flex justify-center rounded-lg border-2  border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50 ">
                                    03
                                </div>
                            </div>
                            <div v-if="this.showExpense">
                                <ExpenseCreateForm
                                    :categories="categories" :wallets='wallets'
                                    :currencies="currencies"></ExpenseCreateForm>

                            </div>
                            <div v-else-if="showIncome">
                                <div
                                    class="flex mt-3 justify-around bg-slate-400 pt-2 pb-2 rounded-lg shadow-2xl">
                                    Бвыф
                                </div>
                            </div>
                            <div v-else-if="showTransfer">
                                <div
                                    class="flex mt-3 justify-around bg-slate-400 pt-2 pb-2 rounded-lg shadow-2xl">
                                    Бвыф
                                </div>
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

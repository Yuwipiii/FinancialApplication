<script>


import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputLabel from "../../Components/InputLabel.vue";
import TextInput from "../../Components/TextInput.vue";
import InputError from "../../Components/InputError.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, InputError, TextInput, InputLabel, AuthenticatedLayout, Head,},

    data() {
        return {
            isEdit: false,
            form: useForm({
                name: this.wallet['name'],
                type: ''
            }),
            showWeekly:false,
            showYearly:false,
            showMonthly:false
        }
    },
    props: {
        'types': {
            type: Object,
            required: true
        },
        'wallet': {
            type: Object,
            required: true
        },
        'currentMonth': {
            required: true
        },
        'incomes': {
            required: true
        }, 'incomesSum': {
            required: true
        }, 'expenses': {
            required: true
        }, 'expensesSum': {
            required: true
        },'monthlyWalletExpensesChart':{
            required:true,
            type:Object
        },'monthlyWalletIncomesChart':{
            required:true,
            type:Object
        },'weeklyWalletExpenseIncomesChart':{
            required:true,
            type:Object
        },'yearlyWalletExpensesChart':{
            required:true,
            type:Object
        },'yearlyWalletIncomesChart':{
            required:true,
            type:Object
        }
    },
    methods: {
        showEdit() {
            this.isEdit = !this.isEdit;
        },
        submit() {
            this.form.put(route('wallets.update', this.wallet['id']));
            this.isEdit = false;
        },
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }
    }
}

</script>

<template>
    <Head title="Show Wallet"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-2xl  leading-tight">{{ wallet['name'] }}</h2>
                    <span>{{ wallet['type'] }}</span>
                </div>
                <div>
                    <button @click="this.showEdit"
                            class="ms-2 inline-flex px-4 py-2 bg-white border border-gray-200 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg v-if="!isEdit === true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>

                </div>
            </div>

        </template>

        <template #main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Transition name="slide-fade">
                        <div v-if="this.isEdit">
                            <form @submit.prevent="submit" class="bg-gray-600 rounded-lg p-3 ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-8 h-8 stroke-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3"/>
                                </svg>
                                <div>
                                    <InputLabel for="name" value="Wallet Name"/>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full bg-gray-700 text-gray-200"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                    <InputError class="mt-2" :message="form.errors.name"/>
                                </div>

                                <div class="mt-5">
                                    <InputLabel for="name" value="Wallet Type"/>
                                    <div class="flex mt-1">
                                        <select class="bg-gray-700 rounded-lg text-gray-200" v-model="form.type">
                                            <option disabled value="">Select currency of wallet</option>
                                            <option v-for="(type,index) in types" :key="index" :value="type">{{ type }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.type"/>
                                </div>


                                <div class="flex items-center justify-end mt-4">

                                    <PrimaryButton class="ms-4">
                                        Edit
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-3 text-center mb-5">
                                    <span class="font-light text-gray-200  text-2xl">Total Balance</span>
                                    <br>
                                    <p class="font-bold text-4xl text-gray-200">
                                        {{ formatPrice(this.wallet['balance']) + " KGS" }}</p>
                                </div>
                                <div class="col-span-3 grid grid-cols-6 gap-2 text-gray-200 bg-gray-600 rounded-lg shadow-xl p-4">
                                    <h1 class="col-span-6 text-2xl">Statistics for {{ this.currentMonth }}</h1>
                                    <div class="col-span-3">
                                        <div
                                            class="bg-gray-700 rounded-lg p-4">
                                            <div class="grid grid-cols-1">
                                                <h1>Your incomes</h1>
                                                <div>
                                                    <p class="text-emerald-600 text-2xl me-1">{{
                                                            formatPrice(this.incomesSum)
                                                        }} KGS</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <div
                                            class="bg-gray-700 rounded-lg p-4">
                                            <div class="grid grid-cols-1">
                                                <h1>Your Expenses</h1>
                                                <div>
                                                    <p class="text-red-600 text-2xl me-1">{{
                                                            formatPrice(this.expensesSum)
                                                        }} KGS</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-3 grid grid-cols-5 gap-2 bg-gray-600 text-gray-200 rounded-lg shadow-xl p-10">
                                    <h2 class="font-semibold col-span-5  text-2xl  leading-tight text-center mb-4">
                                        Analytics</h2>
                                    <div class="col-span-5 grid grid-cols-3 gap-1 mb-10">
                                        <div
                                            class="p-3 rounded-lg  bg-gray-700  pt-4 pb-4 hover:scale-95 hover:bg-gray-400 shadow-xl"
                                            @click="showWeekly = true;showYearly =false;showMonthly=false">
                                            Last 7 days
                                        </div>
                                        <div
                                            class="p-3 rounded-lg  bg-gray-700  pt-4 pb-4 hover:scale-95 hover:bg-gray-400 shadow-xl"
                                            @click="showMonthly=true;showYearly=false;showWeekly=false">Current month
                                        </div>
                                        <div
                                            class="p-3 rounded-lg  bg-gray-700  pt-4 pb-4 hover:scale-95 hover:bg-gray-400 shadow-xl"
                                            @click="showYearly=true;showWeekly= false;showMonthly=false">Current year
                                        </div>
                                    </div>
                                    <div class="col-span-5">
                                        <div v-show="showWeekly">
                                            <apexchart :width="weeklyWalletExpenseIncomesChart.width"
                                                       :height="weeklyWalletExpenseIncomesChart.height"
                                                       :type="weeklyWalletExpenseIncomesChart.type"
                                                       :options="weeklyWalletExpenseIncomesChart.options"
                                                       :series="weeklyWalletExpenseIncomesChart.series"
                                            ></apexchart>
                                        </div>
                                        <div v-show="showMonthly">
                                            <div class="grid grid-cols-2">
                                                <apexchart class="col-span-1" :width="monthlyWalletExpensesChart.width"
                                                           :height="monthlyWalletExpensesChart.height"
                                                           :type="monthlyWalletExpensesChart.type"
                                                           :options="monthlyWalletExpensesChart.options"
                                                           :series="monthlyWalletExpensesChart.series"
                                                ></apexchart>
                                                <apexchart class="col-span-1" :width="monthlyWalletIncomesChart.width"
                                                           :height="monthlyWalletIncomesChart.height"
                                                           :type="monthlyWalletIncomesChart.type"
                                                           :options="monthlyWalletIncomesChart.options"
                                                           :series="monthlyWalletIncomesChart.series"
                                                ></apexchart>
                                            </div>
                                        </div>
                                        <div v-show="showYearly">
                                            <div class="grid grid-cols-2">
                                                <apexchart class="col-span-1" :width="yearlyWalletExpensesChart.width"
                                                           :height="yearlyWalletExpensesChart.height"
                                                           :type="yearlyWalletExpensesChart.type"
                                                           :options="yearlyWalletExpensesChart.options"
                                                           :series="yearlyWalletExpensesChart.series"
                                                ></apexchart>
                                                <apexchart class="col-span-1" :width="yearlyWalletIncomesChart.width"
                                                           :height="yearlyWalletIncomesChart.height"
                                                           :type="yearlyWalletExpensesChart.type"
                                                           :options="yearlyWalletExpensesChart.options"
                                                           :series="yearlyWalletIncomesChart.series"
                                                ></apexchart>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>

</template>

<style>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>

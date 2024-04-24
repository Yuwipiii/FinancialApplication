<script>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import ExpenseCreateForm from "@/Components/ExpenseCreateForm.vue";
import IncomeCreateForm from "@/Components/IncomeCreateForm.vue";
import IncomesTable from "@/Components/IncomesTable.vue";
import ExpensesTable from "@/Components/ExpensesTable.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import GoalCarousel from "@/Components/GoalCarousel.vue";

export default {
    components: {
        TextInput,
        InputLabel, InputError,
        SecondaryButton,
        Modal,
        ExpensesTable,
        IncomesTable,
        IncomeCreateForm,
        ExpenseCreateForm,
        Card,
        AuthenticatedLayout,
        Head,
        GoalCarousel
    },
    props: {
        'netWorth': {
            type: Number,
            required: true
        }
        , 'wallets': {
            required: true
        }, 'categories': {
            required: true
        }, 'incomeCategories': {
            required: true
        }, 'weeklyExpensesIncomeBarChart': {
            required: true,
            type: Object
        }, 'monthlyExpensesPieChart': {
            required: true,
            type: Object
        }, 'incomesSum': {
            required: true
        }, 'expensesSum': {
            required: true
        }, 'currentMonth': {
            required: true
        }, 'monthlyExpensesChart': {
            required: true,
            type: Object
        }, 'monthlyIncomesChart': {
            required: true,
            type: Object
        }, 'yearlyExpensesChart': {
            required: true,
            type: Object
        }, 'yearlyIncomesChart': {
            required: true,
            type: Object
        }, 'currencies': {
            required: true
        },'goals':{
            required:true
        }
    },
    methods: {
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }, walletsIndex() {
            router.get(route('wallets.index'));
        }, async convertCurrency() {
            try {
                const response = await axios.get(`v1/api/convert/${this.fromCurrency}/${this.toCurrency}/${this.amount}`);
                if (response.data.status === 200) {
                    this.convertedAmount = response.data.data;
                } else {
                    this.convertedError = response.data.message;
                }
            } catch (error) {
                this.convertedError = "Incorrect input";
            }
        }
    },
    data() {
        return {
            showNetWorth: false,
            showExpense: false,
            showIncome: false,
            showWeekly: true,
            showYearly: false,
            showMonthly: false,
            fromCurrency: '',
            toCurrency: '',
            amount: 1,
            convertedAmount: null,
            convertedError: null
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
                    <div class="grid grid-cols-6 gap-2 mb-10">
                        <div
                            class="md:col-span-2 lg:col-span-2 col-span-6 mb-10 bg-slate-400 rounded-lg shadow-xl hover:scale-95 hover:bg-slate-400/50"
                            @click="walletsIndex">
                            <div class="grid grid-cols-1 p-10">
                                <h1 class="text-xl">Total money</h1>
                                <div>
                                    <p class="text-emerald-800 text-3xl me-1">{{
                                            formatPrice(this.netWorth)
                                        }} KGS</p>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4 md:col-span-4 col-span-6 mb-10">
                            <div class="grid grid-cols-6 gap-2 bg-gray-200 rounded-lg shadow-xl p-4">
                                <h1 class="col-span-6 text-2xl">Statistics for {{ this.currentMonth }}</h1>
                                <div class="col-span-3">
                                    <div
                                        class="bg-gray-300 rounded-lg p-4">
                                        <div class="grid grid-cols-1">
                                            <h1>Your incomes</h1>
                                            <div>
                                                <p class="text-emerald-800 text-2xl me-1">{{
                                                        formatPrice(this.incomesSum)
                                                    }} KGS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <div
                                        class="bg-gray-300 rounded-lg p-4">
                                        <div class="grid grid-cols-1">
                                            <h1>Your Expenses</h1>
                                            <div>
                                                <p class="text-red-800 text-2xl me-1">{{
                                                        formatPrice(this.expensesSum)
                                                    }} KGS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 bg-gray-200 p-5 rounded-lg shadow-xl mb-15">
                            <h2 class="font-semibold text-2xl  text-gray-800 leading-tight text-center mb-4">New
                                Transaction</h2>
                            <div class="grid grid-cols-2 gap-1">
                                <ExpenseCreateForm
                                    :categories="categories" :wallets='wallets'>
                                </ExpenseCreateForm>
                                <IncomeCreateForm :income-categories="incomeCategories"
                                                  :wallets="wallets"></IncomeCreateForm>
                            </div>
                        </div>
                        <div class="col-span-6 bg-gray-200 p-5 rounded-lg shadow-xl mb-15">
                            <h2 class="font-semibold text-2xl  text-gray-800 leading-tight text-center mb-4">
                                Currency Converter</h2>
                            <div class="flex justify-around gap-2 mb-4">
                                <div>
                                    <div class="text-sm">From currency</div>
                                    <select class="bg-slate-200/50 rounded-lg" v-model="fromCurrency">
                                        <option disabled value="">From</option>
                                        <option v-for="(currency,index) in this.currencies" :key="index"
                                                :value="currency">
                                            {{ currency }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <div class="text-sm">Amount</div>
                                    <input type="number" min="1" step="0.1" v-model="amount"
                                           class="bg-slate-200/50  rounded w-full"/>
                                </div>
                                <div>
                                    <div class="text-sm">To currency</div>
                                    <select class="bg-slate-200/50 rounded-lg" v-model="toCurrency">
                                        <option disabled value="">To</option>
                                        <option v-for="(currency,index) in this.currencies" :key="index"
                                                :value="currency">
                                            {{ currency }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <button @click="convertCurrency" class="bg-green-500 px-4 py-2 rounded-full w-full mb-15">
                                Convert
                            </button>
                            <div v-if="convertedAmount !== null" class="text-2xl text-emerald-800 text-center mb-4">
                                {{ formatPrice(convertedAmount) + " " + toCurrency }}
                            </div>
                            <div v-else-if="convertedError !== null" class="text-2xl text-center text-red-800 mb-4">
                                {{ convertedError }}
                            </div>
                        </div>
                        <div  class="col-span-6" >
                            <h2 class="font-semibold text-2xl  text-gray-800 leading-tight text-center mb-4">
                                Goals</h2>
                            <GoalCarousel :goals="goals"></GoalCarousel>
                        </div>
                        </div>

                    <div class="grid grid-cols-5 gap-2 bg-gray-200 rounded-lg shadow-xl p-10">
                        <h2 class="font-semibold col-span-5  text-2xl text-gray-800 leading-tight text-center mb-4">
                            Analytics</h2>
                        <div class="col-span-5 grid grid-cols-3 gap-1 mb-10">
                            <div
                                class="p-3 rounded-lg  border-2 bg-gray-100 border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50 shadow-xl"
                                @click="showWeekly = true;showYearly =false;showMonthly=false">
                                Last 7 days
                            </div>
                            <div
                                class="p-3 rounded-lg  border-2 bg-gray-100 border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50 shadow-xl"
                                @click="showMonthly=true;showYearly=false;showWeekly=false">Current month
                            </div>
                            <div
                                class="p-3 rounded-lg  border-2 bg-gray-100 border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50 shadow-xl"
                                @click="showYearly=true;showWeekly= false;showMonthly=false">Current year
                            </div>
                        </div>

                        <div class="col-span-5">
                            <div v-show="showWeekly">
                                <apexchart :width="weeklyExpensesIncomeBarChart.width"
                                           :height="weeklyExpensesIncomeBarChart.height"
                                           :type="weeklyExpensesIncomeBarChart.type"
                                           :options="weeklyExpensesIncomeBarChart.options"
                                           :series="weeklyExpensesIncomeBarChart.series"
                                ></apexchart>
                            </div>
                            <div v-show="showYearly">
                                Yearly
                            </div>
                            <div v-show="showMonthly">
                                <div class="grid grid-cols-2">
                                    <apexchart class="col-span-1" :width="monthlyExpensesChart.width"
                                               :height="monthlyExpensesChart.height"
                                               :type="monthlyExpensesChart.type"
                                               :options="monthlyExpensesChart.options"
                                               :series="monthlyExpensesChart.series"
                                    ></apexchart>
                                    <apexchart class="col-span-1" :width="monthlyIncomesChart.width"
                                               :height="monthlyIncomesChart.height"
                                               :type="monthlyIncomesChart.type"
                                               :options="monthlyIncomesChart.options"
                                               :series="monthlyIncomesChart.series"
                                    ></apexchart>
                                </div>
                            </div>
                            <div v-show="showYearly">
                                <div class="grid grid-cols-2">
                                    <apexchart class="col-span-1" :width="yearlyExpensesChart.width"
                                               :height="yearlyExpensesChart.height"
                                               :type="yearlyExpensesChart.type"
                                               :options="yearlyExpensesChart.options"
                                               :series="yearlyExpensesChart.series"
                                    ></apexchart>
                                    <apexchart class="col-span-1" :width="yearlyIncomesChart.width"
                                               :height="yearlyIncomesChart.height"
                                               :type="yearlyIncomesChart.type"
                                               :options="yearlyIncomesChart.options"
                                               :series="yearlyIncomesChart.series"
                                    ></apexchart>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
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

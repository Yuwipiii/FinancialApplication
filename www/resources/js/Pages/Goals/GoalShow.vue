<script>
import {useToast} from "vue-toast-notification";
import {Head, useForm} from '@inertiajs/vue3';
import InputError from "../../Components/InputError.vue";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import SimplePaginator from "../../Components/Pagination.vue";
import CircleProgress from "vue3-circle-progress";
import ExpensesTable from "../../Components/ExpensesTable.vue";


export default {
    components: {
        ExpensesTable,
        InputError,
        TextInput,
        InputLabel,
        PrimaryButton,
        Head,
        AuthenticatedLayout,
        SimplePaginator,
        CircleProgress
    },
    data() {
        return {
            isEdit: false,
            form: useForm({
                name: this.goal['name'],
                target_amount: this.goal['target_amount']

            })
        }
    },
    props: {
        'goal': {
            type: Object,
            required: true
        },
        'expenses':{
            required: true
        }
    },
    methods: {
        showEdit() {
            this.isEdit = !this.isEdit;
        },
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        },
        submit() {
            this.form.put(route('goals.update', this.goal['id']), {
                onSuccess: () => {
                    const $toast = useToast();
                    let instance = $toast.success('You have successfully updated a goal!');
                    this.isEdit = false;
                    this.form.reset();
                },
                onError: () => {
                    const $toast = useToast();
                    let instance = $toast.error('An error occurred when updating a goal');
                    this.isEdit = false;
                }
            })
        }
    }
}

</script>

<template>
    <Head title="Show income category"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-2xl leading-tight">{{ goal['name'] }}</h2>
                </div>
                <div>
                    <button @click="this.showEdit"
                            class="ms-2 inline-flex px-4 py-2 bg-white border rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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
                                <div>
                                    <InputLabel for="name" value="Category name"/>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full bg-gray-600 text-gray-200"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                    <InputError class="mt-2" :message="form.errors.name"/>
                                </div>

                                <div>
                                    <InputLabel for="target_amount" value="Target amount:"/>
                                    <TextInput
                                        id="target_amount"
                                        type="number"
                                        class="mt-1  w-full bg-gray-600 text-gray-200"
                                        v-model="form.target_amount"
                                        required
                                        autocomplete="target_amount"
                                        min="1"
                                        step="0.01"
                                    />
                                    <InputError class="mt-2" :message="form.errors.target_amount"/>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ms-4">
                                        Edit
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <div class="grid grid-cols-6 gap-2 bg-gray-600 text-gray-200 rounded-lg shadow-xl p-4">
                                <h1 class="col-span-6 text-2xl">Statistics for {{ goal['name'] }}</h1>
                                <div class="col-span-3">
                                    <div
                                        class="bg-gray-700 rounded-lg p-4">
                                        <div class="grid grid-cols-1">
                                            <h1>Current amount</h1>
                                            <div>
                                                <p class="text-emerald-600 text-2xl me-1">{{
                                                        formatPrice(goal.current_amount)
                                                    }} KGS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <div
                                        class="bg-gray-700 rounded-lg p-4">
                                        <div class="grid grid-cols-1">
                                            <h1>Target amount</h1>
                                            <div>
                                                <p class="text-red-600 text-2xl me-1">{{
                                                        formatPrice(goal.target_amount)
                                                    }} KGS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-6">
                                    <div
                                        class="bg-gray-700 rounded-lg p-4">
                                        <div class="grid grid-cols-2">
                                            <h1 class="col-span-2">The remaining amount</h1>
                                            <div class="col-span-1">
                                                <div v-if="!goal['is_completed']">
                                                    <p  class="text-red-600 text-2xl me-1">{{
                                                            formatPrice(goal['target_amount'])
                                                        }} KGS</p>
                                                </div>
                                                <div v-else>
                                                    <p class="text-emerald-600 text-2xl">
                                                        The goal has been achieved
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-span-1 justify-self-end">
                                                <CircleProgress :is-bg-shadow="true" :bg-shadow="{
                                                                inset: true,
                                                                vertical: 2,
                                                                horizontal: 2,
                                                                blur: 4,
                                                                opacity: .4,
                                                                color: '#000000'}"
                                                                 :show-percent="true" :size="90" fill-color="#1d8a19"
                                                                 :percent="Math.round((goal.current_amount*100)/goal.target_amount) <=100?Math.round((goal.current_amount*100)/goal.target_amount):100"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-6">
                                    <h2>Expenses for the goal</h2>
                                        <ExpensesTable :expenses="expenses">
                                        </ExpensesTable>
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

<script>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from "vue-toast-notification";

export default {
    components: {PrimaryButton, InputError, TextInput, InputLabel, AuthenticatedLayout, Head,},

    data() {
        return {
            isEdit: false,
            form: useForm({
                name: this.category.name,
                monthly_limit: this.category.monthly_limit
            }),
            showMonthly: false,
            showYearly: false
        }
    },
    props: {
        'category': {
            type: Object,
            required: true
        }, 'categoryTotal': {
            required: true
        }, 'categoryCurrentMonthTotal': {
            required: true
        }, 'yearlyCategoryChart': {
            required: true,
            type: Object
        }
    },
    methods: {
        showEdit() {
            this.isEdit = !this.isEdit;
        },
        submit() {
            this.form.put(route('categories.update', this.category['id']), {
                onSuccess: () => {
                    const $toast = useToast();
                    let instance = $toast.success('You have successfully updated a expense category!');
                    this.isEdit = false;
                    this.form.reset();
                },
                onError: () => {
                    const $toast = useToast();
                    let instance = $toast.error('An error occurred when updating an expense category');
                }
            })
        },
        formatPrice(value) {
            if(value === "")return 0;
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
                    <h2 class="font-semibold text-2xl leading-tight">{{ category['name'] }}</h2>
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
                                    <InputLabel for="monthly_limit" value="Monthly limit for expense:"/>
                                    <TextInput
                                        id="monthly_limit"
                                        type="number"
                                        class="mt-1  w-full bg-gray-600 text-gray-200"
                                        v-model="form.monthly_limit"
                                        required
                                        autocomplete="monthly_limit"
                                        min="1"
                                        step="0.01"
                                    />
                                    <InputError class="mt-2" :message="form.errors.monthly_limit"/>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ms-4">
                                        Edit
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <div class="grid-cols-3">
                                <div class="col-span-3 text-center text-gray-200  mb-5">
                                    <div><span class="font-light text-2xl">Total Expenses</span>
                                        <br>
                                        <p class="font-bold text-4xl text-red-600">
                                            {{ formatPrice(categoryTotal) + " KGS" }}</p>
                                    </div>
                                    <div>
                                        <span class="font-light text-2xl">Expenses for this month</span>
                                        <br>
                                        <p class="font-bold text-4xl text-red-600">
                                            {{ formatPrice(categoryCurrentMonthTotal) + " KGS" }}</p>
                                    </div>
                                </div>

                                <div class="col-span-3 grid grid-cols-5 gap-2 bg-gray-600 rounded-lg shadow-xl p-10">
                                    <h2 class="font-semibold col-span-5  text-2xl text-gray-200 leading-tight text-center mb-4">
                                        Analytics</h2>
                                    <div class="col-span-5">
                                        <apexchart class="col-span-1" :width="yearlyCategoryChart.width"
                                                   :height="yearlyCategoryChart.height"
                                                   :type="yearlyCategoryChart.type"
                                                   :options="yearlyCategoryChart.options"
                                                   :series="yearlyCategoryChart.series"
                                        ></apexchart>
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

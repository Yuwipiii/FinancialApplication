<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";

defineProps(['types', 'currencies'])
const form = useForm(
    {
        name: '',
        type: '',
        currency: '',
        balance: ''
    }
);

const submit = () => {
    form.post(route('wallets.store')
    );
};

</script>
<template>
    <Head title="Wallets List"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Wallet</h2>
            </div>
        </template>

        <template #main>
            <div class="py-12">
                <div class="max-w-80 mx-auto sm:px-6 lg:px-8">
                    <form @submit.prevent="submit" class="bg-slate-800/50 rounded-lg p-3 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-8 h-8 stroke-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3"/>
                        </svg>
                        <div>
                            <InputLabel for="name" value="Wallet Name"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full bg-slate-700/50"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="mt-5">
                            <InputLabel for="type" value="Wallet Type"/>
                            <div class="flex mt-1">
                                <select id="type" class="bg-slate-700/50 rounded-lg " v-model="form.type">
                                    <option disabled value="">Select currency of wallet</option>
                                    <option v-for="(type,index) in types" :key="index" :value="type">{{type}}</option>
                                </select>
                            </div>
                            <InputError class="mt-2" :message="form.errors.type"/>
                        </div>

                        <div class="mt-5">
                            <InputLabel for="currency" value="Wallet Currency"/>
                            <div class="flex mt-1">
                                <select id="currency" class="bg-slate-700/50 rounded-lg " v-model="form.currency">
                                    <option disabled value="">Select currency of wallet</option>
                                    <option v-for="(currency,index) in currencies" :key="index" :value="currency.valueOf()">{{currency}}</option>
                                </select>
                            </div>
                            <InputError class="mt-2" :message="form.errors.currency"/>
                        </div>


                        <div>
                            <InputLabel for="balance" value="Balance"/>
                            <TextInput
                                id="balance"
                                type="number"
                                class="mt-1 block w-full bg-slate-700/50"
                                v-model="form.balance"
                                required
                                autofocus
                                autocomplete="balance"
                                min="0"
                                step="1"
                            />
                            <InputError class="mt-2" :message="form.errors.balance"/>
                        </div>


                        <div class="flex items-center justify-end mt-4">

                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                Create
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

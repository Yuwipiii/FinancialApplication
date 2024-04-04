<script>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, InputError, TextInput, InputLabel, AuthenticatedLayout, Head,},

    data() {
        return {
            isEdit: false,
            form: useForm({
                name: this.wallet['name'],
                type: ''
            })
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
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">{{ wallet['name'] }}</h2>
                    <span>{{ wallet['type'] }}</span>
                </div>
                <div>
                    <button @click="this.showEdit"
                            class="ms-2 inline-flex px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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
                            <form @submit.prevent="submit" class="bg-slate-800/50 rounded-lg p-3 ">
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
                                        class="mt-1 block w-full bg-slate-700/50"
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
                                        <select class="bg-slate-700/50 rounded-lg " v-model="form.type">
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
                            <div class="text-center">
                                <span class="font-light text-slate-500  text-2xl">Total Balance</span>
                                <br>
                                <p class="font-bold text-4xl">
                                    {{ formatPrice(this.wallet['balance']) + " KGS"}}</p>
                            </div>
                            <div>

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

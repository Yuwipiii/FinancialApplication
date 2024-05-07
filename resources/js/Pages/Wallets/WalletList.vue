<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Card from "@/Components/Card.vue";
import SimplePaginator from "@/Components/Pagination.vue";
import {useToast} from "vue-toast-notification";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";


export default {
    components: {
        InputLabel, PrimaryButton, InputError, TextInput,
        Head,
        AuthenticatedLayout,
        Card,
        SimplePaginator
    },
    data() {
        return {
            isCreate: false,
            form: useForm({
                name: '',
                type: '',
                balance: ''
            })
        }
    },
    props: {
        'wallets': {
            required: true
        },
        'types': {
            required: true
        }
    },
    methods: {
        showCreate() {
            this.isCreate = !this.isCreate;
        },
        submit() {
            this.form.post(route('wallets.store'), {
                onSuccess: () => {
                    const $toast = useToast();
                    let instance = $toast.success('You have successfully created a wallet!');
                    this.isCreate = false;
                    this.form.reset();
                },
                onError: () => {
                    const $toast = useToast();
                    let intance = $toast.error('An error occurred when creating a wallet');
                    this.isCreate = false;
                }
            })
        }
    }
}

</script>

<template>
    <Head title="Wallets List"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl  leading-tight">Wallets</h2>
                <button @click="this.showCreate">
                    <svg v-if="!isCreate === true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </template>

        <template #main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Transition name="slide-fade">
                        <div v-if="this.isCreate">
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
                                    <InputLabel for="type" value="Wallet Type"/>
                                    <div class="flex mt-1">
                                        <select id="type" class="bg-slate-700/50 rounded-lg " v-model="form.type">
                                            <option disabled value="">Select currency of wallet</option>
                                            <option v-for="(type,index) in types" :key="index" :value="type">
                                                {{ type }}
                                            </option>
                                        </select>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.type"/>
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
                        <div v-else>
                            <div class="grid grid-cols-2 gap-2">
                                <div v-for="(wallet,index) in this.wallets['data']" :key="index">
                                    <Card :balance="wallet.balance"
                                          :card-name="wallet.name" :card-type="wallet.type"
                                          :card-id="wallet.id"></Card>
                                </div>
                            </div>
                            <SimplePaginator class="flex justify-self-center"
                                             :paginator="wallets"></SimplePaginator>
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

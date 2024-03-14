<script>

import {useForm} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import  {useToast} from "vue-toast-notification";

export default {
    components: {SecondaryButton, PrimaryButton, TextInput, InputError, InputLabel, Modal},
    props: {
        wallets: {
            required: true
        },
        categories: {
            required: true
        }, currencies: {
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                wallet_id: '',
                category_id: '',
                amount: 1,
                date: '',
                currency_id: 1,
                note: ''
            }),
            showModal: false
        }
    },
    methods: {
        submit() {
            this.form.post(route('expenses.create'), {
                    onSuccess: () => {
                        const $toast = useToast();
                        this.closeModal();
                        let instance = $toast.success('You have successfully created a expense account for your wallet!');
                    },
                    onError: () => {
                        const $toast = useToast();
                        this.closeModal();
                        let intance = $toast.error('An error occurred when creating an expense');
                    }
                }
            );
        },
        closeModal(){
            this.showModal=false;
        }
    }
}
</script>

<template>
    <div
        @click="this.showModal= true"
        class="flex justify-center rounded-lg  border-2 border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50">
        Expense
    </div>
    <Modal :show="this.showModal" @close="closeModal">
        <form @submit.prevent="submit">
            <div class="grid justify-items-stretch  bg-slate-400 p-5 rounded-lg shadow-2xl">
                <h2 class="text-lg font-medium text-gray-900">Expense create</h2>
                <div class="flex flex-col gap-1">
                    <div>
                        <InputLabel for="wallet_id" value="From"/>
                        <div class="flex mt-1">
                            <select id="wallet_id" class="bg-slate-200/50 rounded-lg " v-model="form.wallet_id">
                                <option disabled value="">Select wallet</option>
                                <option v-for="(wallet,index) in wallets" :key="index" :value="wallet.id">
                                    {{ wallet.name }}
                                </option>
                            </select>
                        </div>
                        <InputError class="mt-2" :message="form.errors.wallet_id"/>
                    </div>
                    <div>
                        <InputLabel for="name" value="Type of expense"/>
                        <div class="flex mt-1">
                            <select class="bg-slate-200/50 rounded-lg " v-model="form.category_id">
                                <option disabled value="">Select expense</option>
                                <option v-for="(category,index) in categories" :key="index" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                        <InputError class="mt-2" :message="form.errors.category_id"/>
                    </div>

                    <div>
                        <InputLabel for="name" value="Currency"/>
                        <div class="flex mt-1">
                            <select class="bg-slate-200/50 rounded-lg " v-model="form.currency_id">
                                <option disabled value="">Select currency</option>
                                <option v-for="(currency,index) in currencies" :key="index" :value="currency.id">
                                    {{ currency.base }}
                                </option>
                            </select>
                        </div>
                        <InputError class="mt-2" :message="form.errors.currency_id"/>
                    </div>

                    <div>
                        <InputLabel for="date" value="Date:"/>
                        <TextInput
                            id="date"
                            type="date"
                            class="mt-1  w-full bg-slate-700/50"
                            v-model="form.date"
                            required
                            autocomplete="date"

                        />
                        <InputError class="mt-2" :message="form.errors.date"/>
                    </div>

                </div>


                <div>
                    <InputLabel for="amount" value="Amount:"/>
                    <TextInput
                        id="amount"
                        type="number"
                        class="mt-1  w-full bg-slate-700/50"
                        v-model="form.amount"
                        required
                        autocomplete="amount"
                        min="1"
                        step="0.01"
                    />
                    <InputError class="mt-2" :message="form.errors.amount"/>
                </div>

                <div>
                    <InputLabel for="note" value="Note:"/>
                    <TextInput
                        id="note"
                        type="text"
                        class="mt-1  w-full bg-slate-700/50"
                        v-model="form.note"
                        autocomplete="note"
                    />
                    <InputError class="mt-2" :message="form.errors.note"/>
                </div>
                <div class="flex mt-1">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                   :disabled="form.processing">
                        Add Expense
                    </PrimaryButton>
                    <SecondaryButton class="ml-3" @click="closeModal"> Cancel</SecondaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>

<style scoped>

</style>

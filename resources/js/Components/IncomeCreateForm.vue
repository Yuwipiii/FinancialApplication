<script>
import {useForm} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import {useToast} from "vue-toast-notification";

export default {
    components: {Modal, InputLabel, TextInput, InputError, PrimaryButton, SecondaryButton},
    props: {
        wallets: {required: true},
        incomeCategories: {required: true},
    },
    data() {
        return {
            form: useForm({
                wallet_id: '',
                income_category_id: '',
                amount: 1,
                date: '',
                note: ''
            }),
            showModal: false
        }
    }, methods: {
        submit() {
            this.form.post(route('incomes.create'), {
                onSuccess: () => {
                    const $toast = useToast();
                    this.closeModal();
                    let instance = $toast.success('You have successfully created a income account for your wallet!');
                    this.form.reset();
                },
                onError: () => {
                    const $toast = useToast();
                    let instance = $toast.error('An error occurred when creating an income');
                }
            })
        },
        closeModal() {
            this.showModal = false;
        }
    }
}

</script>

<template>
    <div
        @click="this.showModal= true"
        class="flex justify-center rounded-lg shadow-lg  bg-gray-700 text-gray-200  pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50">
        Income
    </div>
    <Modal :show="showModal" @close="closeModal" >
        <form @submit.prevent="submit">
            <div class="grid justify-items-stretch bg-slate-400 p-5 rounded-lg shadow-2xl">
                <div class="flex flex-col gap-1">
                    <div>
                        <InputLabel for="wallet_id" value="To"/>
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
                            <select class="bg-slate-200/50 rounded-lg " v-model="form.income_category_id">
                                <option disabled value="">Select income type</option>
                                <option v-for="(category,index) in incomeCategories" :key="index" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                        <InputError class="mt-2" :message="form.errors.income_category_id"/>
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
                        Add Income
                    </PrimaryButton>
                    <SecondaryButton class="ml-3" @click="closeModal"> Cancel</SecondaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>

<style scoped>

</style>

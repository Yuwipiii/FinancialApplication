<script>

import {useForm} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useToast} from "vue-toast-notification";

export default {
    components: {SecondaryButton, PrimaryButton, TextInput, InputError, InputLabel, Modal},
    props: {
        income: {
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                amount: this.income.amount,
                date: this.income.date,
                note: this.income.note
            })
        }
    },
    methods: {
        submit() {
            this.form.patch(route('incomes.update',this.income), {
                    onSuccess: () => {
                        const $toast = useToast();
                        let instance = $toast.success('You have successfully update a income account for your wallet!');
                    },
                    onError: () => {
                        const $toast = useToast();
                        let instance = $toast.error('An error occurred when updating an expense');
                    }
                }
            );
        }
    }
}
</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid justify-items-stretch">
            <h2 class="text-lg font-medium text-gray-200">Income Edit</h2>
            <div class="flex flex-col gap-1">

                <div>
                    <InputLabel for="date" value="Date:"/>
                    <TextInput
                        id="date"
                        type="date"
                        class="mt-1  w-full bg-gray-700 text-gray-200"
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
                    class="mt-1  w-full bg-gray-700 text-gray-200"
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
                    class="mt-1  w-full bg-gray-700 text-gray-200"
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
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>

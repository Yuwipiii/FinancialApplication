<script setup>
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from 'vue-toast-notification';



defineProps(['from_wallets', 'to_wallets', 'currencies'])
const form = useForm(
    {
        from_wallet_id: '',
        to_wallet_id: '',
        amount: '1',
        date: '',
        currency_id: '',
        note: ''
    }
);

const submit = () => {
    form.post(route('transfers.create'), {
            onSuccess: () => {
                const $toast = useToast();
                let instance = $toast.success('You have successfully created a transfer!');
            },
            onError: () => {
                const $toast = useToast();
                let intance = $toast.error('An error occurred when creating an transfer');
            }
        }
    );
};


</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid justify-items-stretch mt-3 pe-1 ps-1 bg-slate-400 pt-2 pb-2 rounded-lg shadow-2xl">
            <div class="flex flex-col gap-1">
                <div>
                    <InputLabel for="wallet_id" value="From"/>
                    <div class="flex mt-1">
                        <select id="wallet_id" class="bg-slate-200/50 rounded-lg " v-model="form.from_wallet_id">
                            <option disabled value="">Select wallet</option>
                            <option v-for="(from_wallet,index) in from_wallets" :key="index" :value="from_wallet.id">
                                {{ from_wallet.name }}
                            </option>
                        </select>
                    </div>
                    <InputError class="mt-2" :message="form.errors.from_wallet_id"/>
                </div>

                <div v-if="form.from_wallet_id">
                    <InputLabel for="wallet_id" value="To"/>
                    <div class="flex mt-1">
                        <select id="wallet_id" class="bg-slate-200/50 rounded-lg" v-model="form.to_wallet_id">
                            <option disabled value="">Select wallet</option>
                            <template v-for="(to_wallet,index) in to_wallets">
                                <option v-if="to_wallet.id !== form.from_wallet_id" :key="index" :value="to_wallet.id">
                                    {{ to_wallet.name }}
                                </option>
                            </template>
                        </select>
                    </div>
                    <InputError class="mt-2" :message="form.errors.to_wallet_id"/>
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
            </div>
        </div>

    </form>
</template>

<style scoped>

</style>

<script setup>
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps(['wallets', 'categories', 'currencies'])
const form = useForm(
    {
        wallet_id: '',
        category_id: '',
        amount: '',
        date: '',
        currency: '',
        note: ''
    }
);

const submit = () => {
    form.post(route('expenses.create')
    );
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid justify-items-stretch mt-3 ps-3 pe-3  bg-slate-400 pt-2 pb-2 rounded-lg shadow-2xl">
            <div class="flex justify-items-stretch gap-4">
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
                            <option disabled value="">Select wallet</option>
                            <option v-for="(category,index) in categories" :key="index" :value="categories.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <InputError class="mt-2" :message="form.errors.category_id"/>
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
                    <InputError class="mt-2" :message="form.errors.amount"/>
                </div>
                <div class="flex mt-1">
                    <PrimaryButton  :class="{ 'opacity-25': form.processing }"
                                   :disabled="form.processing">
                        Add Expense
                    </PrimaryButton>
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
                    step="1"
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
                    required
                    autocomplete="note"
                />
                <InputError class="mt-2" :message="form.errors.note"/>
            </div>


        </div>
    </form>
</template>

<style scoped>

</style>

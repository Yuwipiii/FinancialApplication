<script >
import {useForm} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useToast} from "vue-toast-notification";

export default {
    components:{SecondaryButton, PrimaryButton, TextInput, InputError, InputLabel, Modal},
    props:{
        from_wallets:{required:true},
        to_wallets:{required: true},
        currencies:{required:true}
    },
    data(){
        return {
            form:useForm({
                from_wallet_id:"",
                to_wallet_id:"",
                amount:'1',
                date:'',
                currency_id:'',
                note:''
            }),
            showModal:false
        }
    },methods:{
        submit(){
            this.form.post(route('transfers.create'), {
                    onSuccess: () => {
                        const $toast = useToast();
                        this.showModal=false;
                        let instance = $toast.success('You have successfully created a transfer!');
                    },
                    onError: () => {
                        const $toast = useToast();
                        this.showModal=false;
                        let intance = $toast.error('An error occurred when creating an transfer');
                    }
                }
            );
        },closeModal(){
            this.showModal=false;
        }
    }
}


</script>

<template>
    <div
        @click="this.showModal= true"
        class="flex justify-center rounded-lg  border-2 border-slate-400 pt-4 pb-4 hover:scale-95 hover:bg-slate-400/50">
        Transfer
    </div>
    <Modal :show="showModal" @close="closeModal">
        <form @submit.prevent="submit">
            <div class="grid justify-items-stretch  p-5 bg-slate-400  rounded-lg shadow-2xl">
                <h2 class="text-lg font-medium text-gray-900">Expense create</h2>
                <div class="flex flex-col gap-1">
                    <div>
                        <InputLabel for="wallet_id" value="From"/>
                        <div class="flex mt-1">
                            <select id="wallet_id" class="bg-slate-200/50 rounded-lg " v-model="form.from_wallet_id">
                                <option disabled value="">Select wallet</option>
                                <option v-for="(from_wallet,index) in from_wallets" :key="index"
                                        :value="from_wallet.id">
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
                                    <option v-if="to_wallet.id !== form.from_wallet_id" :key="index"
                                            :value="to_wallet.id">
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
                    <SecondaryButton class="ml-3" @click="closeModal"> Cancel</SecondaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>

<style scoped>

</style>

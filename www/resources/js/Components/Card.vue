<template>
    <div @click="showWallet">
        <div class="card group/item  bg-gray-600 hover:bg-gray-500 drop-shadow-lg">
            <div class="flex flex-col mb-3">
                <div class="flex justify-between text-gray-200">
                    <strong class="card-name">{{ cardName.charAt(0).toUpperCase() + cardName.slice(1) }}</strong>
                    <div class="group/edit invisible  group-hover/item:visible">
                        <DangerButton @click.stop="confirmDelete">
                            <svg class=" w-4 h-4 group-hover/edit:translate-x-0.0" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </DangerButton>

                    </div>
                </div>
                <span class="card-type  text-gray-200">Type: {{ cardType }}</span>
            </div>
            <div>
                <div class="card-info text-end text-gray-200">
                    <p><strong class="label text-xl">Balance:</strong> {{ formatPrice(balance) + " KGS" }}
                    </p>
                </div>
            </div>
            <Modal :show="this.showDeleteModal" @close="closeDeleteModal">
                <div class="p-6 bg-gray-600">
                    <h2 class="text-lg font-medium text-gray-200">Are you sure you want to delete your
                        wallet
                        ?</h2>

                    <p class="mt-1 text-sm text-gray-200">
                        After deleting the wallet, the entire expense history and data associated with the
                        wallet will be permanently lost
                    </p>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeDeleteModal"> Cancel</SecondaryButton>

                        <DangerButton
                            class="ms-3"
                            @click="deleteWallet"
                        >Confirm
                        </DangerButton>
                    </div>
                </div>
            </Modal>
        </div>
    </div>
</template>

<script>
import TextInput from "./TextInput.vue";
import Modal from "./Modal.vue";
import DangerButton from "./DangerButton.vue";
import SecondaryButton from "./SecondaryButton.vue";
import InputError from "./InputError.vue";
import InputLabel from "./InputLabel.vue";
import {router} from "@inertiajs/vue3";
import PrimaryButton from "./PrimaryButton.vue";
import {useToast} from "vue-toast-notification";


export default {
    components: {PrimaryButton, InputLabel, InputError, SecondaryButton, DangerButton, Modal, TextInput},
    data() {
        return {
            showDeleteModal: false
        }
    },
    props: {
        cardId: {
            type: Number,
            required: true
        },
        cardName: {
            type: String,
            required: true
        },
        cardType: {
            type: String,
            required: true
        },
        balance: {
            type: Number,
            required: true
        },
    },
    methods: {
        confirmDelete() {
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        },
        deleteWallet() {
            router.delete(route('wallets.destroy', this.cardId), {
                onSuccess: () => {
                    this.closeDeleteModal();
                    const $toast = useToast();
                    let instance = $toast.success('You have successfully deleted a wallet!');
                },
                onError: () => {
                    const $toast = useToast();
                    let instance = $toast.error('An error occurred when deleted a wallet');
                },
            })
        },
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        },
        showWallet() {
            router.get(route('wallets.show', this.cardId))
        }
    }
};

</script>

<style scoped>
.card {
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    color: black;
}


.label {
    font-weight: bold;
}
</style>



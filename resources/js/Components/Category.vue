<template>
    <div @click="showCategory" >
        <div class="card group/item  bg-slate-800/50 hover:bg-stone-400 drop-shadow-lg">
            <div class="flex flex-col mb-3">
                <div class="flex justify-between">
                    <strong class="card-name">{{ categoryName.charAt(0).toUpperCase() + categoryName.slice(1) }}</strong>
                    <div class="group/edit invisible  group-hover/item:visible">
                        <DangerButton  @click.stop="confirmDelete">
                            <svg class=" w-4 h-4 group-hover/edit:translate-x-0.0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </DangerButton>

                    </div>


                    <Modal :show="this.showDeleteModal" @close="closeDeleteModal">
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">Are you sure you want to delete category expense
                                ?</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                After deleting the category, the entire expense history and data associated with the
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
            <div>
                <div class="card-info text-end">
                    <p><strong class="label">Monthly limit of category expense:</strong> {{ formatPrice(categoryMonthlyLimit) + " " + categoryCurrency.base}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {router} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";


export default {
    components: {PrimaryButton, InputLabel, InputError, SecondaryButton, DangerButton, Modal, TextInput},
    data() {
        return {
            showDeleteModal: false
        }
    },
    props: {
        categoryId: {
            type: Number,
            required: true
        },
        categoryName: {
            type: String,
            required: true
        },
        categoryMonthlyLimit:{
            type:Number,
            required:true
        },
        categoryCurrency:{
            required:true
        }
    },
    methods: {
        confirmDelete() {
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        },
        deleteWallet() {
            router.delete(route('categories.destroy', this.categoryId), {
                onSuccess: () => this.closeDeleteModal(),
            })
        },
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        },
        showCategory() {
            router.get(route('categories.show', this.categoryId))
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

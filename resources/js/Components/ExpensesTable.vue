<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import {router} from "@inertiajs/vue3";
import ExpenseEditForm from "@/Components/ExpenseEditForm.vue";

export default {
    components: {ExpenseEditForm, PrimaryButton, SecondaryButton, DangerButton, Modal},
    props: {
        expenses: {required: true}
    },
    data() {
        return {
            showDeleteModal: false,
            showEditModal: false,
            showExpenseModal: false
        }
    }, methods: {
        confirmDelete() {
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        }, closeExpenseModal() {
            this.showExpenseModal = false;
        },
        deleteIncome(id) {
            router.delete(route('expenses.destroy', id), {
                onSuccess: () => this.closeDeleteModal(),
            })
        }, showExpense() {
            this.showExpenseModal = true;
        }
    }
}
</script>

<template>
    <div class="mt-4">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-400">
                <thead
                    class="text-xs uppercase bg-slate-400 text-black">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        From
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(expense,index) in this.expenses" :key="index" @click="showExpense()"
                    class="grid-cols-5 border-b bg-gray-200 text-black  hover:bg-gray-200">
                    <th scope="row"
                        class="col-span-1 px-6 py-4 font-medium  whitespace-nowrap ">
                        {{ expense['wallet']['name'] }}
                    </th>
                    <td class="col-span-1 px-6 py-4 font-medium  whitespace-nowrap ">
                        {{ expense['date'] }}
                    </td>
                    <td class="col-span-1 px-6 py-4" v-if="expense['category'] == null">
                        Other
                    </td>
                    <td class="col-span-1 px-6 py-4" v-else>
                        {{ expense['category']['name'] }}
                    </td>
                    <td class="col-span-1 px-6 py-4">
                        {{ expense['amount'] + " KGS" }}
                    </td>
                    <td class="col-span-1 px-6 py-4 text-start">
                        <button @click.stop="confirmDelete"
                                class="font-medium text-gray-900 bg-red-700 rounded-lg p-2 hover:bg-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                        <Modal :show="this.showDeleteModal" @close="closeDeleteModal">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900">Are you sure you want to delete expense
                                    ?</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    After deleting the income, the entire income history and data associated with the
                                    wallet will be permanently lost
                                </p>
                                <div class="mt-6 flex justify-end">
                                    <SecondaryButton @click="closeDeleteModal"> Cancel</SecondaryButton>
                                    <DangerButton
                                        class="ms-3"
                                        @click="deleteIncome(expense['id'])"
                                    >Confirm
                                    </DangerButton>
                                </div>
                            </div>
                        </Modal>
                        <Modal :show="this.showExpenseModal" @close="closeExpenseModal">
                            <div class="p-6">
                                <div class="bg-gray-300 rounded-xl p-3">
                                    <h2 class="text-2xl ">Note for expense</h2>
                                    <div v-if="expense['note'] === null">
                                        There are no notes
                                    </div>
                                    <div v-else>
                                        {{ expense['note'] }}
                                    </div>
                                </div>
                                <div class="mt-4 bg-gray-300 rounded-xl p-3">
                                    <ExpenseEditForm :expense="expense"></ExpenseEditForm>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <SecondaryButton @click="closeExpenseModal" >Cancel</SecondaryButton>
                                </div>
                            </div>
                        </Modal>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>

<script>
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {router} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, SecondaryButton, DangerButton, Modal},
    props: {
        incomes: {required: true}
    },
    data() {
        return {
            showDeleteModal: false,
            showEditModal: false
        }
    }, methods: {
        confirmDelete() {
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        },
        deleteIncome(id) {
            router.delete(route('incomes.destroy', id), {
                onSuccess: () => this.closeDeleteModal(),
            })
        }, closeEditModal() {
            this.showEditModal = false;
        }, confirmEditModal() {
            this.showEditModal = true;
        }
    }

}
</script>

<template>
    <div class="mt-4">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full table-fixed text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        To
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
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(income,index) in this.incomes" :key="index"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ income['wallet']['name'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ income['date'] }}
                    </td>
                    <td class="px-6 py-4" v-if="income['income_category'] === null">
                        Other
                    </td>
                    <td class="px-6 py-4" v-else>
                        {{ income['income_category']['name'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ income['amount'] + " " + income['currency']['base'] }}
                    </td>
                    <td class="px-6 py-4 text-right grid grid-cols-2 gap-1">
                        <button @click.stop="confirmDelete"
                                class="font-medium text-gray-900 bg-red-700      rounded-lg p-2 ark:text-white hover:underline">
                            Delete
                        </button>
                        <Modal :show="this.showDeleteModal" @close="closeDeleteModal">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900">Are you sure you want to delete income
                                    ?</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    After deleting the income, the entire income history and data associated with the
                                    wallet will be permanently lost
                                </p>
                                <div class="mt-6 flex justify-end">
                                    <SecondaryButton @click="closeDeleteModal"> Cancel</SecondaryButton>
                                    <DangerButton
                                        class="ms-3"
                                        @click="deleteIncome(income['id'])"
                                    >Confirm
                                    </DangerButton>
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

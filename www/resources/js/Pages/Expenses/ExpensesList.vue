<script>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import ExpensesTable from "../../Components/ExpensesTable.vue";

export default {
    components: {
        ExpensesTable,
        AuthenticatedLayout,

    }, props: {
        'expenses': {
            required: true
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-2xl  leading-tight">Expenses List</h2>
                </div>
            </div>
        </template>
        <template #main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-3">
                        <ExpensesTable :expenses="expenses"></ExpensesTable>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import IncomesTable from "@/Components/IncomesTable.vue";

export default {
    components: {
        IncomesTable,
        AuthenticatedLayout,

    }, props: {
        'incomes': {
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
                    <h2 class="font-semibold text-2xl leading-tight">Incomes List</h2>
                </div>
            </div>
        </template>
        <template #main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-3">
                        <IncomesTable :incomes="incomes"></IncomesTable>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>

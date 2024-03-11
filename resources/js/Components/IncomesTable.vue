<script setup>
defineProps(['incomes'])
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
                <tr v-for="(income,index) in this.incomes" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{income['wallet']['name']}}
                    </td>
                    <td class="px-6 py-4">
                        {{income['date']}}
                    </td>
                    <td class="px-6 py-4">
                        {{income['income_category']['name']}}
                    </td>
                    <td class="px-6 py-4">
                        {{income['amount'] + " " + income['currency']['base']}}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="#"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>

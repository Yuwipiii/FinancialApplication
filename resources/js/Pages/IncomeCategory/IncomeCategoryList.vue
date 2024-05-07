<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import SimplePaginator from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {useToast} from "vue-toast-notification";
import IncomeCategory from "@/Components/IncomeCategory.vue";

export default {
    components: {
        IncomeCategory,
        InputError,
        TextInput,
        InputLabel,
        PrimaryButton,
        Head,
        AuthenticatedLayout,
        SimplePaginator
    },
    data() {
        return {
            isCreate: false,
            form: useForm({
                name: '',
            })
        }
    },
    props: {
        'incomeCategories': {
            required: true
        }
    },
    methods: {
        showCreate() {
            this.isCreate = !this.isCreate;
        },
        submit() {
            this.form.post(route('incomeCategories.store'), {
                onSuccess: () => {
                    const $toast = useToast();
                    let instance = $toast.success('You have successfully created a income category!');
                    this.isCreate = false;
                    this.form.reset();
                },
                onError: () => {
                    const $toast = useToast();
                    let intance = $toast.error('An error occurred when creating an income category');
                }
            })
        }
    }
}


</script>

<template>
    <Head title="Income category"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl  leading-tight">Income category</h2>
                <button @click="this.showCreate">
                    <svg v-if="!isCreate === true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>

        <template #main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Transition name="slide-fade">
                        <div v-if="this.isCreate">
                            <form @submit.prevent="submit" class="bg-slate-800/50 rounded-lg p-3 ">
                                <h1 class="block font-medium text-2xl">Create new income category</h1>
                                <div>
                                    <InputLabel for="name" value="Income category name"/>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full bg-slate-700/50"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                    <InputError class="mt-2" :message="form.errors.name"/>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ms-4">
                                        Create
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <div class="grid grid-cols-2 gap-2">
                                <div v-for="(incomeCategory,index) in this.incomeCategories['data']" :key="index">
                                    <IncomeCategory :category-name="incomeCategory.name"
                                                    :category-id="incomeCategory.id"></IncomeCategory>
                                </div>
                            </div>
                            <SimplePaginator class="flex justify-self-center"
                                             :paginator="incomeCategories"></SimplePaginator>
                        </div>

                    </Transition>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
<style>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>

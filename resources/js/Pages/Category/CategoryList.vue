<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import SimplePaginator from "@/Components/Pagination.vue";
import Category from "@/Components/Category.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {useToast} from "vue-toast-notification";

export default {
    components: {
        InputError,
        TextInput,
        InputLabel,
        PrimaryButton,
        Head,
        AuthenticatedLayout,
        Category,
        SimplePaginator
    },
    data() {
        return {
            isCreate: false,
            form: useForm({
                name: '',
                monthly_limit:1
            })
        }
    },
    props: {
        'categories': {
            required: true
        }
    },
    methods: {
        showCreate() {
            this.isCreate = !this.isCreate;
        },
        submit(){
            this.form.post(route('categories.store'),{
                onSuccess: () => {
                    const $toast = useToast();
                    let instance = $toast.success('You have successfully created a expense category!');
                    this.isCreate= false;
                    this.form.reset();
                },
                onError: () => {
                    const $toast = useToast();
                    let instance = $toast.error('An error occurred when creating an expense category');
                }
            })
        }
    }
}


</script>

<template>
    <Head title="Expense category"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl leading-tight">Expense Category</h2>
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
                                <h1 class="block font-medium text-2xl">Create new expense category</h1>
                                <div>
                                    <InputLabel for="name" value="Expense category name"/>
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
                                <div>
                                    <InputLabel for="monthly_limit" value="Monthly limit for expense:"/>
                                    <TextInput
                                        id="monthly_limit"
                                        type="number"
                                        class="mt-1  w-full bg-slate-700/50"
                                        v-model="form.monthly_limit"
                                        required
                                        autocomplete="monthly_limit"
                                        min="1"
                                        step="0.01"
                                    />
                                    <InputError class="mt-2" :message="form.errors.monthly_limit"/>
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
                                <div v-for="(category,index) in this.categories['data']" :key="index">
                                    <Category :category-monthly-limit="category.monthly_limit"
                                              :category-name="category.name"
                                              :category-id='category.id'></Category>
                                </div>
                            </div>
                            <SimplePaginator class="flex justify-self-center"
                                             :paginator="categories"></SimplePaginator>
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

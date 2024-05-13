<template>
    <div @click="showGoal">
        <div class="card group/item bg-gray-600 text-gray-200 hover:bg-gray-500 drop-shadow-lg">
            <div class="grid grid-cols-2  mb-3">
                <div class="col-span-1 mb-2">
                    <strong
                        class="card-name text-2xl text-start text-gray-200">{{ goal.name.charAt(0).toUpperCase() + goal.name.slice(1) }}</strong>
                </div>
                <div class="col-span-1 place-self-end group/edit invisible  group-hover/item:visible mb-2">
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
                <div class="col-span-2 lg:col-span-1 text-gray-200 hidden sm:block text-start">
                    <div><strong>Accumulated:</strong>{{ goal.current_amount }} KGS</div>
                    <div><strong>Required:</strong>
                        {{ goal.target_amount }} KGS
                    </div>
                </div>
                <div class="col-span-2 lg:col-span-1 place-self-end">
                    <circle-progress :is-bg-shadow="true"
                                     :bg-shadow="{
                        inset: true,
                        vertical: 2,
                        horizontal: 2,
                        blur: 4,
                        opacity: .4,
                         color: '#0000',
                        }" :show-percent="true" :size="90" fill-color="#059669"
                                     :percent="Math.round((goal.current_amount*100)/goal.target_amount) <=100?Math.round((goal.current_amount*100)/goal.target_amount):100"/>
                </div>
            </div>
        </div>
        <Modal :show="this.showDeleteModal" @close="closeDeleteModal">
            <div class="p-6 bg-gray-600 text-gray-200">
                <h2 class="text-lg font-medium">Are you sure you want to delete goal
                    ?</h2>

                <p class="mt-1 text-sm">
                    After deleting the goal, the entire expense history and data associated with the
                    goal will be permanently lost
                </p>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeDeleteModal"> Cancel</SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        @click="deleteGoal"
                    >Confirm
                    </DangerButton>
                </div>
            </div>
        </Modal>
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
import "vue3-circle-progress/dist/circle-progress.css";
import CircleProgress from "vue3-circle-progress";
import {useToast} from "vue-toast-notification";


export default {
    components: {
        PrimaryButton,
        InputLabel,
        InputError,
        SecondaryButton,
        DangerButton,
        Modal,
        TextInput,
        CircleProgress
    },
    data() {
        return {
            showDeleteModal: false,
        }
    },
    props: {
        goal: {
            required: true
        }
    },
    methods: {
        confirmDelete() {
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        },
        deleteGoal() {
            router.delete(route('goals.destroy', this.goal.id), {
                onSuccess: () => {
                    this.closeDeleteModal();
                    const $toast = useToast();
                    let instance = $toast.success('You have successfully deleted a goal!');
                },
                onError: () => {
                    const $toast = useToast();
                    let instance = $toast.error('An error occurred when deleted a goal');
                },
            })
        },
        showGoal() {
            router.get(route('goals.show', this.goal.id))
        }
    }
};

</script>

<style lang="scss">
.card {
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    color: black;
}

.current-counter {
    &::after {
        content: "%";
    }
    color: #e5e7eb;
}

</style>

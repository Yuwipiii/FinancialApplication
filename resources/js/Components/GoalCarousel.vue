<template>
    <div v-if="goals.length === 0">
        <div class="card group/item bg-gray-200 p-5">
            <h2 class="font-semibold text-2xl  text-gray-800 leading-tight text-center mb-4">
                Goals</h2>
            <p class="text-2xl text-center">
                <p>You don't have any goals yet</p>
            </p>
            <button @click="createGoal" class="bg-green-600 mt-5 px-4 py-2 rounded-full w-full mb-15">
                Create goal
            </button>
        </div>
    </div>
    <div v-else>
        <h2 class="font-semibold text-2xl  text-gray-800 leading-tight text-center mb-4">
            Goals</h2>
        <Carousel>
            <Slide v-for="goal in goals" :key="goal">
                <div class="carousel__item">
                    <Goal :goal="goal"></Goal>
                </div>
            </Slide>
            <template #addons>
                <Navigation/>
                <Pagination/>
            </template>
        </Carousel>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {Carousel, Navigation, Pagination, Slide} from 'vue3-carousel'

import 'vue3-carousel/dist/carousel.css'
import Goal from "@/Components/Goal.vue";
import {router} from "@inertiajs/vue3";

export default defineComponent({
    props: {
        'goals': {
            required: true
        }
    },
    components: {
        Goal,
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    methods:{
        createGoal(){
            router.get(route('goals.index'));
        }
    }
})
</script>

<style>
.carousel__item {
    min-height: 200px;
    width: 100%;
    font-size: 20px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.carousel__slide {
    padding: 10px;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
}
</style>

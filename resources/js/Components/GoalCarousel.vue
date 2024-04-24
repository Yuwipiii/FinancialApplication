<template>
    <Carousel>
        <Slide v-for="goal in goals" :key="goal">
            <div class="carousel__item">
                <Goal :goal="goal"></Goal>
            </div>
        </Slide>

        <template #addons>
            <Navigation />
            <Pagination />
        </template>
    </Carousel>
</template>

<script>
import { defineComponent } from 'vue'
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'

import 'vue3-carousel/dist/carousel.css'
import Goal from "@/Components/Goal.vue";

export default defineComponent({
    props:{
      'goals':{
          required:true
      }
    },
    components: {
        Goal,
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
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

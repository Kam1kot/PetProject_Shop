<script setup>
    import {Swiper, SwiperSlide} from 'swiper/vue'
    import {Autoplay, Navigation} from 'swiper/modules'
    import ProductCard from './productCard.vue'

    import 'swiper/css';
    import 'swiper/css/navigation';
    // import 'swiper/css/pagination';

    const hitProps = defineProps({
        products: Array
    })
    const modules = [Navigation, Autoplay];
    // console.log(hitProps.products)
    const emit = defineEmits(['change-page']);
</script>

<template>
    <div class="swiper">
        <h3>Посмотрите наши рекомендации!</h3>
        <swiper
            :modules="modules"
            :slides-per-view="3"
            :space-between="20"
            :navigation="true"
            :autoplay="{ delay: 5000 }"
        >
            <swiper-slide v-for="product in products" :key="product.id">
                <ProductCard :product="product" />
            </swiper-slide>
        </swiper>
    </div>
</template>
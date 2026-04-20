<script setup>
import Layout from '../Layouts/Main.vue'
import {Swiper, SwiperSlide} from 'swiper/vue'
import {Autoplay, Navigation} from 'swiper/modules'
import { Head, Link } from '@inertiajs/vue3'
import productCard from '../../Components/productCard.vue'
import 'swiper/css';
import 'swiper/css/navigation';

const modules = [Navigation, Autoplay];

const productProp = defineProps({ 
    product: Object,
    otherTagProducts: Array,
    otherBrandProducts: Array
})
// console.log('Страница продукта: ',productProp.product)
// console.log('Страница продукта: ',productProp.otherTagProducts)
// console.log('Страница продукта: ',productProp.otherBrandProducts)
// console.log('Рейтинг продукта: ',productProp.product.rating_avg)

const getStarClass = (n, product = productProp.product) => {
  if (n <= product.rating_avg) return 'fa-solid fa-star';
  if (n - 1 < product.rating_avg && product.rating_avg < n) return 'fa-solid fa-star-half-stroke';
  return 'fa-regular fa-star';
};
const getColorRating = (rating) => {
    switch (true) {
        case rating == 5:
            return `star-green`
        case rating < 5 && rating >= 4:
            return `star-greenyellow`
        case rating < 4 && rating >= 3:
            return `star-yellow`
        case rating < 3 && rating >= 2:
            return `star-orange`
        case rating < 2 && rating >= 0:
            return `star-red` 
        default:
            return `star-red`
    }
}
</script>

<template>
    <Layout>
        <Head :title="product.name ?? 404" />
        <main>
            <div class="product-wrapper">
                <span class="breadcrumb">
                    <Link :href="`/`">Главная / </Link>
                    <Link :href="`/catalog/${product.category.slug}`">{{product.category.name }} / </Link>
                    <Link :href="`/product/${product.id}`">{{product.name}}</Link>
                </span>
                <div class="product-container">
                    <div class="image-column">
                        <div class="main-image"></div>
                        <div class="image-slider">
                            <div>1</div>
                            <div>2</div>
                            <div>3</div>
                            <div>4</div>
                        </div>
                    </div>
                    <div class="info-column">
                        <h3>{{ product.name }}</h3>

                        <div class="product-skuRate">
                            <p>Артикул: <span>{{ product.sku ?? 'Отсутсвует' }} </span></p>
                            <div class="rating">
                                <span>{{ product.rating_avg }}</span>
                                <div :class="getColorRating(product.rating_avg)">
                                    <i v-for="n in 5" :key="n" :class="getStarClass(n)">
                                    </i>
                                </div>
                                <span>Отзывы: {{ product.reviews_count }}</span>
                            </div>
                        </div>

                        <div class="product-info">
                            <span class="prouduct-brand">Бренд: <Link :href="`/brand/${product.brand.name}`">{{ product.brand.name }}</Link></span> <br />
                            <div class="product-tags">
                                <span v-for="n in product.tags">{{n.name}}</span> <br />
                            </div>
                            <hr />
                            <p>{{ product.description }}</p>
                        </div>

                        <div class="product-price">
                            <i v-if="product.price > product.old_price && product.old_price" class="fa-solid fa-arrow-up-long"></i>
                            <i v-else-if="product.price < product.old_price && product.old_price" class="fa-solid fa-arrow-down-long"></i>
                            <span class="current-price">{{ product.price }} ₽</span>
                            <span v-if="product.old_price" class="old-price">{{ product.old_price }} ₽</span>
                        </div>

                        <div class="product-actions">
                            <button>
                                Добавить в избранное
                            </button>
                            <button>
                                Добавить в корзину
                            </button>
                            <button> 
                                Купить в 1 клик
                            </button>
                        </div>
                    </div>
                </div>
                <div class="otherTag-products">
                    <h3>Товары от этого же бренда:</h3>
                    <div v-if="loadingPage">
                        <div class="skeleton-list">
                            <article class="skeleton-card" v-for="n in 8"></article>
                        </div>
                    </div>
                    <div v-else class="swiper swiperUndProd">
                        <swiper
                            :modules="modules"
                            :slides-per-view="4"
                            :autoplay = "{delay: 5000}"
                            :space-between="20"
                            :navigation="true"
                        >
                            <swiper-slide v-for="brandProduct in otherBrandProducts" :key="brandProduct.id">
                                <productCard :product="brandProduct" />
                            </swiper-slide>
                        </swiper>
                    </div>
                </div>
                <div class="otherBrand-products">
                    <h3>Похожие продукты:</h3>
                    <div v-if="loadingPage">
                        <div class="skeleton-list">
                            <article class="skeleton-card" v-for="n in 8"></article>
                        </div>
                    </div>
                    <div v-else class="swiper swiperUndProd">
                        <swiper
                            :modules="modules"
                            :slides-per-view="4"
                            :autoplay = "{delay: 5000}"
                            :space-between="20"
                            :navigation="true"
                        >
                            <swiper-slide v-for="tagProduct in otherTagProducts" :key="tagProduct.id">
                                <productCard :product="tagProduct" />
                            </swiper-slide>
                        </swiper>
                    </div>
                </div>
            </div>
        </main>
    </Layout>
</template>

<style>
hr {
    margin-bottom: 0.2rem;
    width: 100%;
    border: 1px solid black;
}
.product-wrapper {
    display: block;
    justify-content: flex-start;
    align-items: center;

    width: 60%;
    margin: 3.5rem auto 0;
    padding: 1.5rem 0;
}
.breadcrumb {
    display: inline-block;
    align-items: center;
    color: black
}
.breadcrumb a:last-child {
    color: gray !important;
}
.product-container {
    display: grid;
    grid-template-columns: 55% 45%;
}
.product-container h3{
    margin-top: 1.5rem;
}
.product-container h3 {
    font-weight: 500;
    font-size: 2.65em;
}
.product-container > div {
    padding: 1.5rem;
}
.product-skuRate {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.rating {
    display: inline-flex;
    align-items: center;
}
.rating span {
    padding: 0 10px;
    font-size: 1.15em;
}
.product-info {
    margin-top: 3rem;
}
.product-tags {
    margin: 0.5rem 0;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
}
.product-tags span {
    border: 1px solid gray;
    border-radius: 4px;
    padding: 0 4px;
}
.fa-arrow-up-long {
    font-size: 2em;
    color: red;
}
.fa-arrow-down-long {
    font-size: 2em;
    color: greenyellow;
}
.product-price {
    display: flex;
    align-items: center;
    margin-top: 2rem;
}
.product-price .current-price {
    font-weight: 600;
    font-size: 2.5em;
    letter-spacing: 2px;
}
.product-price .old-price {
    margin-bottom: auto;
    text-decoration: line-through;
    margin-left: 0.5rem;
    font-size: 1.5em;
    color: gray;
}
.product-actions {
    display: flex;
    gap: auto;
    align-items: center;
    justify-content: space-between;
}
.product-actions button {
    border: 1px solid black;
    border-radius: 4px;
    padding: 4px 4px;

    color: black;
    font-size: 1.05em;
    background-color: darkgrey;
}
.product-actions button:last-child {
    background-color: bisque;
}
.fa-star,
.fa-star-half-stroke {
    opacity: 70%;
    -webkit-text-stroke: 1px black;
}
.star-red{
    color: red;
}
.star-orange {
    color: orange
}
.star-yellow{
    color: yellow
}
.star-greenyellow {
    color: greenyellow
}
.star-green {
    color: green
}
.image-column {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 100%;
    overflow: hidden;
}
.main-image {
    border: 1px solid black;
    padding: 1rem;
    width: 100%;
    height: 80%;
}
.image-slider {
    width: 100%;
    display: flex;
    gap: 15px;
    overflow-x: auto;
    padding: 0.5rem;
    height: 20%;
}
.image-slider div {
    height: 100%;
    flex: 0 0 8rem;
    border: 1px solid black;
    scroll-snap-align: center;
}
.swiperUndProd .swiper-button-prev,
.swiperUndProd .swiper-button-next
{
    z-index: 999998;
    background-color: white;
    padding: 0.5rem;
    border-radius: 50%;
    color: black;
    opacity: 0;
    transition: 0.2s all;
}
.swiperUndProd:hover .swiper-button-prev,
.swiperUndProd:hover .swiper-button-next {
    opacity: 1;
}
.swiperUndProd .swiper-button-prev.swiper-button-disabled,
.swiperUndProd .swiper-button-next.swiper-button-disabled {
    pointer-events: auto !important; 
    cursor: not-allowed;
    
    background-color: #f0f0f0;
    color: #ccc;
    opacity: 0;
}
.swiperUndProd:hover .swiper-button-disabled {
    background-color: #f0f0f0 !important;
    opacity: 0.5 !important;
}
</style>
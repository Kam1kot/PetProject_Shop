<script setup>
    import {Link} from '@inertiajs/vue3' 
    defineProps({
        product: Object,
        otherProducts: Object
    })  
    const formatRating = (ratingAvg) => {
        if (ratingAvg == 0) {return 'Нет рейтинга'}
        else return ratingAvg
    }
    const colorRating = (rating) => {
        switch (true) {
            case rating < 2:
                return 'star-red' 
            case 2 <= rating && rating < 3:
                return 'star-orange' 
            case 3 <= rating && rating < 4:
                return 'star-yellow' 
            case 4 <= rating && rating < 5:
                return 'star-greenyellow'      
            case rating === 5:
                return 'star-green'      
            default:
                return 'star-no';
        }
    }
    const formatReviewCount = (reviewCount) => {
        var countLen = reviewCount.toString().length;
        if (reviewCount > 999) {
            return ('( ' + reviewCount.toString().substring(0,countLen-3) + ',' + (reviewCount % 10) + ' тыс. Отзывов )')
        } else if (reviewCount == 0) {
            return 'Нет отзывов'
        } else return "( " + reviewCount + " Отзывов )"
    }
</script>

<template>
    <Link class="link-product" :href="`/product/${product.id }`">
        <article class="card-product">
            <div class="card_image-wrapper">
                <span>{{ product.category?.name }}</span>
                <img src="" alt="">
            </div>
            <div class="card_info">
                <span class="card-productTitle">{{product.name}}</span>
            </div>
            <div class="card-reviewLine">
                {{ formatRating(product.rating_avg) }}
                <i class="fa-solid fa-star" :class="colorRating(product.rating_avg)"></i>
                <span class="card-reviewCount">{{ formatReviewCount(product.reviews_count) }}</span>
                <span class="card-price">{{product.price}} ₽</span>
            </div>
            <div class="card_actions-buttons">
                <form method="POST" action="">
                    <button class="cardAdd addWishlist"><span><i class="fa-solid fa-plus"></i></span> В избранное</button>
                </form>
                <form method="POST" action="">
                    <button class="cardAdd addCart"><span><i class="fa-solid fa-plus"></i></span> В корзину</button>
                </form>
            </div>
        </article>
    </Link>
</template>

<style>
.link-product {
    position: relative;
    z-index: 1;
}
.card_actions-buttons {
    position: relative;
    z-index: 2;
}
.card-product {
    height: 100%;
    color: black;
}
.fa-star {
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
</style>
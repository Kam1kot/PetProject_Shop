<script setup>
    import ProductCard from './productCard.vue';
    import Pagination from './Pagination.vue';
    
    const props = defineProps({
        products: Object,
        links: Array
    })

    const emit = defineEmits(['change-page']);

    const formatLabel = (label) => {
        if (label.includes('Previous')) return '«'
        if (label.includes('Next')) return '»'
        return label
    };

    const scrollToCatalog = () => {
        const catalog = document.getElementById('vue-product-list')
        const navbarHeight = document.querySelector('.navbar')?.getBoundingClientRect().height ?? 0

        if (!catalog) return

        const top = catalog.getBoundingClientRect().top + window.scrollY - navbarHeight - 16

        window.scrollTo({
            top,
            behavior: 'smooth'
        })
    };

    const handlePageChange = async (link) => {
        if (!link.url) return

        const page = link.url.split('page=')[1]
        await store.load(page)
        store.loadedPage = false

        scrollToCatalog()
    };
</script>

<template>
    <div v-if="loadingPage">
        <div class="skeleton-list">
            <article class="skeleton-card" v-for="n in 8"></article>
        </div>
    </div>
    <div v-else class="catalog-items">
        <ProductCard 
            v-for="product in products" 
            :key="product.id"
            :product="product"
            :otherProducts="products"
        />
    </div>
    <Pagination :links="links" />
</template>

<style>
.skeleton-list {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    flex-wrap: wrap;
}
.skeleton-card {
    height: 15rem;
    width: 100%;
    background: linear-gradient(90deg, #eee, #ddd, #eee);
    animation: loading 1.5s infinite;
    margin-bottom: 10px;
    border-radius: 10px;
}

@keyframes loading {
    0% { background-position: -200px 0; }
    100% { background-position: 200px 0; }
}
</style>
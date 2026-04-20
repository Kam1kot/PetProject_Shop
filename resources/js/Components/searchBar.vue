<script setup>
    import { ref, watch, onMounted, onBeforeUnmount } from 'vue'
    import { useProductFetch } from '../../components/fetchProducts';
    import { storeToRefs } from 'pinia';

    import ProductCard from './ProductCard.vue'

    const store = useProductFetch()
    const { products } = storeToRefs(store)

    const searchParams = ref('')
    const searchBox = ref(null)

    let timeout = null;
    const isOpen = ref(false)

    const handleClickOutside = (e) => {
        if (searchBox.value && !searchBox.value.contains(e.target)) {
            isOpen.value = false
        } else isOpen.value = true
    }

    watch(searchParams, (val) => {
        clearTimeout(timeout)

        if (!val) {
            store.products = []
            isOpen.value = false
            return
        }

        isOpen.value = true

        timeout = setTimeout(async () => {
            store.search = val
            store.loadedPage = false
            await store.load(1, 6)
        }, 400);
        console.log(products)
    })
    onMounted(() => {
        document.addEventListener('click', handleClickOutside)
    })

    onBeforeUnmount(() => {
        document.removeEventListener('click', handleClickOutside)
    })
</script>

<template>
    <div class="search-wrapper" ref="searchBox">
        <input
            v-model="searchParams"
            type="text"
            placeholder="Поиск товаров..."
            class="search-input"
        />

        <!-- результаты -->
        <div v-if="isOpen && searchParams && products.length" class="search-results">
            <ProductCard 
                v-for="product in products" 
                :key="product.id"
                :product="product"
            />
        </div>

        <!-- ничего не найдено -->
        <div v-if="isOpen && searchParams && !products.length" class="no-results">
            Ничего не найдено 😢
        </div>
    </div>
</template>

<style>
.search-wrapper {
    position: relative;
    width: 95%;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;

    display: grid;
    grid-template-columns: repeat(3,1fr);
    flex-wrap: wrap;
    scrollbar-width: thin;
}

.search-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.search-item:hover {
    background: #f5f5f5;
    cursor: pointer;
}
</style>
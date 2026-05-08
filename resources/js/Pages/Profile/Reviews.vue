<script setup>
    import Default from '../Layouts/Main.vue'
    import { Head, Link, usePage } from '@inertiajs/vue3'
    import { computed, ref } from 'vue';
    import { route } from 'ziggy-js';

    const props = defineProps({
        reviews: Array,
    })

    const sortBy = ref('Новейшие');
    const sortingOptions = [
        'Новейшие',
        'Старые',
        'Лучший рейтинг',
        'Худший рейтинг',
    ];

    const selectedStatuses = ref('Все');
    const statusOptions = [
        'Все',
        'На рассмотрении',
        'Запощенные',
        'Отклоненные'
    ];

    const filteredReviews = computed(() => {
        let result = [...props.reviews];

        if (selectedStatuses.value !== 'Все') {
            result = result.filter(review => {
                if (selectedStatuses.value === 'На рассмотрении') return review.status === 'pending'
                if (selectedStatuses.value === 'Запощенные') return review.status === 'approved'
                if (selectedStatuses.value === 'Отклоненные') return review.status === 'rejected'
                return true;
            })
        }

        result.sort((a,b) => {
            if (sortBy.value === 'Новейшие' ) return new Date(b.published_at) - new Date(a.published_at)
            if (sortBy.value === 'Старые') return new Date(a.published_at) - new Date(b.published_at)
            if (sortBy.value === 'Лучший рейтинг') return b.rating - a.rating
            if (sortBy.value === 'Худший рейтинг') return a.rating - b.rating
            return 0
        })

        return result
    });

    const resetFilters = () => {
        sortBy.value = 'Новейшие';
        selectedStatuses.value = [];
    };
</script>

<template>
    <Default>
        <Head :title="title ?? 'Профиль'" />
        <main class="profile">
            <h1>Личный кабинет</h1>
            <div class="profile-grid">
                <div class="profile-hrefs">
                    <Link :href="route('profile.index')" 
                        :class="{'active': route().current('profile.index')}">
                        Профиль
                    </Link>
                    <Link :href="route('profile.orders')"
                        :class="{'active': route().current('profile.orders')}">
                        Заказы
                    </Link>
                    <Link :href="route('profile.reviews')"
                        :class="{'active': route().current('profile.reviews')}">
                        Мои отзывы
                    </Link>
                    <Link :href="route('profile.addresses')"
                        :class="{'active': route().current('profile.addresses')}">
                        Мои адресса
                    </Link>
                    <!-- <Link :href="route('profile.achivments')"
                        :class="{'active': route().current('profile.achivments')}">
                        Достижения WIP
                    </Link> -->
                </div>
                <div class="profile-main">
                    <div class="filters-container">
                        <div class="filter-group">
                            <span>Статус:</span>
                            <label v-for="status in statusOptions" :key="status" class="checkbox-label">
                                <input type="radio" :value="status" v-model="selectedStatuses">
                                {{ status }}
                            </label>
                        </div>

                        <hr>

                        <div class="filter-group">
                            <span>Сортировать по:</span>
                            <label v-for="option in sortingOptions" :key="option" class="checkbox-label">
                                <input type="radio" name="sort_group" :value="option" v-model="sortBy">
                                {{ option }}
                            </label>
                        </div>

                        <button 
                            v-if="selectedStatuses.length || sortBy !== 'Новейшие'" 
                            @click="resetFilters" 
                            class="btn-reset"
                        >
                            Сбросить все фильтры
                        </button>
                    </div>
                    <div v-if="reviews" class="reviews-list">
                        <div v-for="review in filteredReviews" :key="review.id" class="review-card">
                            <span>{{ review.author_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </Default>
</template>

<style scoped>
.profile-main {
    display: grid;
    grid-template-columns: 1fr 3.8fr;
}
.active {
    color: black !important;
    font-weight: 500 !important;
}
body {
    background-color: rgb(236, 236, 236);
}
.profile {
    
    margin: 0 auto;
    width: 60%;
}
.profile h1 {
    width: 100%;
    text-align: left;
    font-weight: 500;
    font-size: 2em;
    margin-bottom: 1rem;
}
.profile-grid {
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 3.8fr;
    grid-column-gap: 20px;
}
.profile-hrefs {
    background-color: white;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 10px 25px #00000014;
}
.profile-hrefs a {
    width: 100%;
    font-size: 1.2em;
    color: gray;
    text-align: left;
    padding: 1rem 1.25rem;
    transition: 0.15s all;
}
.profile-hrefs a:hover {
    color: black;
}
.profile-main {
    background-color: white;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 10px 25px #00000014;
}
</style>
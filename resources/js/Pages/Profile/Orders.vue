<script setup>
    import Default from '../Layouts/Main.vue'
    import { Head, Link, usePage } from '@inertiajs/vue3'
    import { route } from 'ziggy-js';
    const page = usePage();
    const user = page.props.auth.user
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
                <div class="profile-main"></div>
            </div>
        </main>
    </Default>
</template>

<style scoped>
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
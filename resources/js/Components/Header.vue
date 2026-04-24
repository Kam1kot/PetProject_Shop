<script setup>
    import { Link, usePage } from '@inertiajs/vue3'
    const page = usePage()

    const isAuth = page.props.auth.user ? page.props.auth.user : null;
    const user = page.props.auth.user

    console.log('HEAD Page props: ', page.props)
    console.log('HEAD Auth: ', isAuth)
    console.log('HEAD User: ', user)
</script>

<template>
    <div class="navbar">
        <div class="navbar_items">
            <h1 class="navbar__h1">
                <Link :href="`/`">TechStore</Link>
            </h1>
            <div id="vue-searchBar" class="navbar__find hidden"></div>
            <div class="navbar__href">
                <Link href="#">Блог</Link>
                <Link href="#">Магазин</Link>
            </div>
            <div class="navbar__actions">
                <button class="navbar___find"><i class="fa-solid fa-magnifying-glass"></i></button>
                <Link href="#" class="navbar___cart"><i class="fa-solid fa-cart-shopping"></i></Link>
                <Link href="#" class="navbar___account">
                    <i class="fa-solid fa-circle-user"></i>
                    <div class="acc-popup">
                        <Link v-if="isAuth" :href="`/profile`">Профиль</Link>
                        <Link v-if="!isAuth" :href="`/login`">Войти</Link>
                        <Link style="text-wrap: nowrap;" v-if="!isAuth" :href="`/register`">Создать аккаунт</Link>
                        <Link v-if="isAuth"
                            :href="`/logout`" 
                            method="post" 
                            as="button"
                        >Выйти</Link>
                    </div>
                </Link>
            </div>
        </div>
    </div>

    <header v-if="page.component == 'Sections/MainCatalog'">
        <div class="header-wrapper"></div>
    </header>
</template>

<style>
.navbar___account {
    position: relative;
    z-index: 2;
}
.acc-popup {
    position: absolute;
    z-index: 1;
    right: 50%;
    transform: translateX(50%);
    top: 150%;
    padding: 0.75rem;
    border-radius: 0.5rem;
    background-color: white;
    color: black;
    opacity: 0;
    visibility: hidden;
    transition: 0.3s all;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.navbar___account:hover .acc-popup,.navbar___account:focus-within .acc-popup{
    visibility: visible;
    opacity: 1;
}
.acc-popup a {
    font-size: 1em;
    transition: 0.3s all;
}
.acc-popup a:hover {
    text-decoration: underline;
}
</style>
<script setup>
    import { Link, usePage } from '@inertiajs/vue3'
    import { computed } from 'vue'
    const page = usePage()
    console.log(page);
    // console.log(page)
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
                        <Link :href="`#`">Профиль</Link>
                        <Link :href="`#`">Войти</Link>
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
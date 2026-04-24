<script setup>
    import Default from '../Layouts/Main.vue'
    import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Default>
        <Head :title="title ?? 'Авторизация пользователя'" />
        <main>
            Login
        </main>
    </Default>
</template>

<style>
main {
    margin-top: 8rem;
}

</style>
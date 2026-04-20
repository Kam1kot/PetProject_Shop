<script setup>
    import Header from '../../Components/Header.vue'
    import Footer from '../../Components/Footer.vue'

    defineProps({ title: String})
</script>


<template>
    <Head title="{{ title }}"></Head>
    <Header />
    <slot></slot>
    <Footer />
</template>
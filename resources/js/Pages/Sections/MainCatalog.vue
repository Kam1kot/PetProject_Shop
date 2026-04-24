<script setup>
    import Default from '../Layouts/Main.vue'
    import { computed } from 'vue';
    import { usePage,Head } from '@inertiajs/vue3'

    import ProductList from '../../Components/productList.vue';
    import RecommendationsSwiper from '../../Components/recommendationsSwiper.vue';

    const mainProps = defineProps({
        title: String,
        products: Object,
        hitProducts: Array
    })
    // console.log(page);
    // console.log(isAuth);
    // console.log(user);
</script>

<template>
    <Default>
        <Head :title="title ?? 'Главная страница'" />
        <main>
            <div class="main-wrapper">
                <div class="main-top">
                    <h2>Все что нужно для <span style="color:rgb(70, 70, 129);">Вас</span> здесь!</h2>
                </div>
                <div class="main-bottom">
                    <section>
                        <div class="catalog-wrapper">
                            <div class="catalog-menu">
                                <h3>Категории</h3>
                                <details open>
                                    <summary>
                                        <span><i class="fa-solid fa-bag-shopping"></i></span>
                                        <a href="">Все товары</a>
                                        <span class="badge">32</span>
                                    </summary>
                                    <ul>
                                        <li>
                                            <a href="#">Наушники</a>
                                        </li>
                                        <li>
                                            <a href="#">Периферия</a>
                                        </li>
                                        <li>
                                            <a href="#">Ноутбуки</a>
                                        </li>
                                        <li>
                                            <a href="#">Готовые ПК</a>
                                        </li>
                                    </ul>
                                </details>
                                <details>
                                    <summary>
                                        <span><i class="fa-solid fa-alarm-clock"></i></span>
                                        <a href="">Новинки</a>
                                    </summary>
                                    <ul>
                                        <li>
                                            <a href="#">Наушники</a>
                                        </li>
                                        <li>
                                            <a href="#">Периферия</a>
                                        </li>
                                        <li>
                                            <a href="#">Ноутбуки</a>
                                        </li>
                                        <li>
                                            <a href="#">Готовые ПК</a>
                                        </li>
                                    </ul>
                                </details>
                                <details>
                                    <summary>
                                        <span><i class="fa-solid fa-fire"></i></span>
                                        <a href="">В тренде</a>
                                    </summary>
                                    <ul>
                                        <li>
                                            <a href="#">Наушники</a>
                                        </li>
                                        <li>
                                            <a href="#">Периферия</a>
                                        </li>
                                        <li>
                                            <a href="#">Ноутбуки</a>
                                        </li>
                                        <li>
                                            <a href="#">Готовые ПК</a>
                                        </li>
                                    </ul>
                                </details>
                                <details>
                                    <summary>
                                        <span><i class="fa-solid fa-percent"></i></span>
                                        <a href="">Скидки</a>
                                    </summary>
                                    <ul>
                                        <li>
                                            <a href="#">Наушники</a>
                                        </li>
                                        <li>
                                            <a href="#">Периферия</a>
                                        </li>
                                        <li>
                                            <a href="#">Ноутбуки</a>
                                        </li>
                                        <li>
                                            <a href="#">Готовые ПК</a>
                                        </li>
                                    </ul>
                                </details>
                            </div>

                            <ProductList  :links="mainProps.products.links" :products="products.data"/>
                        </div>
                    </section>
                    <section>
                        <div class="recommendations">
                            <RecommendationsSwiper :products="hitProducts"/>
                        </div>
                    </section>
                    <section>
                        <div class="get-new-stuff">
                            <p>Готовы приобрести что-то новое?</p>
                            <form action="#">
                                <input placeholder="Ваша почта" id="email" name="email" type="email">
                                <button type="submit">Отправить</button>
                            </form>
                            <p>
                                <span>Товары для дома и нужд </span>
                                Мы просмотрим что вам нужно, выберем лучшее, 
                                и затем создадим уникальное решение индивидуально 
                                для вас
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </Default>
</template>
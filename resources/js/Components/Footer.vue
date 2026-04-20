<script setup>
    import { Link } from '@inertiajs/vue3'
</script>

<template>
    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <p>About</p>
                <Link href="#">Блог</Link>
                <Link href="#">Наша команда</Link>
                <Link href="#">Связаться с нами</Link>
            </div>
            <div class="footer-support">
                <p>Помощь</p>
                <Link href="">Доставка</Link>
                <Link href="">Возврат</Link>
                <Link href="">FAQ</Link>
            </div>
            <div class="footer-socials">
                <p>Социальные сети</p>
                <div class="socials-list">
                    <Link href=""><i class="fa-brands fa-vk"></i></Link>
                    <Link href=""><i class="fa-brands fa-telegram"></i></Link>
                    <Link href=""><i class="fa-brands fa-square-instagram"></i></Link>
                    <Link href=""><i class="fa-brands fa-square-x-twitter"></i></Link>
                </div>
            </div>
        </div>
        <hr>
        <div class="footer-copyright">
            <p>Все права защищены 2026 TechStore</p>
            <div>
                <Link href="">Политика конфиденциальности</Link>
            </div>
        </div>
    </footer>
</template>
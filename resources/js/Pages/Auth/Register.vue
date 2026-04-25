<script setup>
    import Default from '../Layouts/Main.vue'
    import { useForm, Head, Link } from '@inertiajs/vue3'

    const form = useForm({
        name: '',
        surname: '',
        nickname: '',
        email: '',
        password: '',
        password_confirmation: ''
    })
    const submit = () => {
        form.post('/register', {
            onFinish: () => form.reset('password'),
        });
    };
</script>

<template>
    <Default>
        <Head :title="title ?? 'Регистрация пользователя'" />
        <main>
            <h3>Регистрация пользователя. Вас? <strong>:3</strong></h3>
            <h4>Или вы уже у нас были? <Link :href="`/login`">Войти</Link></h4>
            
            <form @submit.prevent="submit">
                <label>
                    Имя
                    <input type="text" v-model="form.name" autocomplete="name">
                    <span v-if="form.errors.name" class="error">{{ form.errors.name }}</span>
                </label>
                

                <label>
                    Фамилия
                    <input type="text" v-model="form.surname" autocomplete="surname">
                    <span v-if="form.errors.surname" class="error">{{ form.errors.surname }}</span>
                </label>
                
                <label for="nickname">
                    Имя пользователя
                    <input type="text" v-model="form.nickname" autocomplete="nickname">
                    <span v-if="form.errors.nickname" class="error">{{ form.errors.nickname }}</span>
                </label>
                
                <label for="email">
                    Email
                    <input type="email" v-model="form.email" autocomplete="email">
                    <span v-if="form.errors.email" class="error">{{ form.errors.email }}</span>
                </label>
                
                <label for="password">
                    Пароль
                    <input type="password" v-model="form.password" autocomplete="password">
                    <span v-if="form.errors.password" class="error">{{ form.errors.password }}</span>
                </label>
                <label for="conf-password">
                    Подтвердите пароль
                    <input type="password" v-model="form.password_confirmation">
                    <span v-if="form.errors.password_confirmation" class="error">{{ form.errors.password_confirmation }}</span>
                </label>
                
                <button :disabled="form.processing" type="submit">
                    {{ form.processing ? 'Регистрация...' : 'Зарегистрироваться' }}
                </button>
            </form>
        </main>
    </Default>
</template>

<style>
h3 {
    margin-right: auto;
    font-size: 2.2em;
}
h4 {
    margin-right: auto;
    font-size: 1.75em;
}
h4 a {
    font-size: 0.8em;
    color: rgb(96, 96, 255);
    text-decoration: underline;
    
}
main {
    margin: 6rem auto 6rem auto;
    width: 80%;
}
form {
    margin-top: 3rem;
    margin-right: auto;
    display: grid;
    grid-template-columns: repeat(2,1fr);
    grid-template-rows: repeat(6,1fr);
    grid-column-gap: 25px;
    grid-row-gap: 10px;
    width: 40%;
}
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0px 1000px #fff inset !important;
    -webkit-text-fill-color: black !important;
    transition: background-color 5000s ease-in-out 0s;
}
form label, form button[type="submit"]{
    display: flex;
    flex-direction: column;
    font-size: 0.8em;
    background-color: #fff;
    border-radius: 1rem;
    padding: 0.5rem 0.75rem;
    box-shadow: 0 10px 30px #00000014;
}

form label input {
    border: none;
    outline: none;
    font-size: 1.5em;
    background-color: #fff !important;
}
form label input:-internal-autofill-selected {
    background-color: #fff !important;
}
form label input::placeholder {
    color: gray;
}
form label[for="nickname"] {
    grid-row-start: 2;
    grid-column: span 2 / span 2;
}
form label[for="email"] {
    grid-row-start: 3;
    grid-column: span 2 / span 2;
}
form label[for="password"] {
    grid-row-start: 4;
    grid-column: span 2 / span 2;
}
form label[for="conf-password"] {
    grid-row-start: 5;
    grid-column: span 2 / span 2;
}
form button[type="submit"] {
    background-color: aliceblue;
    border: 1px solid gray;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25em;
    width: max-content;
    margin-left: auto;
    border-radius: 0.75rem;
    grid-row-start: 6;
    grid-column-start: 2;
}
</style>
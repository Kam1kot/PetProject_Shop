<script setup>
    import Default from '../Layouts/Main.vue'
    import { useForm, Link, Head } from '@inertiajs/vue3'

    const form = useForm({
        email: '',
        password: '',
        remember: false
    })
    const submit = () => {
        form.post('/login', {
            onFinish: () => form.reset('password'),
        });
    };
</script>

<template>
    <Default>
        <Head :title="title ?? 'Авторизация пользователя'" />
        <main class="Login">
            <h3>Авторизация пользователя.</h3>
            <h4>Нет аккаунта? <Link :href="`/register`">Создать аккаунт</Link></h4>
            
            <form @submit.prevent="submit">
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

                <div class="remember-me">
                    <label>
                        Запомнить меня
                        <input type="checkbox" v-model="form.remember" name="remember">
                    </label>
                </div>
                
                <button :disabled="form.processing" type="submit">
                    {{ form.processing ? 'Вход...' : 'Войти в аккаунт' }}
                </button>
            </form>
        </main>
    </Default>
</template>

<style scoped>
.remember-me {
    width: max-content;
}
.remember-me label{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    gap: 20px;
    font-size: 1.1em;
}
.remember-me label input {
    transform: scale(1.2);
    width: auto;
    height: auto;
}
main {
    margin-top: 8rem;
}
.login {
    width: 80%;
}
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
    grid-template-rows: auto;
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
form label[for="email"] {
    grid-column: span 2 / span 2;
}
form label[for="password"] {
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
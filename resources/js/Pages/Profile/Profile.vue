<script setup>
    import Default from '../Layouts/Main.vue'
    import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3'
    import { ref, onMounted, onUnmounted } from 'vue'
    import { route } from 'ziggy-js';

    const page = usePage();
    const user = page.props.auth.user
    const isOpenAvatarMenu = ref(false)
    const fileInput = ref(null);

    const toggleMenu = () => {
        isOpenAvatarMenu.value = !isOpenAvatarMenu.value
    }

    const form = useForm({
        name: user.name ?? '',
        surname: user.surname ?? '',
        nickname: user.nickname ?? '',
        email: user.email ?? '',
        phone: user.phone ?? ''
    })
    const avatarForm = useForm({
        avatar: null,
        _method: 'patch'
    })

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            avatarForm.avatar = file;
            
            // Отправляем файл на сервер
            avatarForm.post('/profile/avatar/update', {
                forceFormData: true,
                preserveScroll: true,
                preserveState: false,
                onSuccess: () => {
                    isOpenAvatarMenu.value = false;
                },
            });
        }
    };
    const deleteAvatar = () => {
        router.delete('/profile/avatar/delete', {
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => {
                isOpenAvatarMenu.value = false;
            },
        });
    }
    const formatDate = (dateStr) => {
        return new Date(dateStr).toLocaleString('ru-RU', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        })
    }
</script>

<template>
    <Default>
        <Head :title="title ?? 'Профиль'" />
        <main class="profile">
            <h1>Личный кабинет</h1>
            <h2>Приветствую, {{ user.name }}!</h2>
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
                </div>
                <div class="profile-main">
                    <p class="title">Информация об аккаунте</p>
                    <div class="acc-info">
                        <div class="avatar">
                            <div class="avatar-container" @click="toggleMenu">
                                <img v-if="user.avatar" :src="'/storage/' + user.avatar" alt="Avatar" class="avatar-img">
                                
                                <i v-else class="fa-solid fa-circle-user placeholder-icon"></i>
                                
                                <div class="camera-badge">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                            </div>

                            <div v-if="isOpenAvatarMenu" class="avatarMenu-popup">
                                <input 
                                    type="file" 
                                    ref="fileInput" 
                                    class="hidden" 
                                    @change="handleFileChange" 
                                    accept="image/*"
                                    style="display:none"
                                >
                                <button type="button" @click="$refs.fileInput.click()">Изменить</button>
                                <button type="button" @click="deleteAvatar()" style="color:red">Удалить</button>
                            </div>
                            <p v-if="form.errors.avatar" style="color: red;">{{ form.errors.avatar }}</p>
                        </div>   
                        <div>
                            <div>
                                <span>{{ user.name }}</span>
                                <span>{{ user.surname }}</span>
                            </div>
                            <p class="info">Дата регистрации: {{ formatDate(user.created_at).toLocaleString('ru-RU')}}</p>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="user-info">
                        
                        <div class="form-group">
                            <input v-model="form.name" type="text" placeholder=" " />
                            <label>Имя</label>
                        </div>

                        <div class="form-group">
                            <input v-model="form.surname" type="text" placeholder=" " />
                            <label>Фамилия</label>
                        </div>

                        <div class="form-group">
                            <input v-model="form.nickname" type="text" placeholder=" " />
                            <label>Имя пользователя</label>
                        </div>

                        <div class="form-group full">
                            <input v-model="form.email" type="email" placeholder=" " />
                            <label>Почта</label>
                        </div>

                        <div class="form-group full">
                            <input v-model="form.phone" type="text" placeholder=" " />
                            <label>Телефон</label>
                        </div>

                        <button type="submit" class="btn">
                            Сохранить
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </Default>
</template>

<style>
.active {
    color: black !important;
    font-weight: 500 !important;
}
body {
    background-color: rgb(236, 236, 236);
}
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0px 1000px #fff inset !important;
    -webkit-text-fill-color: black !important;
    transition: background-color 5000s ease-in-out 0s;
}
input::placeholder {
    color: gray;
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
    margin-bottom: 0.5rem;
}
.profile h2 {
    width: 100%;
    text-align: left;
    font-weight: 500;
    font-size: 1.35em;
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
    align-items: center;
    height: max-content;
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
    padding: 1rem;
}
.profile-main p.title {
    font-size: 1.25em;
    font-weight: 500;
    padding: 0 1rem;
    width: 100%;
    text-align: left;
    margin-bottom: 1rem;
}
.profile-main p.info {
    font-size: 0.9em;
    width: 100%;
    text-align: left;
}
.acc-info {
    position: relative;
    display: flex;
    align-items: center;
    margin: 0 auto 2rem 0;
    gap: 20px;
}
.acc-info i {
    font-size: 8em;
}
.acc-info > div {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.acc-info > div > p {
    font-size: 1.1em !important;
}
.avatar {
    position: relative;
}
.fa-circle-user {
    position: relative;
    z-index: 1;
    transition: color 0.2s;
    cursor: pointer;
}
.fa-circle-user:hover{
    color: gray;
}
.avatarMenu-popup {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 0.75rem;
    border: 1px solid gray;

    font-size: 0.8em;
    position: absolute;
    background-color: white;
    border-radius: 1rem;
    left: 50%;
    transform: translateX(-50%);
    bottom: -55%;
    z-index: 100;
}
.avatarMenu-popup button:hover {
    cursor: pointer;
    text-decoration: underline;
}
.avatar-container {
    position: relative;
    width: 150px;
    height: 150px;
    cursor: pointer;
    border-radius: 50%;
    overflow: visible;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f0f0f0;
    border: 2px solid #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover; 
    display: block;
}
.placeholder-icon {
    font-size: 150px !important;
    color: #ccc;
    line-height: 1;
}
.camera-badge {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 35px;
    height: 35px;
    background-color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 2;
}
.camera-badge i {
    font-size: 1.1rem !important;
    color: #333;
}

.avatar-container:hover .avatar-img {
    filter: brightness(0.9);
    transition: 0.2s;
}
.user-info {
    width: 100%;
    padding: 1rem;
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 20px;
}
.form-group {
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 1;
    border: 1px solid gray;

    padding: 0.75rem 1rem;
    border-radius: .5rem;
}

.form-group label {
    position: absolute;
    background-color: rgb(224, 224, 224);
    padding: 0 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid gray;
    z-index: 2;
    left: 1rem;
    top: -25%;
}

.form-group input {
    outline: none;
    border: none;
    padding-top: 0.25rem;
    font-size: 1.1em;
}
.form-group:focus-within, .form-group:focus-within label {
    border: 2px solid skyblue;
}
.form-group:focus-within label {
    background-color: aliceblue;
    color: black
}
.form-group.full {
    grid-column: span 2 / span 2;
}

</style>
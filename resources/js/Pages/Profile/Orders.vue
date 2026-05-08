<script setup>
    import Default from '../Layouts/Main.vue'
    import { Head, Link, usePage, router } from '@inertiajs/vue3'
    import { ref, onMounted, onUnmounted, computed } from 'vue';
    import { route } from 'ziggy-js';

    const props = defineProps({
        orders: Array,
    })

    let interval;
    onMounted(() => {
        interval = setInterval(() => {
            router.reload({ only: ['orders'], preserveScroll: true });
        }, 15000); 
    });

    onUnmounted(() => clearInterval(interval));
    const formatCurrency = (value) => {
        return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
    };
    const formatPrice = (value) => {
        return new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: 'RUB',
        }).format(value);
    };
    const formatDate = (dateStr) => {
        return new Date(dateStr).toLocaleString('ru-RU', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        })
    }
    const orderFormat = (status) => {
        console.log(status)
        switch (status) {
            case 'processing':
                return 'В процессе'
            case 'cancelled':
                return 'Отменен'
            case 'new':
                return 'Создан'
            case 'completed':
                return 'Завершен'
            default:
                break;
        }
    }
    const deliveryFormat = (status) => {
        console.log(status)
        switch (status) {
            case 'failed':
                return 'Отменен'
            case 'delivered':
                return 'Доставлен'
            case 'pending':
                return 'В ожидании'
            case 'shipped':
                return 'Отправлен'
            case 'packed':
                return 'Упакован'
            default:
                break;
        }
    }

    const selectedStatuses = ref([]);
    const availableStatuses = computed(() => {
        return [...new Set(props.orders.map(order => order.status))];
    });
    const filteredOrders = computed(() => {
        if (selectedStatuses.value.length === 0) {
            return props.orders;
        }
        return props.orders.filter(order => 
            selectedStatuses.value.includes(order.status)
        );
    });
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
                <div class="profile-main">
                    <div class="filters">
                        <span class="filters-title">Фильтр по статусу:</span>
                        <div class="checkbox-group">
                            <label v-for="status in availableStatuses" :key="status" class="checkbox-label">
                                <input 
                                    type="checkbox" 
                                    :value="status" 
                                    v-model="selectedStatuses"
                                >
                                <span class="status-name">{{ status }}</span>
                            </label>
                        </div>
                        <!-- Кнопка сброса, если что-то выбрано -->
                        <button v-if="selectedStatuses.length" @click="selectedStatuses = []" class="btn-reset">
                            Сбросить
                        </button>
                    </div>
                    <div v-if="orders" class="orders-list">
                        <div v-for="order in filteredOrders" :key="order.id" class="order-card">
                            <div class="order-header">
                                <div class="order-info">
                                    <span class="order-number">Заказ №{{ order.order_number }}</span>
                                    <span class="order-date">{{formatDate(order.created_at) }}</span>
                                </div>
                                <div class="order-badges">
                                    <span :class="['status-badge', `status-${order.status}`]">
                                    {{ orderFormat(order.status) }}
                                    </span>
                                    <span :class="['status-badge', order.payment_status === 'paid' ? 'paid' : 'unpaid']">
                                    {{ order.payment_status }}
                                    </span>
                                </div>
                            </div>

                            <div class="order-body">
                                <div class="order-details">
                                    <p><strong>Адрес:</strong> {{ order.delivery_city }}, {{ order.delivery_address }}</p>
                                    <p><strong>Метод доставки:</strong> {{ order.delivery_method }}</p>
                                    <p><strong>Статус доставки:</strong> {{ deliveryFormat(order.delivery_status) }}</p>
                                </div>
                                <div class="order-total">
                                    <span class="total-label">Итого:</span>
                                    <span class="total-price">{{ formatPrice(order.total_amount) }}</span>
                                </div>
                            </div>

                            <div class="order-footer">
                                <button class="btn-secondary">Детали заказа</button>
                                <button class="btn-primary">Повторить</button>
                            </div>
                        </div>
                    </div>

                    <div v-else class="empty-state">
                        <p>У вас пока нет заказов</p>
                        <button class="btn-primary">Перейти в магазин</button>
                    </div>
                </div>
            </div>
        </main>
    </Default>
</template>

<style scoped>
.filters {
    position: sticky;
    top: 5rem;
    width: 100%;
    padding: 20px;
    background: #fdfdfd;
    border-bottom: 1px solid #eee;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    height: max-content;
}

.filters-title {
    font-weight: 600;
    font-size: 14px;
    color: #666;
}

.checkbox-group {
    display: flex;
    gap: 12px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    cursor: pointer;
    background: #eee;
    padding: 4px 10px;
    border-radius: 6px;
    transition: 0.2s;
}

.checkbox-label:hover {
    background: #e2e2e2;
}

.checkbox-label input {
    cursor: pointer;
}

.btn-reset {
    background: none;
    border: none;
    color: #4f46e5;
    font-size: 13px;
    text-decoration: underline;
    padding: 0;
    margin-left: auto;
}

.empty-state {
    padding: 40px;
    text-align: center;
    color: #888;
}
.orders-list {
    grid-column-start: 2;
}
.profile-hrefs {
    position: sticky !important;
    top: 5rem;
    bottom: 2rem;
    height: max-content;
}
.orders-container {
  max-width: 800px;
  margin: 40px auto;
  padding: 0 20px;
  font-family: sans-serif;
  color: #333;
}

.page-title {
  font-size: 24px;
  margin-bottom: 24px;
}

.order-card {
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  margin-bottom: 20px;
  overflow: hidden;
  transition: box-shadow 0.3s ease;
}

.order-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* Шапка */
.order-header {
  background: #f9f9f9;
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.order-number {
  font-weight: bold;
  margin-right: 15px;
}

.order-date {
  color: #888;
  font-size: 14px;
}

/* Баджи (статусы) */
.status-badge {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  margin-left: 8px;
  text-transform: lowercase;
}

.status-new {background-color:#aadaf1 ; color: rgb(0, 134, 151)}
.status-processing {background-color:#e7f1aa ; color: rgb(160, 160, 0)}
.status-cancelled {background-color:#fff4e5 ; color: rgb(238, 88, 88);}
.status-pending { background: #fff4e5; color: #b76e00; }
.status-completed { background: #e6fcf5; color: #087f5b; }
.paid { background: #e7f5ff; color: #1971c2; }
.unpaid { background: #f1f3f5; color: #495057; }

/* Тело */
.order-body {
  padding: 20px;
  display: flex;
  justify-content: space-between;
}

.order-details p {
  margin: 5px 0;
  font-size: 14px;
  color: #555;
}

.order-total {
  text-align: right;
}

.total-label {
  display: block;
  font-size: 12px;
  color: #888;
}

.total-price {
  font-size: 20px;
  font-weight: bold;
  color: #2c3e50;
}

/* Кнопки */
.order-footer {
  padding: 15px 20px;
  border-top: 1px dotted #eee;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

button {
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  border: none;
  transition: 0.2s;
}

.btn-primary {
  background: #4f46e5;
  color: white;
}

.btn-primary:hover { background: #4338ca; }

.btn-secondary {
  background: white;
  border: 1px solid #d1d5db;
  color: #374151;
}

.btn-secondary:hover { background: #f9fafb; }
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
    position: relative;
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
    padding: 1rem;
    background-color: white;
    border-radius: 1rem;
    display: grid;
    grid-template-columns: 1.2fr 2.5fr;
    grid-template-rows: auto;
    grid-column-gap: 20px;
    box-shadow: 0 10px 25px #00000014;
}
</style>
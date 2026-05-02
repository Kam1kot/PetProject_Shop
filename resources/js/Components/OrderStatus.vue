<script setup>
import { computed } from 'vue';

const props = defineProps(['status', 'type']);

const statusClasses = computed(() => {
  const map = {
    'pending': 'bg-yellow-100 text-yellow-700',
    'completed': 'bg-green-100 text-green-700',
    'cancelled': 'bg-red-100 text-red-700',
    'paid': 'bg-emerald-100 text-emerald-700',
    'unpaid': 'bg-gray-100 text-gray-600',
  };
  return map[props.status] || 'bg-blue-100 text-blue-700';
});
const statusFormat = (status) => {
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
</script>

<template>
  <span :class="['px-2.5 py-0.5 rounded-full text-xs font-medium', statusClasses]">
    {{ statusFormat(status) }}
  </span>
</template>
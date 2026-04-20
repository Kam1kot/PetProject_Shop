<script setup>
import { Link } from '@inertiajs/vue3'

const pagProps = defineProps({
    links: Array
})
// console.log('Pagination Prop: ', pagProps.links[0].label)
// console.log('Pagination Prop: ', pagProps.links[pagProps.links.length-1].label)

// Замена стрелок в пагинации
pagProps.links[0].label = "&laquo"
pagProps.links[pagProps.links.length-1].label = "&raquo"
</script>

<template>
    <div v-if="links.length > 3" class="pagination">
        <template v-for="(link, key) in links" :key="key">
            <div v-if="link.url === null" 
                 class="disabled page-btn" 
                 v-html="link.label" />
            
            <Link v-else
                  :href="link.url"
                  class="page-btn"
                  :class="{ 'page-btn-active': link.active }"
                  v-html="link.label"
                  preserve-scroll
            />
        </template>
    </div>
</template>

<style>
.pagination {
    grid-column: 3 / 4;
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 20px;
}

.page-btn {
    padding: 8px 12px;
    border: 1px solid #ddd;
    color: black;
    background: white;
    cursor: pointer;
    border-radius: 6px;
    transition: 0.2s;
}

.page-btn:hover {
    background: gray;
    color: white;
}

.page-btn-active {
    background: gray;
    color: white;
    border-color: gray;
}

.pagination .disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
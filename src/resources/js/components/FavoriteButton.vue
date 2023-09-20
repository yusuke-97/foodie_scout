<script setup>
import { ref } from 'vue'

const isFavorited = ref(false)
</script>

<template>
    <button 
        class="btn favorite-button text-favorite w-100"
        @click.prevent="isFavorited = !isFavorited">
        <i class="fas fa-bookmark"></i>
        {{ isFavorited ? 'お気に入り解除' : 'お気に入り' }}
    </button>
</template>
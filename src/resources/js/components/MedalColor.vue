<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    isFollowed: Number,
    userFollowed: Number
})

const medalColor = computed(() => {
    if (props.isFollowed >= 100) return 'medal-color-platinum'
    if (props.isFollowed >= 50) return 'medal-color-gold'
    if (props.isFollowed >= 30) return 'medal-color-silver'
    if (props.isFollowed >= 10) return 'medal-color-bronze'
    return 'medal-color-green'
})

const medalColorUserFollowed = computed(() => {
    if (props.userFollowed >= 100) return 'medal-color-platinum'
    if (props.userFollowed >= 50) return 'medal-color-gold'
    if (props.userFollowed >= 30) return 'medal-color-silver'
    if (props.userFollowed >= 10) return 'medal-color-bronze'
    return 'medal-color-green'
})

const isPlatinum = computed(() => {
    if (medalColor.value === 'medal-color-platinum' || medalColorUserFollowed.value === 'medal-color-platinum') {
        return 'medal-icon'
    }
    return ''
})
</script>

<template>
    <div :class="isPlatinum">
        <i
        v-if="props.isFollowed !== undefined" 
        :class="['fas', 'fa-medal', medalColor]"
        class="medal-size">
        </i>
        <i
        v-if="props.userFollowed !== undefined" 
        :class="['fas', 'fa-medal', medalColorUserFollowed]"
        class="medal-size">
        </i>
    </div>
</template>
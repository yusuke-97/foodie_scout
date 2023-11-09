<script setup>
import { ref, onMounted, onUnmounted, reactive } from 'vue'

const props = defineProps(['images'])
const { images } = props

let timeoutId = null
let state = reactive({ currentIndex: 0 })

const scrollImage = () => {
    timeoutId = setTimeout(() => {
        state.currentIndex = (state.currentIndex + 1) % images.length
        scrollImage()
    }, 6000)
}

onMounted(scrollImage)

onUnmounted(() => {
    clearTimeout(timeoutId)
})
</script>

<template>
    <div class="image-slider" ref="sliderRef">
        <div class="ratio ratio-16x9">
            <Transition name="fade">
                <div :key="state.currentIndex" class="image-item">
                    <div class="image-container">
                        <img :src="images[state.currentIndex].src" :alt="images[state.currentIndex].alt" />
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style>
.image-slider {
    position: relative;
    height: auto;
    overflow: hidden;
}

.image-item {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    box-sizing: border-box;
}

.image-container {
    height: 100%;
    overflow: hidden;
}

.image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 5s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
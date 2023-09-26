<script setup>
import { ref } from 'vue';

const inputFileRef = ref(null);
const imageUrl = ref(props.initialImage);

const props = defineProps(['initialImage']);
const emit = defineEmits(['update:image']);

function onImageUpload(e) {
  const file = e.target.files[0];
  if (file) {
    imageUrl.value = URL.createObjectURL(file);
    emit('update:image', file);
  }
}

function triggerFileInput() {
  inputFileRef.value.click();
}

function removeImage() {
  event.preventDefault();
  imageUrl.value = null;
  emit('update:image', null);
}
</script>

<template>
  <input 
    type="file"
    ref="inputFileRef" 
    @change="onImageUpload"
    style="display:none" />
  
  <button
    type="button"
    @click="triggerFileInput"
    class="btn">
    <i class="fas fa-image"></i> 画像を選択
  </button>
  
  <div v-if="imageUrl" class="position-relative" style="width: 200px; height: 200px; position: relative;">
    <img
      :src="imageUrl"
      class="img-fluid hoverable-image"
      style="object-fit: cover; width: 100%; height: 100%;"
      alt="Image Preview"/>
    <button 
      @click.prevent="removeImage"
      class="btn position-absolute"
      style="top: 0; right: 0;">
      <i class="fas fa-times"></i> 
    </button>
  </div>
</template>

<style>
.hoverable-image:hover {
  opacity: 0.7;
}
</style>
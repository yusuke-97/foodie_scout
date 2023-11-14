<script setup>
import { ref } from 'vue'

const inputFileRef = ref(null)
const imageUrl = ref(null)

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])

const modelValue = ref(props.modelValue)

function onImageUpload(e) {
	const file = e.target.files[0]
	if (file) {
		imageUrl.value = URL.createObjectURL(file)
		modelValue.value = file
		emit('update:modelValue', file)
	}
}

function triggerFileInput() {
  	inputFileRef.value.click()
}

function removeImage() {
	imageUrl.value = null
	modelValue.value = null
	emit('update:modelValue', null)
}
</script>

<template>
	<input 
		type="file"
		name="image"
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
			@click="removeImage"
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
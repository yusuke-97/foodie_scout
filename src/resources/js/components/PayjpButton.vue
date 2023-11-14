<script setup>
import postscribe from 'postscribe'
import { ref, onMounted } from 'vue'

const script = ref(null)
const props = defineProps({
  	cardExists: {
    	type: Boolean,
    	required: true
  	},
  	apiKey: {
    	type: String,
    	required: true
  	}
})

onMounted(() => {
	const scriptSource = 'https://checkout.pay.jp/'
	const buttonText = props.cardExists ? 'カードを更新する' : 'カードを登録する'

	const scriptTag = `
		<script type="text/javascript" 
				src="${scriptSource}" 
				class="payjp-button" 
				data-key="${props.apiKey}" 
				data-on-created="onCreated" 
				data-text="${buttonText}" 
				data-submit-text="${buttonText}">
		<\/script>`

	postscribe(script.value, scriptTag)
})
</script>



<template>
  	<div ref="script"></div>
</template>
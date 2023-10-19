<script setup>
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { ref, computed } from 'vue'

const props = defineProps({
  csrf: String,
  restaurantName: String,
  restaurantId: Number
})

const restaurantName = ref(props.restaurantName)
const restaurantId = ref(props.restaurantId)

const { errors, submitForm, defineInputBinds } = useForm({
  validationSchema: yup.object({
    content: yup.string().required('口コミを入力してください'),
  }),
})


const content = defineInputBinds('content')

</script>



<template>
    <h2 class="mt-3 mb-4" style="font-weight: bold;">{{ restaurantName }}</h2>
    <form action="/reviews" method="post" enctype="multipart/form-data" @submit="submitForm">
        <div class="form-group mb-4">
            <label>口コミ</label>
            <br>
            <textarea v-bind="content" name="content" class="form-control" style="resize: none;" rows="4"></textarea>
            <span style="color: red; font-weight: bold;">{{ errors.content }}</span>
        </div>

        <input type="hidden" name="restaurant_id" :value="restaurantId" />

        <input type="hidden" name="_token" :value="csrf" />

        <div class="row justify-content-center">
            <button class="btn submit-button mt-3 w-50">
                口コミを投稿
            </button>
        </div>
     </form>
</template>



<style>
label {
    margin-bottom: 16px;
}
</style>
<script setup>
import Modal from './Modal.vue'
import { ref, watch } from 'vue'
import axios from 'axios'

const selectedPoint = ref(null)
const showModal = ref(false)
const message = ref('')
const errorMessage = ref('')

watch(selectedPoint, (newValue) => {
  if (newValue) {
    errorMessage.value = ''
  }
})

function handleChargeClick() {
  if (!selectedPoint.value) {
    errorMessage.value = 'ポイントを選択してください。'
    return
  }

  message.value = `${new Intl.NumberFormat('ja-JP').format(selectedPoint.value)} ポイントをチャージしてもいいですか？`
  showModal.value = true
}

async function chargePoints() {
  const data = {
    point: selectedPoint.value
  }
  
  try {
    const response = await axios.post(`/users/mypage/charge/point`, data)
    if (response.data.redirect_to) {
      window.location.href = response.data.redirect_to
    }
  } catch (error) {
    console.error("Error:", error)
  }
}
</script>



<template>
    <h4 class="mt-4 mb-4 sub-title" style="font-weight: bold;">
        <i class="fas fa-coins"></i>
        ポイントチャージ
    </h4>

    <input type="radio" name="point" value="1000" v-model="selectedPoint" class="mb-3"><strong> 1,000</strong> ポイント<br>
    <input type="radio" name="point" value="2000" v-model="selectedPoint" class="mb-3"><strong> 2,000</strong> ポイント<br>
    <input type="radio" name="point" value="5000" v-model="selectedPoint" class="mb-3"><strong> 5,000</strong> ポイント<br>
    <input type="radio" name="point" value="10000" v-model="selectedPoint" class="mb-3"><strong> 10,000</strong> ポイント<br>
    <input type="radio" name="point" value="30000" v-model="selectedPoint" class="mb-3"><strong> 30,000</strong> ポイント<br>

    <button id="show-modal" @click="handleChargeClick" class="btn submit-button mt-3" style="width: 50%">チャージする</button>
    <p class="mt-2" style="color: red; font-weight: bold;">{{ errorMessage }}</p>
    
    <Teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
            <template #header>
                <h3>チャージの確認</h3>
            </template>
            <template #body>
                {{ message }}
            </template>
            <template #footer>
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <button @click="chargePoints" class="btn submit-button">チャージする</button>
                    <button @click="showModal = false" class="btn submit-button" style="background-color: #f16363;">キャンセル</button>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>
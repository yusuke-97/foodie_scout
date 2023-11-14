<script setup>
import Modal from './Modal.vue'
import { ref } from 'vue'

const props = defineProps({
	visitDate: String,
	visitTime: String,
	numberOfGuests: Number,
	reservationId: Number,
	reservationFee: Number,
	restaurantId: Number
})

// 予約確定処理
async function submitReservationConfirmation() {
	const data = {
		visit_date: props.visitDate,
		visit_time: props.visitTime,
		number_of_guests: props.numberOfGuests,
		reservation_id: props.reservationId,
		reservation_fee: props.reservationFee,
		restaurant_id: props.restaurantId
	}
	
	try {
		const response = await axios.post(`/reservations`, data)
		if (response.data.redirect_to) {
			window.location.href = response.data.redirect_to
		}
	} catch (error) {
		console.error("Error:", error)
	}
}

const showModal = ref(false)
</script>



<template>
    <div class="d-flex justify-content-center">
        <button id="show-modal" @click="showModal = true" class="btn submit-button" style="width: 50%">
            <i class="fas fa-utensils me-3"></i>
            予約する
        </button>
    
        <Teleport to="body">
            <Modal :show="showModal" @close="showModal = false">
                <template #header>
                    <h3>予約内容の確認</h3>
                </template>
                <template #body>
                    予約を確定してもいいですか？
                </template>
                <template #footer>
                    <div class="d-flex justify-content-between" style="width: 100%;">
                        <button @click="submitReservationConfirmation" class="btn submit-button">予約確定</button>
                        <button @click="showModal = false" class="btn submit-button" style="background-color: #f16363;">キャンセル</button>
                    </div>
                </template>
            </Modal>
        </Teleport>
    </div>
</template>
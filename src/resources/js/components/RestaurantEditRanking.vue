<script setup>
import Modal from './Modal.vue'
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    categoryName: String,
    categoryId: Number,
    reservations: Array,
    reviews: Object
})

const selectedRanking1 = ref(null)
const selectedRanking2 = ref(null)
const selectedRanking3 = ref(null)
const showModal = ref(false)

onMounted(() => {
    // 1位のレビュー
    const review1 = props.reviews.find(review => review.score === 5)
    if (review1) {
        selectedRanking1.value = review1.reservation_id
        reviews.value[review1.reservation_id] = review1.content
    }

    // 2位のレビュー
    const review2 = props.reviews.find(review => review.score === 4)
    if (review2) {
        selectedRanking2.value = review2.reservation_id
        reviews.value[review2.reservation_id] = review2.content
    }

    // 3位のレビュー
    const review3 = props.reviews.find(review => review.score === 3)
    if (review3) {
        selectedRanking3.value = review3.reservation_id
        reviews.value[review3.reservation_id] = review3.content
    }

    // 4位以降のレビュー
    props.reviews.filter(review => review.score < 3).forEach(review => {
            reviews.value[review.reservation_id] = review.content
    })
})

function updateSelectedRanking(event, rankingNumber, reservationId) {
    const isChecked = event.target.checked

    if (rankingNumber === 1) {
        selectedRanking1.value = isChecked ? reservationId : null
    } else if (rankingNumber === 2) {
        selectedRanking2.value = isChecked ? reservationId : null
    } else if (rankingNumber === 3) {
        selectedRanking3.value = isChecked ? reservationId : null
    }
}

const isButtonDisabled = computed(() => {
    return selectedRanking1.value === null ||
           selectedRanking2.value === null ||
           selectedRanking3.value === null ||
           !reviews.value[selectedRanking1.value] ||
           !reviews.value[selectedRanking2.value] ||
           !reviews.value[selectedRanking3.value]
})

const reviews = ref({})

async function saveRankingAndReviews() {
    const rankings = [
        { 
            score: 5, 
            restaurantId: getRestaurantId(selectedRanking1.value), 
            reservationId: selectedRanking1.value, 
            review: reviews.value[selectedRanking1.value],
            categoryId: getCategoryId(selectedRanking1.value)
        },
        { 
            score: 4, 
            restaurantId: getRestaurantId(selectedRanking2.value), 
            reservationId: selectedRanking2.value, 
            review: reviews.value[selectedRanking2.value],
            categoryId: getCategoryId(selectedRanking2.value)
        },
        { 
            score: 3, 
            restaurantId: getRestaurantId(selectedRanking3.value), 
            reservationId: selectedRanking3.value, 
            review: reviews.value[selectedRanking3.value],
            categoryId: getCategoryId(selectedRanking3.value)
        },
    ]
    
    try {
        const response = await axios.post('/reviews/update', { rankings })
        if (response.data.redirect_to) {
            window.location.href = response.data.redirect_to
        }
    } catch (error) {
        console.error('An error occurred while saving rankings!', error)
    }
}

function getRestaurantId(reservationId) {
    const reservation = props.reservations.find(r => r.id === reservationId)
    return reservation ? reservation.restaurant_id : null
}

function getCategoryId(reservationId) {
    const reservation = props.reservations.find(r => r.id === reservationId);
    return reservation ? reservation.restaurant.category_id : null;
}

async function deleteRankingAndReviews() {
    const category_id = props.categoryId

    try {
        const response = await axios.post('/reviews/delete_ranking', { category_id })
        if (response.data.redirect_to) {
            window.location.href = response.data.redirect_to;
        }
    } catch (error) {
        console.error('An error occurred while deleting rankings!', error);
    }
}
</script>



<template>
    <h2 class="mt-3 mb-4" style="font-weight: bold;">{{ props.categoryName }}ジャンルのランキングの修正</h2>
    <h3 style="font-weight: bold;" class="mt-3">店舗一覧</h3>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th class="align-middle text-center" scope="col"><span class="first-ranked">1</span></th>
                <th class="align-middle text-center" scope="col"><span class="second-ranked">2</span></th>
                <th class="align-middle text-center" scope="col"><span class="third-ranked">3</span></th>
                <th class="align-middle text-center" scope="col">店舗画像</th>
                <th class="align-middle text-center" scope="col">店舗名</th>
                <th class="align-middle text-center" scope="col">口コミ</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="reservation in props.reservations" :key="reservation.id">
                <td class="align-middle text-center">
                    <input type="checkbox" 
                        :disabled="selectedRanking1 !== null && selectedRanking1 !== reservation.id || (selectedRanking2 === reservation.id || selectedRanking3 === reservation.id)"
                        :checked="selectedRanking1 === reservation.id"
                        @change="updateSelectedRanking($event, 1, reservation.id)">
                </td>
                <td class="align-middle text-center">
                    <input type="checkbox" 
                        :disabled="selectedRanking2 !== null && selectedRanking2 !== reservation.id || (selectedRanking1 === reservation.id || selectedRanking3 === reservation.id)"
                        :checked="selectedRanking2 === reservation.id"
                        @change="updateSelectedRanking($event, 2, reservation.id)">
                </td>
                <td class="align-middle text-center">
                    <input type="checkbox" 
                        :disabled="selectedRanking3 !== null && selectedRanking3 !== reservation.id || (selectedRanking1 === reservation.id || selectedRanking2 === reservation.id)"
                        :checked="selectedRanking3 === reservation.id"
                        @change="updateSelectedRanking($event, 3, reservation.id)">
                </td>
                <td class="align-middle text-center"><img class="square-image" :src="`/${reservation.restaurant.image}`" alt="店舗画像"></td>
                <td class="align-middle text-center">{{ reservation.restaurant.name }}</td>
                <td class="align-middle text-center">
                    <textarea 
                        v-if="reservation.id === selectedRanking1 || reservation.id === selectedRanking2 || reservation.id === selectedRanking3"
                        class="fullsize-textarea"
                        rows="4" 
                        v-model="reviews[reservation.id]" 
                        placeholder="口コミを入力する">
                    </textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row justify-content-center">
        <button :disabled="isButtonDisabled" 
                @click="saveRankingAndReviews" 
                class="btn submit-button mt-3 me-5 w-25">
            ランキング登録
        </button>
        <button @click="showModal = true" 
                class="btn btn-danger mt-3 w-25">
            ランキング削除
        </button>
        <Teleport to="body">
            <Modal :show="showModal" @close="showModal = false">
                <template #header>
                    <h3>ランキング削除の確認</h3>
                </template>
                <template #body>
                    削除してもいいですか？
                </template>
                <template #footer>
                    <div class="d-flex justify-content-between" style="width: 100%;">
                        <button @click="showModal = false" class="btn submit-button">キャンセル</button>
                        <button @click="deleteRankingAndReviews" class="btn submit-button" style="background-color: #f16363;">削除する</button>
                    </div>
                </template>
            </Modal>
        </Teleport>
    </div>
</template>



<style>
.first-ranked {
    font-size:1.5em;
	text-align:center;
	font-weight:bold;
	color: transparent;
	background: repeating-linear-gradient(0deg, #B67B03 0%, #DAAF08 45%, #FEE9A0 70%, #DAAF08 85%, #B67B03 90% 100%);
	-webkit-background-clip: text;
}

.second-ranked {
    font-size:1.5em;
	text-align:center;
	font-weight:bold;
	color: transparent;
	background: repeating-linear-gradient(0deg, #757575 0%, #9E9E9E 45%, #E8E8E8 70%, #9E9E9E 85%, #757575 90% 100%); 
	-webkit-background-clip: text;
}

.third-ranked {
    font-size:1.5em;
	text-align:center;
	font-weight:bold;
	color: transparent;
	background: repeating-linear-gradient(0deg, #a57e65 0%, #a57e65 45%, #f3cfb8 70%, #a57e65 85%, #a57e65 90% 100%);
	-webkit-background-clip: text;
}

.text-center {
    text-align: center;
}

.align-middle {
    vertical-align: middle;
}

.square-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
}

.fullsize-textarea {
    width: 100%;
    height: 100%;
    resize: none;
    border: 1px solid #aaaaaa;
    border-radius: 4px;
    box-sizing: border-box;
    margin: 0;
    padding: 8px;
    background-color: #f0f0f0;
}
</style>
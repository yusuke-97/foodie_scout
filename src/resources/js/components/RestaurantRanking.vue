<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    categories: Array,
    reservations: Array,
    reviews: Object
})

const selectedCategory = ref([])

const filteredReservations = computed(() => {
    return props.reservations.filter(reservation => 
        selectedCategory.value.includes(reservation.restaurant.category_id)
    )
})

const selectedRanking1 = ref(null)
const selectedRanking2 = ref(null)
const selectedRanking3 = ref(null)

onMounted(() => {
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
        const response = await axios.post('/reviews/store', { rankings })
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
</script>



<template>
    <h2 class="mt-3 mb-4" style="font-weight: bold; font-size: 16px;">ランキングの作成</h2>
    <div class="categories-container">
        <div v-if="categories.length > 0" class="category" v-for="category in categories" :key="category.id">
            <input type="checkbox" 
                v-model="selectedCategory" 
                :value="category.id" 
                class="me-2" 
                :disabled="selectedCategory.length > 0 && !selectedCategory.includes(category.id)">
            <label>{{ category.name }}</label>
        </div>
        <div v-else>
            <p class="m-0">ランキング作成できるカテゴリーが存在しません</p>
        </div>
    </div>
    <h3 v-if="selectedCategory.length > 0" style="font-weight: bold;" class="mt-3">店舗一覧</h3>
    <table class="table table-bordered mt-4">
        <thead v-if="selectedCategory.length > 0">
            <tr>
                <th class="align-middle text-center" scope="col"><span class="first-ranked">1</span></th>
                <th class="align-middle text-center" scope="col"><span class="second-ranked">2</span></th>
                <th class="align-middle text-center" scope="col"><span class="third-ranked">3</span></th>
                <th class="align-middle text-center" scope="col">店舗名</th>
                <th class="align-middle text-center" scope="col">口コミ</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="reservation in filteredReservations" :key="reservation.id">
                <td class="align-middle text-center">
                    <input type="checkbox" 
                        :disabled="selectedRanking1 !== null && selectedRanking1 !== reservation.id || (selectedRanking2 === reservation.id || selectedRanking3 === reservation.id)"
                        @change="updateSelectedRanking($event, 1, reservation.id)">
                </td>
                <td class="align-middle text-center">
                    <input type="checkbox" 
                        :disabled="selectedRanking2 !== null && selectedRanking2 !== reservation.id || (selectedRanking1 === reservation.id || selectedRanking3 === reservation.id)"
                        @change="updateSelectedRanking($event, 2, reservation.id)">
                </td>
                <td class="align-middle text-center">
                    <input type="checkbox" 
                        :disabled="selectedRanking3 !== null && selectedRanking3 !== reservation.id || (selectedRanking1 === reservation.id || selectedRanking2 === reservation.id)"
                        @change="updateSelectedRanking($event, 3, reservation.id)">
                </td>
                <td class="align-middle text-center">
                    <img class="square-image" :src="`/${reservation.restaurant.image}`" alt="店舗画像">
                    <p class="mb-0">{{ reservation.restaurant.name }}</p>
                </td>
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
    <div v-if="selectedCategory.length > 0" class="row justify-content-center">
        <button :disabled="isButtonDisabled" 
                @click="saveRankingAndReviews" 
                class="btn submit-button mt-3 col-4 col-md-3 col-lg-2">
            ランキング登録
        </button>
    </div>
</template>



<style>
.categories-container {
    display: flex;
    flex-wrap: wrap;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
}

.category {
    margin-right: 48px;
    margin-bottom: 16px;
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
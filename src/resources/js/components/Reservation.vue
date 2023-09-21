<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'

const props = defineProps({
  restaurantId: Number,
  restaurantName: String,
  restaurantPrice: Number,
  imgSrc: String
})

const visit_datetime = ref(null);
const number_of_guests = ref(0);

const totalPrice = computed(() => {
    return number_of_guests.value * props.restaurantPrice;
});

async function submitReservation() {
    const data = {
        visit_datetime: visit_datetime.value,
        number_of_guests: number_of_guests.value,
        reservation_fee: totalPrice.value * 0.5,
        restaurant_id: props.restaurantId
    };
    try {
        const response = await axios.post(`/reservations`, data)
        if (response.data.redirect_to) {
            window.location.href = response.data.redirect_to;
        }
    } catch (error) {
        console.error("Error:", error);
    }
}
</script>

<template>
    <div class="row">
        <div class="col-md-2 mt-2">
            <img :src="props.imgSrc" class="img-fluid w-100">
        </div>
        <div class="col-md-4 mt-4">
            <h3 class="mt-4">{{ props.restaurantName }}</h3>
        </div>
        <div class="col-md-2">
            <input type="datetime-local" v-model="visit_datetime" class="form-control">
        </div>
        <div class="col-md-2">
            <input type="number" v-model="number_of_guests" class="form-control">
        </div>
        <div class="col-md-2">
            <h3 class="w-100 mt-4">¥{{ totalPrice }}</h3>
        </div>
    </div>

    <hr>

    <div class="offset-8 col-4">
        <div class="row">
            <div class="col-6">
                <h2>予約料金</h2>
            </div>
            <div class="col-6">
                <h2>￥{{ totalPrice * 0.5 }}</h2>
            </div>
            <div class="col-12 d-flex justify-content-end">     
                50%の予約料金を頂いております。
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-3">
        <button @click="submitReservation" class="btn submit-button">予約を確定する</button> 
    </div>   
</template>
<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'
import { Calendar, DatePicker } from 'v-calendar'
import 'v-calendar/style.css'

const props = defineProps({
  restaurantId: Number,
  restaurantName: String,
  restaurantPrice: Number,
  imgSrc: String
})

const today = new Date()
const yesterday = new Date(today)
yesterday.setDate(yesterday.getDate() - 1)

const visit_datetime = ref(null)
const number_of_guests = ref(0)

const masks = ref({
    title: 'YYYY年 MMMM',
})

// 次の土曜日までの日数を計算
const daysUntilSaturday = (6 - today.getDay() + 7) % 7 || 7

// 次の日曜日までの日数を計算
const daysUntilSunday = (7 - today.getDay() + 7) % 7 || 7

// 次の土曜日の日付を取得
const nextSaturday = new Date(today)
nextSaturday.setDate(today.getDate() + daysUntilSaturday)

// 次の日曜日の日付を取得
const nextSunday = new Date(today)
nextSunday.setDate(today.getDate() + daysUntilSunday)

const attributes = ref([
  {
    key: 'past-date',
    content: { class: 'past-date-symbol' },
    dates: {
      end: yesterday,
    }
  },
  {
    key: 'dot',
    content: { class: 'custom-dot' },
    dates: {
      start: today,
    },
  },
  {
    key: 'sunday',
    content: { color: 'red', class: 'custom-dot' }, 
    dates: {
      start: nextSunday,
      repeat: {
        weekdays: 1,
      },
    },
  },
  {
    key: 'saturday',
    content: { color: 'blue', class: 'custom-dot' }, 
    dates: {
      start: nextSaturday,
      repeat: {
        weekdays: 7,
      },
    },
  },
])

const totalPrice = computed(() => {
    return number_of_guests.value * props.restaurantPrice
})

async function submitReservation() {
    const data = {
        visit_datetime: visit_datetime.value,
        number_of_guests: number_of_guests.value,
        reservation_fee: totalPrice.value * 0.5,
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
</script>

<template>
    <div class="my-calendar">
        <Calendar :min-date="new Date()" :attributes="attributes" :masks="masks" />
    </div>
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
            <input type="number" v-model="number_of_guests" class="form-control" min="0">
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

<style>
/* カレンダーのスタイル */
.my-calendar .vc-calendar {
    font-size: 1.2em;
}

.my-calendar .vc-day {
    padding: 0.5em;
}

.my-calendar .vc-weekday-header {
    padding: 1em 0;
}

.my-calendar .vc-header {
    padding: 1.5em 0;
    font-size: 1.4em;
}

.my-calendar .custom-dot.vc-day-content::after {
    width: 12px;
    height: 12px;
    bottom: -5px;
}

.my-calendar .vc-weekday-1 {
    color: #f16363;
}

.my-calendar .vc-weekday-7 {
    color: #6366f1;
}

.my-calendar .past-date-symbol.vc-day-content::after {
  content: '-';
  display: block;
  position: absolute;
  bottom: -11px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 32px;
  color: #bbb;
}

.my-calendar .custom-dot.vc-day-content::after {
  content: '';
  display: block;
  width: 16px;
  height: 16px;
  background-color: white;
  border: 3px solid #0fbe9f;
  border-radius: 50%;
  position: absolute;
  bottom: -8px;
  left: 50%;
  transform: translateX(-50%);
}
</style>
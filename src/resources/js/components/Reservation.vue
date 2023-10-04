<script setup>
import { ref, computed, onMounted } from 'vue'
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

const selectedDate = ref(today)

const number_of_guests = ref(1)

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

const formattedTotalPrice = computed(() => {
    const price = totalPrice.value * 0.5
    return new Intl.NumberFormat('ja-JP').format(price)
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


const selectBoxWidth = ref("")

onMounted(() => {
    const elementWidth = document.querySelector(".vc-container").offsetWidth
    selectBoxWidth.value = `${elementWidth}px`
})

const timeOptions = (() => {
  const times = []
  for (let i = 18; i <= 24; i++) {
    times.push(`${i.toString().padStart(2, '0')}:00`)
    if (i !== 24) {
      times.push(`${i.toString().padStart(2, '0')}:30`)
    }
  }
  return times
})()
const visit_datetime = ref(timeOptions[0])
</script>



<template>
    <div class="my-calendar">
        <DatePicker
            :min-date="new Date()"
            :attributes="attributes"
            :masks="masks"
            :color="'green'"
            v-model="selectedDate"
            mode="date" />
    </div>
    <div class="select-wrapper pt-3" :style="{ width: selectBoxWidth }">
        <label class=" ms-3 me-5">人数</label>
        <select v-model="number_of_guests" class="guest-select me-3">
            <option v-for="n in 10" :key="n" :value="n">{{ n }}名</option>
        </select>
    </div>
    <div class="select-wrapper pt-3" :style="{ width: selectBoxWidth }">
        <label class="ms-3 me-5">時間</label>
        <select v-model="visit_datetime" class="time-select me-3">
            <option v-for="time in timeOptions" :key="time" :value="time">{{ time }}</option>
        </select>
    </div>

    <hr :style="{ width: selectBoxWidth }">

    <div class="d-flex justify-content-between align-items-center p-3" :style="{ width: selectBoxWidth }">
        <label style="font-size: 18px">予約料金</label>
        <span style="font-size: 24px">¥{{ formattedTotalPrice }}</span>
    </div>

    <hr :style="{ width: selectBoxWidth }">

    <div class="p-3" :style="{ width: selectBoxWidth }">
        ※ 1名様あたり、ご予算の50%を予約料金として頂いております。 
    </div>

    <div class="d-flex justify-content-center p-3" :style="{ width: selectBoxWidth }">
        <button @click="submitReservation" class="btn submit-button" style="width: 100%">予約する</button> 
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


/* セレクトボックスのスタイル */
.select-wrapper {
    display: flex;
    align-items: center;
}

.select-wrapper select {
    flex-grow: 1;
    max-width: calc(100% - 50px);
}
</style>
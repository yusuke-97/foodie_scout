<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { Calendar, DatePicker } from 'v-calendar'
import 'v-calendar/style.css'

const props = defineProps({
  restaurantId: Number,
  restaurantPhoneNumber: String,
  restaurantPrice: Number,
  restaurantSeat: Number,
  restaurantStartTime: String,
  restaurantEndTime: String
})

const GOOGLE_API_KEY = 'AIzaSyB4nWI9Eagle-87B_5k0DCzxlu26C1r2Iw'

async function fetchJapaneseHolidays(year) {
  const url = `https://www.googleapis.com/calendar/v3/calendars/ja.japanese%23holiday%40group.v.calendar.google.com/events?key=${GOOGLE_API_KEY}`
  try {
    const response = await axios.get(url)
    return response.data.items.map(event => event.start.date)
  } catch (error) {
    console.error("Error fetching Japanese holidays:", error)
    return [];
  }
}

onMounted(async () => {
  const holidays = await fetchJapaneseHolidays(today.getFullYear())
  attributes.value.push({
    key: 'holiday',
    content: { color: 'red', class: 'custom-dot' },
    dates: holidays
  })
})

const today = new Date()
const tomorrow = new Date(today)
tomorrow.setDate(tomorrow.getDate() + 1)

const number_of_guests = ref(1)
const visit_date = ref(tomorrow)

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
      end: today,
    }
  },
  {
    key: 'dot',
    content: { class: 'custom-dot' },
    dates: {
      start: tomorrow,
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
        visit_date: visit_date.value,
        visit_time: visit_time.value,
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
  const startHour = parseInt(props.restaurantStartTime.split(":")[0])
  let endHour = parseInt(props.restaurantEndTime.split(":")[0])
  const endMinutes = parseInt(props.restaurantEndTime.split(":")[1])

  if (endHour >= 0 && endHour <= 2) {
    endHour += 24
  }
  endHour -= 2
  
  for (let i = startHour; i <= endHour; i++) {
    times.push(`${i.toString().padStart(2, '0')}:00`)
    if (i !== endHour || (i === endHour && endMinutes > 0)) {
      times.push(`${i.toString().padStart(2, '0')}:30`)
    }
  }

  return times
})()

const visit_time = ref(timeOptions[0])

const availableTimes = ref(null)

async function fetchAvailableTimes() {
    try {
        const response = await axios.get(`/available-seats`, {
            params: {
                visit_date: visit_date.value,
                start_time: props.restaurantStartTime,
                end_time: props.restaurantEndTime,
                restaurant_id: props.restaurantId
            }
        })

        const reservedSeatsData = response.data.reserved_seats

        // fetchAvailableTimes 関数内の該当部分
        availableTimes.value = timeOptions.filter(time => {
            const reservedSeats = reservedSeatsData[time] || 0
            const availableSeats = props.restaurantSeat - reservedSeats - number_of_guests.value
            return availableSeats >= 0
        })

    } catch (error) {
        console.error("Error fetching available seats:", error)
    }
}

onMounted(fetchAvailableTimes)

watch([visit_date, visit_time, number_of_guests], fetchAvailableTimes)
</script>



<template>
    <div class="p-3">
        <h4 style="font-weight: bold;">
            <i class="fas fa-phone me-2"></i>
            {{ props.restaurantPhoneNumber }}
        </h4>
    </div>
    <div class="d-flex justify-content-center" style="background-color: #0fbe9f;" :style="{ width: selectBoxWidth }">
        <h5 class="m-2" style="font-weight: bold; color: white;">ネット予約</h5>
    </div>
    <div class="my-calendar">
        <DatePicker
            :min-date="tomorrow"
            :attributes="attributes"
            :masks="masks"
            v-model="visit_date"
            mode="date" />
    </div>
    <div class="select-wrapper pt-3" v-if="availableTimes" :style="{ width: selectBoxWidth }">
        <label class=" ms-3 me-5">人数</label>
        <select v-model.number="number_of_guests" class="guest-select me-3">
            <option v-for="n in props.restaurantSeat" :key="n" :value="n">{{ n }}名</option>
        </select>
    </div>
    <div class="select-wrapper pt-3" v-if="availableTimes" :style="{ width: selectBoxWidth }">
    <label class="ms-3 me-5">時間</label>
        <select v-model="visit_time" class="time-select me-3">
            <option v-for="time in timeOptions" :key="time" :value="time" :disabled="!availableTimes.includes(time)">
                <template v-if="availableTimes.includes(time)">
                    <span>◯</span>
                </template>
                <template v-else>
                    <span>×</span>
                </template>
                {{ time }}
            </option>
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
        <button @click="submitReservation" class="btn submit-button" style="width: 100%">
          <i class="fas fa-utensils me-3"></i>
          予約する
        </button> 
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

.my-calendar .vc-highlight-content-solid {
    background-color: #0fbe9f;
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
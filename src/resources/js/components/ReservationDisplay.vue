<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { Calendar, DatePicker } from 'v-calendar'
import 'v-calendar/style.css'

// 定義したプロパティ
const props = defineProps({
  restaurantId: Number,
  restaurantName: String,
  restaurantPhoneNumber: String,
  restaurantPrice: Number,
  restaurantSeat: Number,
  restaurantStartTime: String,
  restaurantEndTime: String,
  restaurantClosedDay: String,
  userPointBalance: Number
})

// 今日と明日の日付
const today = new Date()
const tomorrow = new Date(today)
tomorrow.setDate(tomorrow.getDate() + 1)

// 初期値の設定
const numberOfGuests = ref(1)
const visitDate = ref(tomorrow)
const masks = ref({
    title: 'YYYY年 MMMM',
})

// 休業日の曜日を取得
const closedDay = parseInt(props.restaurantClosedDay)
const GOOGLE_API_KEY = 'AIzaSyB4nWI9Eagle-87B_5k0DCzxlu26C1r2Iw'

// 日本の祝日を取得
async function fetchJapaneseHolidays(year) {
  const url = `https://www.googleapis.com/calendar/v3/calendars/ja.japanese%23holiday%40group.v.calendar.google.com/events?key=${GOOGLE_API_KEY}`
  try {
    const response = await axios.get(url)
    return response.data.items.map(event => event.start.date)
  } catch (error) {
    console.error("Error fetching Japanese holidays:", error)
    return []
  }
}

// 祝日と休業日のカレンダー表示設定
onMounted(async () => {
  const holidays = await fetchJapaneseHolidays(today.getFullYear())
  const futureHolidays = holidays.filter(date => new Date(date) >= today)
  for (let futureHoliday in futureHolidays) {
    const date = new Date(futureHoliday)
    const dayOfWeek = date.getDay()
    if (dayOfWeek === closedDay + 1) {
      attributes.value.push({
        key: 'holiday-closed-day',
        content: { color: 'red', class: 'closed-day-symbol' },
        dates: futureHolidays
      })
    } else {
      attributes.value.push({
        key: 'holiday',
        content: { color: 'red' },
        dates: futureHolidays
      })
    }
  }
})

// カレンダー属性（過去の日付）
const attributes = ref([
  {
    key: 'past-date',
    content: { class: 'past-date-symbol' },
    dates: {
      end: today,
    }
  },
])

// 予約可能な時間帯かどうかの判定
const isReservableTime = computed(() => {
  if (!availableTimes.value) {
    return false
  } else {
    return availableTimes.value.includes(visitTime.value)
  }
})

// ドロップダウンの幅を設定
const selectBoxWidth = ref("")
onMounted(() => {
    const elementWidth = document.querySelector(".vc-container").offsetWidth
    selectBoxWidth.value = `${elementWidth}px`
})

// 予約可能な時間帯の選択肢を計算
const timeOptions = (() => {
  const times = []
  const startHour = parseInt(props.restaurantStartTime.split(":")[0])
  const startMinutes = parseInt(props.restaurantStartTime.split(":")[1])
  let endHour = parseInt(props.restaurantEndTime.split(":")[0])
  const endMinutes = parseInt(props.restaurantEndTime.split(":")[1])

  if (endHour >= 0 && endHour <= 2) {
    endHour += 24
  }
  endHour -= 2

  let currentMinute = startMinutes
  
  for (let i = startHour; i <= endHour; i++) {
    if(currentMinute === 60) {
      currentMinute = 0
    }
    while(currentMinute < 60) {
      times.push(`${i.toString().padStart(2, '0')}:${currentMinute.toString().padStart(2, '0')}`)
      if (i === endHour && currentMinute >= endMinutes) {
        break
      }
      currentMinute += 30
    }
    currentMinute = 0
  }
  return times
})()


const visitTime = ref(timeOptions[0])
const availableTimes = ref(null)
let cachedVisitDate = null
let lastFetched = 0
const CancelToken = axios.CancelToken
let cancel

// 利用可能な時間帯をAPIから取得
async function fetchAvailableTimes() {
  // 既存のリクエストがあればキャンセル
  if (cancel) {
    cancel()
  }

  try {
    const now = Date.now()
    const delay = 500
    if (now - lastFetched < delay) {
      return
    }
    lastFetched = now

    function getLocalDate(date) {
      const year = date.getFullYear()
      const month = (date.getMonth() + 1).toString().padStart(2, '0')
      const day = date.getDate().toString().padStart(2, '0')
      return `${year}-${month}-${day}`
    }

    const selectedDate = getLocalDate(new Date(visitDate.value ? visitDate.value : cachedVisitDate))
    const originalSelectedDate = new Date(visitDate.value ? visitDate.value : cachedVisitDate).getDay()

    const response = await axios.get(`/available-seats`, {
      cancelToken: new CancelToken(function executor(c) {
        cancel = c
      }),
      params: {
        visit_date: selectedDate,
        start_time: props.restaurantStartTime,
        end_time: props.restaurantEndTime,
        restaurant_id: props.restaurantId
      }
    })
    cachedVisitDate = selectedDate
    const reservedSeatsData = response.data.reserved_seats

    if (originalSelectedDate === closedDay) {
      cachedVisitDate = selectedDate
      availableTimes.value = []
      return
    }

    availableTimes.value = timeOptions.filter(time => {
      const reservedSeats = reservedSeatsData[time] || 0
      const availableSeats = props.restaurantSeat - reservedSeats - numberOfGuests.value
      return availableSeats >= 0
    })

  } catch (error) {
    if (axios.isCancel(error)) {
      console.log('Request canceled')
    } else {
      console.error("Error fetching available seats:", error)
    }
  }
}


const dailyAvailability = ref({})
let year = tomorrow.getFullYear()
let month = tomorrow.getMonth()

month += 2
if (month > 11) {
  month -= 12
  year++
}

const endOfMonth = new Date(year, month + 1, 1)
const maxMonth = new Date(year, month + 1, 0)

// 日別の利用可能情報をAPIから取得
async function fetchAvailableDays() {
  try {
    const response = await axios.get(`/available-days`, {
      params: {
        start_date: tomorrow,
        end_date: endOfMonth,
        start_time: props.restaurantStartTime,
        end_time: props.restaurantEndTime,
        restaurant_id: props.restaurantId,
        restaurant_seat: props.restaurantSeat
      }
    })

    dailyAvailability.value = response.data

    const holidays = await fetchJapaneseHolidays(today.getFullYear())

    for (let formattedDate in dailyAvailability.value) {
      const date = new Date(formattedDate)
      const dayOfWeek = date.getDay()
      const isHoliday = holidays.includes(formattedDate)
    if (dayOfWeek === closedDay) {
      attributes.value.push({
        key: 'closed-day',
        content: { class: 'closed-day-symbol'},
        dates: {
          start: formattedDate,
          end: formattedDate
        }
      })
    } else if (dailyAvailability.value[formattedDate] === true) {
      if (dayOfWeek === 6) {
        attributes.value.push({
          key: 'full-saterday',
          content: {
            class: 'full-booked-symbol',
            color: 'blue'
          },
          dates: {
            start: formattedDate,
            end: formattedDate
          }
        })
      } else if (dayOfWeek === 0  || isHoliday === true) {
        attributes.value.push({
          key: 'full-sunday-holiday',
          content: {
            class: 'full-booked-symbol',
            color: 'red'
          },
          dates: {
            start: formattedDate,
            end: formattedDate
          }
        })
      } else {
        attributes.value.push({
          key: 'full',
          content: { class: 'full-booked-symbol'},
          dates: {
            start: formattedDate,
            end: formattedDate
          }
        })
      }
    } else if (dailyAvailability.value[formattedDate] === false) {
        if (dayOfWeek === 6) {
          attributes.value.push({
            key: 'available-saterday',
            content: {
              class: 'available-symbol',
              color: 'blue'
            },
            dates: {
              start: formattedDate,
              end: formattedDate
            }
          })
        } else if (dayOfWeek === 0 || isHoliday === true) {
          attributes.value.push({
            key: 'available-sunday-holiday',
            content: {
              class: 'available-symbol',
              color: 'red'
            },
            dates: {
              start: formattedDate,
              end: formattedDate
            }
          })
        } else {
          attributes.value.push({
            key: 'available',
            content: { class: 'available-symbol' },
            dates: {
              start: formattedDate,
              end: formattedDate
            }
          })
        }
      }
    }

  } catch (error) {
    console.error("Error fetching daily availability:", error)
  }
}

// ページが読み込まれた時に利用可能日と時間帯を取得
onMounted(() => {
  fetchAvailableDays()
  fetchAvailableTimes()
})

// 予約日、時間、人数が変更された時に利用可能時間帯を更新
watch([visitDate, visitTime, numberOfGuests], fetchAvailableTimes)

// 合計価格を計算
const totalPrice = computed(() => {
    return numberOfGuests.value * props.restaurantPrice
})

const formattedTotalPrice = computed(() => {
    const price = totalPrice.value * 0.5
    return new Intl.NumberFormat('ja-JP').format(price)
})

const isPointBalanceLow = computed(() => {
  return props.userPointBalance < totalPrice.value * 0.5
})

// 予約情報送信処理
async function submitReservationDisplay() {
  const data = {
    visit_date: visitDate.value,
    visit_time: visitTime.value,
    number_of_guests: numberOfGuests.value,
    reservation_fee: totalPrice.value * 0.5,
    restaurant_id: props.restaurantId,
    restaurant_name: props.restaurantName
  }
  try {
    const response = await axios.post(`/reservation/prepare`, data)
    if (response.data.redirect_to) {
      window.location.href = response.data.redirect_to
    }
  } catch (error) {
    console.error("Error:", error)
  }
}
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
            :max-date="maxMonth"
            :attributes="attributes"
            :masks="masks"
            v-model="visitDate"
            mode="date" />
    </div>
    <div class="select-wrapper pt-3" v-if="availableTimes" :style="{ width: selectBoxWidth }">
        <label class=" ms-3 me-5">人数</label>
        <select v-model.number="numberOfGuests" class="guest-select me-3">
            <option v-for="n in props.restaurantSeat" :key="n" :value="n">{{ n }}名</option>
        </select>
    </div>
    <div class="select-wrapper pt-3" v-if="availableTimes" :style="{ width: selectBoxWidth }">
    <label class="ms-3 me-5">時間</label>
        <select v-model="visitTime" class="time-select me-3">
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
        <span style="font-size: 24px">{{ formattedTotalPrice }}P</span>
    </div>
    <div class="d-flex justify-content-between align-items-center p-3" :style="{ width: selectBoxWidth }">
        <label style="font-size: 14px">
          <i class="fas fa-coins"></i>
          ポイント残高
        </label>
        <span style="font-size: 20px">{{ new Intl.NumberFormat('ja-JP').format(userPointBalance) }}P</span>
    </div>
    <div v-if="isPointBalanceLow" class="text-danger p-3" :style="{ width: selectBoxWidth }">
      ポイントが足りません
      <br>
      <a href="/users/mypage/charge" style="color: #0fbe9f;">ポイントをチャージする</a>
    </div>

    <hr :style="{ width: selectBoxWidth }">

    <div class="p-3" :style="{ width: selectBoxWidth }">
        ※ 1名様あたり、ご予算の50%を予約料金として頂いております。 
    </div>

    <div class="d-flex justify-content-center p-3" :style="{ width: selectBoxWidth }">
      <button @click="submitReservationDisplay" class="btn submit-button" style="width: 100%" :disabled="!isReservableTime || isPointBalanceLow">
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

.my-calendar .vc-header {
    padding: 1.5em 0;
    font-size: 1.4em;
}

.my-calendar .vc-weeks {
    margin-bottom: 1rem;
}

.my-calendar .vc-weekday-1 {
    color: #f16363;
}

.my-calendar .vc-weekday-7 {
    color: #6366f1;
}

.my-calendar .vc-day {
    padding: 0.5em;
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

.my-calendar .full-booked-symbol.vc-day-content::after {
  content: '×';
  display: block;
  position: absolute;
  bottom: -13px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 24px;
  color: #bbb;
  font-weight: bold;
}

.my-calendar .available-symbol.vc-day-content::after {
  content: '⚪︎';
  display: block;
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 22px;
  color: #0fbe9f;
  text-shadow: 
    -1px 0 #0fbe9f,
    1px 0 #0fbe9f,
    0 1px #0fbe9f,
    0 -1px #0fbe9f;
}

.my-calendar .closed-day-symbol.vc-day-content::after {
  content: '休';
  display: block;
  position: absolute;
  bottom: -14px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 16px;
  color: #bbb;
  font-weight: bold;
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
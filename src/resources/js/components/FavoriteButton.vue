<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  isFavorited: Boolean,
  restaurantId: Number
})

const localIsFavorited = ref(props.isFavorited);

const toggleFavorite = async () => {
  try {
    let response;
    if (localIsFavorited.value) {
      // お気に入り済みの場合はお気に入りを解除する
      response = await axios.delete(`/restaurants/${props.restaurantId}/favorite`);
    } else {
      // まだお気に入りではない場合はお気に入りに追加する
      response = await axios.post(`/restaurants/${props.restaurantId}/favorite`);
    }
    if (response.data.status === 'added' || response.data.status === 'removed') {
      localIsFavorited.value = !localIsFavorited.value;
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
</script>

<template>
    <a 
        @click.prevent="toggleFavorite"
        class="btn favorite-button text-favorite"
        style="width: 130px; font-size: 12px;">
        <i class="fas fa-bookmark"></i>
        {{ localIsFavorited ? 'お気に入り解除' : 'お気に入り' }}
    </a>
</template>

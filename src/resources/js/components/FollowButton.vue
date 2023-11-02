<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  isFollowing: Boolean,
  followingId: Number
})

const localIsFollowing = ref(props.isFollowing);

const toggleFollow = async () => {
  try {
    let response;
    if (localIsFollowing.value) {
      // お気に入り済みの場合はお気に入りを解除する
      response = await axios.delete(`/unfollow/${props.followingId}`);
    } else {
      // まだお気に入りではない場合はお気に入りに追加する
      response = await axios.post(`/follow/${props.followingId}`);
    }
    if (response.data.status === 'follow' || response.data.status === 'unfollow') {
      localIsFollowing.value = !localIsFollowing.value;
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
</script>

<template>
    <a 
        @click.prevent="toggleFollow"
        class="btn submit-button mb-2"
        :style="{ 
          'background-color': localIsFollowing ? '#f0f0f0' : '#0fbe9f',
          'color': localIsFollowing ? '#000000' : '#ffffff'
        }"
        style="font-size: 12px;">
        <i class="fa fa-heart"></i>
        {{ localIsFollowing ? 'フォロー中' : 'フォローする' }}
    </a>
</template>

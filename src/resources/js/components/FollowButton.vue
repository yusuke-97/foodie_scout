<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  isFollowed: Boolean,
  userId: Number
})

const localIsFollowed = ref(props.isFollowed);

const toggleFollow = async () => {
  try {
    let response;
    if (localIsFollowed.value) {
      // お気に入り済みの場合はお気に入りを解除する
      response = await axios.delete(`/unfollow/${props.userId}`);
    } else {
      // まだお気に入りではない場合はお気に入りに追加する
      response = await axios.post(`/follow/${props.userId}`);
    }
    if (response.data.status === 'follow' || response.data.status === 'unfollow') {
      localIsFollowed.value = !localIsFollowed.value;
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
</script>

<template>
    <a 
        @click.prevent="toggleFollow"
        class="btn follow-button text-follow w-100">
        <i class="fa fa-heart"></i>
        {{ localIsFollowed ? 'フォロー解除' : 'フォロー' }}
    </a>
</template>

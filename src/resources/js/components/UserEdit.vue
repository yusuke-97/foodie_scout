<script setup>
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { ref, computed } from 'vue'

const props = defineProps({
    csrf: String,
    userImage: String,
    fullName: String,
    userName: String,
    userEmail: String,
    userPhoneNumber: String
})

const userImage = ref(props.userImage)
const fileInput = ref('')
const imageRemoved = ref(false)

const triggerFileInput = () => {
	if (fileInput.value) {
		fileInput.value.click()
	}
}

const uploadFile = (event) => {
	const selectedFile = event.target.files[0]
	if (selectedFile) {
		userImage.value = URL.createObjectURL(selectedFile)
		imageRemoved.value = false
	}
}

const processedUserImage = computed(() => {
	if (userImage.value && userImage.value.startsWith('blob:')) {
		return userImage.value
	} else if (userImage.value) {
		return `/storage/profile_images/${userImage.value}`
	}
	return ''
})

const removeProfileImage = () => {
	userImage.value = ''
	imageRemoved.value = true
}

const { errors, submitForm, defineInputBinds } = useForm({
	validationSchema: yup.object({
		name: yup.string().required('氏名を入力してください'),
		userName: yup.string().required('ユーザー名を入力してください'),
		email: yup.string().email('有効なメールアドレスを入力してください').required('メールアドレスを入力してください'),
		phone: yup.string().matches(/^[0-9]+$/, '数字を入力してください').required('電話番号を入力してください'),
	}),
	initialValues: {
		name: props.fullName,
		userName: props.userName,
		email: props.userEmail,
		phone: props.userPhoneNumber,
	},
})

const name = defineInputBinds('name')
const userName = defineInputBinds('userName')
const email = defineInputBinds('email')
const phone = defineInputBinds('phone')
</script>

<template>
    <h2 class="mt-3 mb-4" style="font-weight: bold;">会員情報の編集</h2>
    <form action="update" method="post" enctype="multipart/form-data" @submit="submitForm">
        <div class="form-group mb-4">
            <label>プロフィール画像</label>
            <br>
            <div class="profile-image-container mb-2">
                <input type="hidden" name="imageRemoved" :value="imageRemoved" />
                <img v-if="processedUserImage" :src="processedUserImage" class="edit-profile-image" />
                <div v-else class="edit-profile-icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <input type="file" ref="fileInput" name="profileImage" @change="uploadFile" style="display: none;" />
            <a href="#" @click="triggerFileInput" class="me-4" style="font-weight: bold; text-decoration: none; font-size: 12px; color: #0fbe9f;">プロフィール画像を変更</a>
            <a href="#" @click="removeProfileImage" style="font-weight: bold; text-decoration: none; font-size: 12px; color: #f16363;">プロフィール画像を削除</a>
        </div>
        
        <div class="form-group mb-4">
            <label>氏名</label>
            <input
                name="name"
                v-bind="name"
                class="form-control"
                placeholder="フーディー スカウト"
            />
            <span style="color: red; font-weight: bold;">{{ errors.name }}</span>
        </div>

        <div class="form-group mb-4">
            <label>ユーザー名</label>
            <input
                name="userName"
                v-bind="userName"
                class="form-control"
                placeholder="foodie_2023"
            />
            <span style="color: red; font-weight: bold;">{{ errors.userName }}</span>
        </div>

        <div class="form-group mb-4">
            <label>メールアドレス</label>
            <input
                name="email"
                v-bind="email"
                class="form-control"
                placeholder="foodie_scout@example.com"
            />
            <span style="color: red; font-weight: bold;">{{ errors.email }}</span>
        </div>

        <div class="form-group mb-4">
            <label>電話番号</label>
            <input
                name="phone"
                v-bind="phone"
                class="form-control"
                placeholder="01234567890"
            />
            <span style="color: red; font-weight: bold;">{{ errors.phone }}</span>
        </div>

        <input type="hidden" name="_token" :value="csrf" />

        <div class="row justify-content-center">
            <button class="btn submit-button mt-3 w-50">
                保存
            </button>
        </div>
    </form>
</template>



<style>
label {
    margin-bottom: 8px;
}

.profile-image-container {
    width: 50px;
    height: 50px;
    border: 2px solid #aaaaaa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #f0f0f0;
}

.edit-profile-image {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

.edit-profile-icon {
    font-size: 30px;
}
</style>
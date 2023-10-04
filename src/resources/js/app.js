import 'bootstrap/dist/css/bootstrap.min.css';
import '../sass/app.scss';


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp, ref } from 'vue';

const app = createApp({
    setup() {
        // `image` プロパティを定義して返す
        const image = ref(null);
        return { image };
    },
});


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */


import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

import FavoriteButton from './components/FavoriteButton.vue';
app.component('favorite-button', FavoriteButton);

import Reservation from './components/Reservation.vue';
app.component('reservation', Reservation);

import FollowButton from './components/FollowButton.vue';
app.component('follow-button', FollowButton);

import MedalColor from './components/MedalColor.vue';
app.component('medal-color', MedalColor);

import ImageUpload from './components/ImageUpload.vue';
app.component('image-upload', ImageUpload);

import ImageEdit from './components/ImageEdit.vue';
app.component('image-edit', ImageEdit);

import ImageSlider from './components/ImageSlider.vue';
app.component('image-slider', ImageSlider);

import { setupCalendar } from 'v-calendar';
app.use(setupCalendar, {});

app.mount('#app');
require('./bootstrap');

import Vue from 'vue'
import Feed from './components/Post.vue';
Vue.component('feed', Feed);

const app = new Vue({
    el: '#app',
});

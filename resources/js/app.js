import './bootstrap';

import Alpine from 'alpinejs';

import Vue from 'vue';

window.Alpine = Alpine;

Vue.defineComponent('contact-component', require('./components/Contact.vue').default);

const app = new Vue({
    el: '#app'
});

Alpine.start();



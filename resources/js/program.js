require('./bootstrap');

window.Vue = require('vue');

const product = require('./components/admin/program/program-component.vue');

const app = new Vue({
    el: '#app',
    components: {
        product
    }
});

require('./bootstrap');

window.Vue = require('vue');


const app = new Vue({
    el: '#app',
    data() {
        return {
            startTime: '',
            finishTime: '',
            errorStartTimeMessage: 'Нельзя выбрать прошедшую дату!',
            errorFinishTimeMessage: 'Дата окончания программы не может быть раньше ее старта!',
            startTimeError: false,
            finishTimeError: false,
        }
    },
    methods: {
        start(time) {
            let inputTime = new Date(time);
            let currentTime = new Date();
            if (inputTime < currentTime) {
                this.startTimeError = true
            } else {
                this.startTimeError = false
            }
        },
        finish(time) {
            let inputTime = new Date(time);
            let finishStartInputTime = new Date(this.startTime);
            if (inputTime <finishStartInputTime) {
                this.finishTimeError = true
            } else {
                this.finishTimeError = false
            }
        }
    }
});

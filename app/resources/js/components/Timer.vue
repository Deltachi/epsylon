<template>
    <div @click="toggleTimer()" class="timer mb-4">
        <div class="timer-toggle">
            <div class="card timer-contents">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom-0">
                    <div style="font-size: 1.3em;" class="m-0 font-weight-light flex-grow-1 text-center">Verbleibende Zeit:
                        <br><span :class="'font-weight-bold '+(time.days===0 && time.hours===0 && time.minutes < 30?'text-danger':'')">
                            <span v-if="time.days>0">{{time.days}} Tage und </span>
                            <span v-if="time.hours<10">0</span>{{time.hours}}:<span v-if="time.minutes<10">0</span>{{time.minutes}}:<span v-if="time.seconds<10">0</span>{{time.seconds}}</span>
                    </div>
                    <div style="font-size: 1.6em;" ><i class="fa fa-eye-slash"></i></div>
                </div>
            </div>
            <div class="card timer-contents timer-contents--back hidden ">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom-0">
                    <div class="m-0 font-weight-light flex-grow-1 text-center">
                        <span style="font-size: 1.2em;">Abgabe: </span>
                        <span style="font-size: 1.2em;" class="pr-2 font-weight-bold">{{end}}</span>
                    </div>
                    <i style="font-size: 2em;" class="fa fa-clock-o"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Timer",
        props: [
            'dataEnd',
        ],
        data() {
            return {
                time:{
                    seconds: 0,
                    minutes: 0,
                    hours: 0,
                    days: 0,
                },
                timer: null,
                end: "",
            }
        },
        methods: {
            toggleTimer(){
                let elems = document.getElementsByClassName('timer-toggle');
                for (let ele of elems){
                    ele.classList.toggle('hidden');
                }
            },
            getTime(){
                let t = this.dataEnd.split(/[- :]/);
                let date_future = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                this.end = date_future.toLocaleString();
                let date_now = new Date();

                let seconds = Math.floor((date_future - (date_now))/1000);
                let minutes = Math.floor(seconds/60);
                let hours = Math.floor(minutes/60);
                let days = Math.floor(hours/24);

                hours = hours-(days*24);
                minutes = minutes-(days*24*60)-(hours*60);
                seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);

                this.time.days = days;
                this.time.hours = hours;
                this.time.minutes = minutes;
                this.time.seconds = seconds;
            }
        },
        created() {
            this.getTime();
            this.timer = setInterval(() => {
                this.getTime();
            }, 1000);
        }
    }
</script>

<style scoped>
    .timer{
        cursor: pointer;
        height: 80px;
        perspective: 600px;
    }
    .timer-toggle{
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 1s;
        transform-style: preserve-3d;
    }
    .timer-contents{
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        transition: transform 1s ease;
    }
    .timer-contents>.card-header{
        height: 100%;
    }
    .timer-contents--back{
        transform: rotateX(180deg);
    }
    .timer-toggle.hidden{
        transform: rotateX(180deg);
    }
</style>

<template>
    <div class="task-server-message">
        <div v-if="messageType === 'success'" class="alert alert-success" role="alert">
            {{message}}
        </div>
        <div v-else-if="messageType === 'danger'" class="alert alert-danger" role="alert">
            {{message}}
        </div>
        <div v-else-if="messageType === 'warning'" class="alert alert-warning" role="alert">
            {{message}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "TaskServerMessage",
        props: ['message','messageType','triggerHandle','redirect'],
        data(){
            return {
                timeoutTimer: null,
            }
        },
        methods: {
            show(){
                let container = document.getElementsByClassName("task-server-message")[0];
                container.classList.add("active");
                if (this.timeoutTimer){
                    clearTimeout(this.timeoutTimer);
                }
                this.timeoutTimer = setTimeout(function(){
                    container.classList.remove("active");
                }, 4000);
                if (this.redirect){
                    setTimeout(function(){
                        window.location.href = this.redirect;
                    }, 5000);
                }
            }
        },
        mounted() {
            this.triggerHandle.$on('show', this.show);
        }
    }
</script>

<style scoped>
    .task-server-message{
        position: fixed;
        bottom: 20px;
        right: 25px;
        transition: opacity .4s ease, transform .4s ease-in-out;
        opacity: 0;
        transform: translateY(100%);
    }
    .task-server-message.active{
        opacity: 1;
        transform: translateY(0);
    }
</style>

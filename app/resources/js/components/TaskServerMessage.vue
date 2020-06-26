<template>
    <div class="task-server-message">
        <div v-if="message_type === 'success'" class="alert alert-success" role="alert">
            {{message}}
        </div>
        <div v-else-if="message_type === 'danger'" class="alert alert-danger" role="alert">
            {{message}}
        </div>
        <div v-else-if="message_type === 'warning'" class="alert alert-warning" role="alert">
            {{message}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "TaskServerMessage",
        props: ['message','message_type'],
        methods: {
            animate(){
                let container = document.getElementsByClassName("task-server-message")[0];
                container.classList.add("active");
                setTimeout(function(){ container.classList.remove("active"); }, 3000);
            }
        },
        updated() {
            this.animate();
        },
        mounted() {
            this.animate();
        }
    }
</script>

<style scoped>
    .task-server-message{
        position: fixed;
        bottom: 20px;
        right: 25px;
        transition: opacity .5s ease;
        opacity: 0;
    }
    .task-server-message.active{
        opacity: 1;
    }
</style>

<template>
    <div v-if="ready">
        <task1 v-if="task.type === 1" :data-task="task" :data-answer.sync="answer" @save="triggerSaveHandle" @reset="triggerResetHandle"></task1>

    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import task1 from "./task1";
    import task2 from "./task2";
    import task3 from "./task3";
    import task4 from "./task4";
    import task5 from "./task5";
    import task6 from "./task6";
    import task7 from "./task7";
    import task8 from "./task8";
    import task9 from "./task9";
    import task10 from "./task10";

    export default {
        name: "Task",
        props: [
            'dataTask',
            'dataUserId',
            'dataExam',
            'triggerSave',
            'isActive',
        ],
        components: {
            task1,
            task2,
            task3,
            task4,
            task5,
            task6,
            task7,
            task8,
            task9,
            task10,
        },
        data(){
            return {
                user_id: 1,
                exam: {
                    id: 1,
                    begin: "",
                    end: "",
                },
                task: {
                    id: 1,
                    type: 1,
                    title: "",
                    description: "",
                    hint: "",
                    data: {},
                    points: 0.0,
                },
                answer:"",
                ready: false,
            }
        },
        created() {
            //Variablenzuweisungen
            if(this.dataTask && this.dataTask !== "null"){
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
            if(this.dataUserId && this.dataUserId !== "null"){
                this.user_id = this.dataUserId;
            }
            if(this.dataExam && this.dataExam !== "null"){
                this.exam = JSON.parse(this.dataExam);
            }

            //Methodenaufrufe
            this.loadTask();
        },

        methods: {
            loadTask(){
                //Database connection
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let url = '/answer/'+this.user_id+"/"+this.exam.id+"/"+this.task.id;
                fetch(url, {
                    method: 'GET',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                })
                    .then(response => response.json())
                    .then(data => this.handleServerData(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            submitTask(){
                //Database connection
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let url = '/answer';
                fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        user: this.user_id,
                        exam: this.exam.id,
                        task: this.task.id,
                        data: this.answer
                    }),
                })
                    .then(response => response.json())
                    .then(data => this.handleServerMessage(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            resetTask(affirmation = false){
                if(affirmation || confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    this.answer = null

                    //Database connection
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let url = '/answer';
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({
                            user: this.user_id,
                            exam: this.exam.id,
                            task: this.task.id,
                        }),
                    })
                        .then(response => response.json())
                        .then(data => this.handleServerMessage(data))
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                }
            },
            keyEvent(event) {
                if (event.ctrlKey || event.metaKey) {
                    switch (String.fromCharCode(event.which).toLowerCase()) {
                        case 's':
                            event.preventDefault();
                            this.submitTask();
                            break;
                    }
                }
            },
            handleServerMessage(response){
                console.log(response.message);
                if (this.isActive){
                    this.$emit('server-message', {'message': response.message, 'messageType': response.messageType});
                }
            },
            handleServerData(response){
                if(response.success){
                    console.log(response.data);
                    this.answer = JSON.parse(response.data);
                }
                console.log(response.message);
                if (this.isActive){
                    this.$emit('server-message', {'message': response.message, 'messageType': response.messageType});
                }
            },
            triggerSaveHandle(){
                if (this.isActive){
                    console.log("Ich, Task "+this.task.id+" soll speichern!");
                    this.submitTask();
                }
            },
            triggerResetHandle(affirm = false){
                console.log("Ich, Task "+this.task.id+" soll vergessen..");
                this.resetTask(affirm);
            }
        },
        mounted() {
            $(window).bind('keydown', this.keyEvent);
            this.triggerSave.$on('save',this.triggerSaveHandle);
        },
    }
</script>

<style scoped>

</style>

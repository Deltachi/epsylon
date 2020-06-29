<template>
    <task1 v-if="task.type === 1" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task1>
    <task2 v-else-if="task.type === 2" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task2>
    <task3 v-else-if="task.type === 3" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task3>
    <task4 v-else-if="task.type === 4" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task4>
    <task5 v-else-if="task.type === 5" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task5>
    <task6 v-else-if="task.type === 6" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task6>
    <task7 v-else-if="task.type === 7" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task7>
    <task8 v-else-if="task.type === 8" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task8>
    <task9 v-else-if="task.type === 9" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task9>
    <task10 v-else-if="task.type === 10" :data-task="dataTask" :data-answer.sync="answer" :data-user-id="dataUserId" :data-exam-id="dataExam.id" :data-task-id="task.id"></task10>
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
                server_message: "",
                server_message_type: "",
                server_message_handle: new Vue(),
            }
        },
        created() {
            //Methodenaufrufe
            this.loadTask();
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
        },

        methods: {
            loadTask(){
                //this.localLoad();

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
                    .then(data => this.serverData(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            submitTask(){
                //this.localSave();

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
                    .then(data => this.serverMessage(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            localSave(){
                localStorage.setItem("task_"+this.type,JSON.stringify(this.answer));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.type)){
                    this.answer = JSON.parse(localStorage.getItem("task_"+this.type));
                }
            },
            localDelete(){
                if(localStorage.getItem("task_"+this.type)){
                    localStorage.removeItem("task_"+this.type);
                }
            },
            resetTask(affirmation = false){
                if(affirmation || confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    //this.localDelete();
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
                        .then(data => this.serverMessage(data))
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
            serverMessage(response){
                console.log(response.message);
                this.server_message = response.message;
                this.server_message_type = response.message_type;

                this.server_message_handle.$emit('animate');
            },
            serverData(response){
                if(response.success){
                    console.log(response.data);
                    this.answer = JSON.parse(response.data);
                }
                console.log(response.message);
                this.server_message = response.message;
                this.server_message_type = response.message_type;
                this.server_message_handle.$emit('animate');
            }
        },
        mounted() {
            $(window).bind('keydown', this.keyEvent);
        },
    }
</script>

<style scoped>

</style>

<template>
    <div v-if="ready">
        <task1 v-if="task.type === 1"
               :data-task="task"
               :trigger-answer-loaded="pushToChild"
               @save="triggerSaveHandle"
               @reset="triggerResetHandle"
               ref="taskRef"
        ></task1>
        <task2 v-if="task.type === 2"
               :data-task="task"
               :trigger-answer-loaded="pushToChild"
               @save="triggerSaveHandle"
               @reset="triggerResetHandle"
               ref="taskRef"
        ></task2>
        <task3 v-if="task.type === 3"
               :data-task="task"
               :trigger-answer-loaded="pushToChild"
               @save="triggerSaveHandle"
               @reset="triggerResetHandle"
               ref="taskRef"
        ></task3>
        <task4 v-if="task.type === 4"
               :data-task="task"
               :trigger-answer-loaded="pushToChild"
               @save="triggerSaveHandle"
               @reset="triggerResetHandle"
               ref="taskRef"
        ></task4>
        <task5 v-if="task.type === 5"
               :data-task="task"
               :trigger-answer-loaded="pushToChild"
               @save="triggerSaveHandle"
               @reset="triggerResetHandle"
               ref="taskRef"
        ></task5>
        <task6 v-if="task.type === 6"
               :data-task="task"
               :trigger-answer-loaded="pushToChild"
               @save="triggerSaveHandle"
               @reset="triggerResetHandle"
               ref="taskRef"
        ></task6>
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
    import TaskLoadingError from "./TaskLoadingError";
    export default {
        name: "Task",
        props: [
            'dataTask',
            'dataUserId',
            'dataExam',
            'triggerSave',
            'isActive',
            'wasActive',
            'resetUpdate',
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
            TaskLoadingError,
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
                answer: null,
                pushToChild: new Vue(),
                ready: false,
                token: null,
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
            this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //Methodenaufrufe
            this.loadTask();
        },

        methods: {
            loadTask(){
                //Database connection
                let url = '/answer/'+this.user_id+"/"+this.exam.id+"/"+this.task.id;
                fetch(url, {
                    method: 'GET',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": this.token
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
                //Answer Data
                let submit_data = JSON.stringify({
                    user: this.user_id,
                    exam: this.exam.id,
                    task: this.task.id,
                    data: this.answer,
                });
                //Database connection
                let url = '/answer';
                fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": this.token
                    },
                    credentials: "same-origin",
                    body: submit_data,
                })
                    .then(response => response.json())
                    .then(data => this.handleServerMessage(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            resetTask(){
                //Clear Answer Buffer
                this.answer = null
                //Database connection
                let url = '/answer';
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": this.token
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
            },
            handleServerMessage(response){
                if (this.isActive || this.wasActive){
                    if (response.exception){
                        response.messageType = 'danger';
                        response.redirect = '/login'
                        this.$emit('server-message', {'message': response.message, 'messageType': response.messageType, 'redirect': response.redirect});
                    }else{
                        this.$emit('server-message', {'message': response.message, 'messageType': response.messageType});
                    }
                }
                if (response.messageType === 'success'){
                    if (response.method === 'post'){
                        this.$emit('answer-update', this.task.id);
                    }
                    if (response.method === 'delete'){
                        this.$emit('reset-update', this.task.id);
                    }
                }
            },
            handleServerData(response){
                if(response.success){
                    let answerData = JSON.parse(response.data);
                    this.pushToChild.$emit('loaded',answerData);
                }
                if (this.isActive){
                    this.$emit('server-message', {'message': response.message, 'messageType': response.messageType});
                }
            },
            triggerSaveHandleExtern(){
                if (this.isActive) {
                    let ref = this.$refs.taskRef;
                    if (ref) {
                        this.pushToChild.$emit('generate-answer');
                        this.triggerSaveHandle();
                    }
                }
            },
            triggerSaveHandle(){
                if (this.isActive){
                    let ref = this.$refs.taskRef;
                    if (ref) {
                        this.answer = ref.answer;
                        console.log("Answer to save: ",this.answer);
                        this.submitTask();
                    }
                }
            },
            triggerResetHandle(affirmation = false){
                if(affirmation || confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")) {
                    this.resetTask();
                }
            },
            handleKeyEvent(event) {
                if (event.ctrlKey || event.metaKey) {
                    switch (String.fromCharCode(event.which).toLowerCase()) {
                        case 's':
                            event.preventDefault();
                            this.triggerSaveHandleExtern();
                            break;
                    }
                }
            },
        },
        mounted() {
            $(window).bind('keydown', this.handleKeyEvent);
            this.triggerSave.$on('save',this.triggerSaveHandleExtern);
        },
    }
</script>

<style scoped>

</style>

<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <input v-model="answer" name="answer" type="text" class="form-control" placeholder="Antwort..." >
            </div>
            <task-footer></task-footer>
        </form>
        <task-server-message v-if="server_message" v-bind:message="server_message" v-bind:message_type="server_message_type"></task-server-message>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskServerMessage from "./TaskServerMessage";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task1",
        props: [
          'dataTask'
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskServerMessage,
            TaskLoadingError,
        },
        created() {
            //Methodenaufrufe
            this.loadTask();
            //Variablenzuweisungen
            if(this.dataTask && this.dataTask !== "null"){
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
        },
        data(){
            return {
                type: 1,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: {},
                    points: 0.0,
                },
                answer:"",
                user_id: 1,
                exam_id: 1,
                task_id: 1,
                ready: false,
                server_message: "",
                server_message_type: "",
            }
        },
        methods: {
            loadTask(){
                //this.localLoad();

                //Database connection
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let user = 1;
                let exam = 1;
                let task = 1;
                let url = '/answer/'+user+"/"+exam+"/"+task;
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
                        user: 1,
                        exam: 1,
                        task: 1,
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
                            user: 1,
                            exam: 1,
                            task: 1,
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
                if(response.success){
                    console.log(response.message);
                    this.server_message = response.message;
                    this.server_message_type = response.message_type;
                }else{
                    console.log(response.message);
                    this.server_message = response.message;
                    this.server_message_type = response.message_type;
                }
            },
            serverData(response){
                if(response.success){
                    console.log(response.message);
                    console.log(response.data);
                    this.answer = JSON.parse(response.data);
                    this.server_message = response.message;
                    this.server_message_type = response.message_type;
                }else{
                    console.log(response.message);
                    this.server_message = response.message;
                    this.server_message_type = response.message_type;
                }
            }
        },
        mounted() {
            $(window).bind('keydown', this.keyEvent);
        },

    }
</script>

<style scoped>

</style>

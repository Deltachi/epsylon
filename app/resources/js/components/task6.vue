<!-- Antworten in die richtige Reihenfolge bringen -->
<template>
    <div v-if="ready" class="card">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body d-flex flex-column align-items-start pl-5 pr-5">
            <div class="task-top" v-if="task.data.top">{{task.data.top}}</div>
            <ul class="task-body" id="sortable">
                <li class="task-option" v-for="(option, index) in task.data" :data="option" v-if="option.name">
                    <div v-if="option.name">{{option.name}}</div>
                    <div v-if="option.hint" class="text-muted small">{{option.hint}}</div>
                </li>
            </ul>
            <div class="task-bottom" v-if="task.data.bottom">{{task.data.bottom}}</div>
        </div>
        <task-footer></task-footer>
        <task-server-message v-if="server_message" v-bind:message="server_message" v-bind:message_type="server_message_type" :animation_handle="server_message_handle"></task-server-message>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskServerMessage from "./TaskServerMessage";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task6",
        props: [
            'dataTask',
            'dataUserID',
            'dataExamID',
            'dataTaskID',
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskServerMessage,
            TaskLoadingError,
        },
        created() {
            this.loadTask();
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
            if(this.dataUserID && this.dataUserID !== "null"){
                this.user_id = this.dataUserID;
            }
            if(this.dataExamID && this.dataExamID !== "null"){
                this.exam_id = this.dataExamID;
            }
            if(this.dataTaskID && this.dataTaskID !== "null"){
                this.task_id = this.dataTaskID;
            }
            console.log(this.task.data);
            $(function () {
                $("#sortable").sortable({
                    placeholder: "ui-state-highlight",
                    revert: false
                });
            });

        },
        data() {
            return {
                task: {
                    type: 6,
                    title: "",
                    description: "",
                    hint: "",
                    top: "",
                    bottom: "",
                    data: {},
                    points:0.0,
                },
                answer:[],
                user_id: 1,
                exam_id: 1,
                task_id: 6,
                ready: false,
                server_message: "",
                server_message_type: "",
                server_message_handle: new Vue(),
            }
        },
        methods: {
            loadTask(){
                //Database connection
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let url = '/answer/'+this.user_id+"/"+this.exam_id+"/"+this.task_id;
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
            submitTask() {
                //this.localLoad();
                this.answer = [];
                for(let i=1;i<document.getElementsByTagName("LI").length;i++){
                    var string = document.getElementsByTagName("LI")[i].innerText;
                    this.answer.push(string.replace(/\n/i, " "));
                }
                //alert("Aufgabe wird abgegeben!\n" + this.answer);
                console.log(this.answer);
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
                        exam: this.exam_id,
                        task: this.task_id,
                        data: this.answer
                    }),
                })
                    .then(response => response.json())
                    .then(data => this.serverMessage(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            localLoad() {
                if (localStorage.getItem("task_" + this.type)) {
                    this.answer = JSON.parse(localStorage.getItem("task_" + this.type));
                    console.log("Answer: "+ this.answer);
                }
            },
            resetTask(affirmation = false){
                if(affirmation || confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    //this.localDelete();
                    this.answer = [];

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
                            exam: this.exam_id,
                            task: this.task_id,
                        }),
                    })
                        .then(response => response.json())
                        .then(data => this.serverMessage(data))
                        .catch((error) => {
                            console.error('Error:', error);
                        });
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
        }
    }
</script>

<style scoped>
    .task-top {
        padding: 15px 25px;
        background-color: white;
        border-radius: 8px 8px 0 0;
        border: 1px lightgray solid;
        border-bottom: 1px white solid;
        z-index: 1;
    }

    ul#sortable.task-body {
        padding: 10px 25px;
        background-color: #f7f7f7;
        border: 1px lightgray solid;
        min-height: 100px;
        list-style-type: none;
        margin: 0;
        /*box-shadow: 3px 3px 8px rgba(0,0,0,.3);*/
        border-radius: 0 8px 8px 0;
        z-index: 2;
    }

    ul#sortable.task-body li {
        background-color: white;
        padding: 8px;
        margin: 10px 0;
        width: 300px;
        border-radius: 5px;
        border: 1px lightgray solid;
    }

    ul#sortable.task-body li:hover {
        cursor: pointer;
    }

    .task-bottom {
        padding: 15px 25px;
        background-color: white;
        border: 1px lightgray solid;
        border-top: 1px white solid;
        border-radius: 0 0 8px 8px;
        z-index: 1;
    }

</style>

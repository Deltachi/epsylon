<!-- Antworten in die richtige Reihenfolge bringen -->
<template>
    <div v-if="ready" class="card">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body pl-5 pr-5">
            <div class="row drag-container">
                <div class="col-6 d-flex flex-column justify-content-center">
                    <ul class="drag-list">
                        <li v-for="(input, index) in task.data.input" :id="'draggable'+index" :data-index="index" class="draggable input"><span class="badge badge-pill badge-secondary">{{input}}</span></li>
                    </ul>
                </div>
                <div class="col-6">
                    <div class="card mb-3" v-for="(output, index) in task.data.output">
                        <div class="card-header"><b>{{output}}</b></div>
                        <div class="card-body">
                            <ul :id="'sortable'+index" class="sortable"></ul>
                        </div>
                    </div>
                </div>
            </div>
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
        name: "task7",
        props: [
            'dataTask',
            'dataAnswer',
            'dataUserId',
            'dataExamId',
            'dataTaskId',
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskServerMessage,
            TaskLoadingError,
        },
        created() {
            //this.loadTask();
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
            if(this.dataUserId && this.dataUserId !== "null"){
                this.user_id = this.dataUserId;
            }
            if(this.dataExamId && this.dataExamId !== "null"){
                this.exam_id = this.dataExamId;
            }
            if(this.dataTaskId && this.dataTaskId !== "null"){
                this.task_id = this.dataTaskId;
            }
            $( function() {
                $( ".sortable").sortable({
                    connectWith: ".sortable",
                    revert: 'invalid',
                });
                $(".draggable").each(function(i){
                    $(this).draggable({
                        connectToSortable: ".sortable",
                        helper: "original",
                        revert: 'invalid',
                    });
                });
            } );
        },
        data(){
            return {
                task: {
                    type: 7,
                    title: "",
                    description: "",
                    hint: "",
                    data: {
                        input: [],
                        output: []
                    },
                    points: 0.0,
                },
                answer:[],
                user_id: 1,
                exam_id: 1,
                task_id: 7,
                ready: false,
                server_message: "",
                server_message_type: "",
                server_message_handle: new Vue(),
            }
        },
        methods:{
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
            submitTask(){
                this.answer = [];
                console.log(document.getElementsByTagName("UL").length);
                for(let i=3;i<document.getElementsByTagName("UL").length;i++){
                    console.log(document.getElementsByTagName("UL")[i].id);
                    console.log(document.getElementsByTagName("UL")[i].innerText);
                    var string = document.getElementsByTagName("UL")[i].id + ": " + document.getElementsByTagName("UL")[i].innerText + " ";
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
    .sortable, .drag-list{
        min-height: 50px;
        list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px;
    }
    .input{
        z-index: 999;
        margin: 5px;  width: 150px;
    }
    .input>.badge.badge-pill{
        font-size: 90%;
        font-weight: 400;
        padding: 7px 25px;
        width: 100%;
    }
</style>

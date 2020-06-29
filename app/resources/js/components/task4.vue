<template>
    <div v-if="ready" class="card">
        <form name="form">
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <div id="checkdistance">
                    <div class="form-group row" v-for="(solution, index) in task.data.solution">
                        <div class="form-check">
                            <input :id="'answer-'+index" class="form-check-input" type="checkbox" :value="solution" v-model="answer">
                            <label class="form-check-label">{{solution}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <task-footer></task-footer>
        </form>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskServerMessage from "./TaskServerMessage";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task4",
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
            this.loadTask();
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
        },
        data() {
            return {
                type: 4,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: {'solution':[]},
                    points: 0.0,
                },
                answer:[],
                user_id: 1,
                exam_id: 1,
                task_id: 4,
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
                //alert("Aufgabe wird abgegeben!\n" + JSON.stringify(this.answer));
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
            localSave() {
                localStorage.setItem("task_" + this.type, JSON.stringify(this.answer));
            },
            localLoad() {

                if (localStorage.getItem("task_" + this.type)) {
                    this.answer = JSON.parse(localStorage.getItem("task_" + this.type));
                    console.log(this.answer);
                }
            },
            localDelete() {
                if (localStorage.getItem("task_" + this.type)) {
                    localStorage.removeItem("task_" + this.type);
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
            reset() {
                if (confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")) {
                    this.localDelete();
                    this.answer = [
                        []
                    ]
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
    #checkdistance {
        padding-top: 10px;
        padding-left: 40px;
    }

</style>

<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body editor-wrapper p-0">
                <MonacoEditor
                    width="100%"
                    height="500px"
                    theme="vs-dark"
                    language="cpp"
                    :options="options"
                    v-model="answer"
                    @change="onChange"
                ></MonacoEditor>
            </div>
            <task-footer></task-footer>
        </form>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import MonacoEditor from 'monaco-editor-vue';
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskServerMessage from "./TaskServerMessage";
    import TaskLoadingError from "./TaskLoadingError";
    export default {
        name: "task2",
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
            TaskLoadingError,
            TaskServerMessage,
            MonacoEditor,
        },
        created() {
            this.loadTask();

            if(this.dataTask && this.dataTask !== "null"){
                this.task = JSON.parse(this.dataTask);
                this.answer = this.task.data.code;
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
        mounted() {
            this.loadTask();
        },
        data(){
            return {
                type: 2,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: {
                        code: "",
                    },
                    points: 0.0,
                },
                answer:"",
                options: {
                    //Monaco Editor Options
                },
                ready: false,
                user_id: 1,
                exam_id: 1,
                task_id: 2,
                server_message: "",
                server_message_type: "",
                server_message_handle: new Vue(),
            }
        },
        methods: {
            loadTask(){
                //this.localLoad();

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
                //alert("Aufgabe wird abgegeben!\n"+this.answer);
                //this.localSave();
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
            onChange(value) {
                //this.code = value;
                //console.log(value);
            },
            localSave(){
                localStorage.setItem("task_"+this.task.type,JSON.stringify(this.answer));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.task.type)){
                    this.answer = JSON.parse(localStorage.getItem("task_"+this.task.type));
                }
            },
            localDelete(){
                if(localStorage.getItem("task_"+this.task.type)){
                    localStorage.removeItem("task_"+this.task.type);
                }
            },
            resetTask(affirmation = false){
                if(affirmation || confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    //this.localDelete();
                    this.answer = this.task.data.code;

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
            },
        }

    }
</script>

<style scoped>
    .editor-wrapper{
        width: calc(100%);
        overflow: hidden;
    }
</style>

<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <div class="pl-3">
                    <div class="card-body">
                        <p id="blanks-sentence">
                            <template v-for="(words, index) in task.data.sentence_exploded">
                                <input v-if="words === task.data.blank" type="text" v-model="answer[getID(index)]" :name="'blank-'+getID(index)" class="blank-space">
                                <span v-else>{{words}} </span>
                            </template>
                        </p>
                    </div>
                </div>
            </div>
            <task-footer></task-footer>
        </form>
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
        name: "task8",
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
            //Methodenaufrufe
            this.loadTask();
            //Variablenzuweisungen
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.task.data.sentence = this.replaceAll(this.task.data.sentence, this.task.data.blank, '~'+this.task.data.blank+'~');
                this.task.data.sentence_exploded = this.task.data.sentence.split("~");
                this.task.data.blank_ids = [];
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
        },
        data(){
            return {
                type: 9,
                task: {
                    title: "",
                    description:"",
                    hint: "",
                    data: {
                        sentence: "Mein Name ist _BLANK",
                        sentence_exploded: ["Mein","Name","ist","_BLANK"], //das soll nicht in die DB
                        blank: "_BLANK",
                        blank_ids: [], //das soll nicht in die DB
                    },
                    points: 0.0,
                },
                answer:"",
                user_id: 1,
                exam_id: 1,
                task_id: 8,
                ready: false,
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
                alert("Aufgabe wird abgegeben!\n"+JSON.stringify(this.answer));
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
                    this.answer = null;

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
            reset(){
                if(confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    this.localDelete();
                    this.answer = [];
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
            replaceAll(str, find, replace) {
                return str.replace(new RegExp(find, 'g'), replace);
            },
            getID(index){
                if(!this.task.data.blank_ids.includes(index)){
                    this.task.data.blank_ids.push(index);
                    return this.task.data.blank_ids.indexOf(index);
                }else{
                    return this.task.data.blank_ids.indexOf(index);
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
    .blank-space{
        margin: 8px 4px;
    }
</style>

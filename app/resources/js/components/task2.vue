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
    import TaskLoadingError from "./TaskLoadingError";
    export default {
        name: "task2",
        props: [
            'dataTask'
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskLoadingError,
            MonacoEditor,
        },
        created() {
            if(this.dataTask && this.dataTask !== "null"){
                this.task = JSON.parse(this.dataTask);
                this.answer = this.task.data.code;
                this.ready = true;
            }
        },
        mounted() {
            this.localLoad();
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
                ready: false
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+this.answer);
                this.localSave();
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
            reset(){
                if(confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")) {
                    this.localDelete();
                    this.answer = this.task.data.code;
                }
            }
        }

    }
</script>

<style scoped>
    .editor-wrapper{
        width: calc(100%);
        overflow: hidden;
    }
</style>

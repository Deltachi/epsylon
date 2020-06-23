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
                    :value="task.data.code"
                    v-model="task.data.code"
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
            this.localLoad();
            if(this.dataTask && this.dataTask !== "null"){
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
        },
        data(){
            return {
                type: 2,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: {},
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
                alert("Aufgabe wird abgegeben!\n"+this.code);
                this.localSave();
            },
            onChange(value) {
                //this.code = value;
                //console.log(value);
            },
            localSave(){
                localStorage.setItem("task_"+this.task.type,JSON.stringify(this.code));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.task.type)){
                    this.code = JSON.parse(localStorage.getItem("task_"+this.task.type));
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
                    this.code = "";
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

<template>
    <div class="card">
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
                ></MonacoEditor>
            </div>
            <task-footer @save="triggerSave" @reset="triggerReset"></task-footer>
        </form>
    </div>
</template>

<script>
    import MonacoEditor from 'monaco-editor-vue';
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    export default {
        name: "task2",
        props: [
            'dataTask',
            'triggerAnswerLoaded',
        ],
        components: {
            TaskHeader,
            TaskFooter,
            MonacoEditor,
        },
        created() {
            //Initialisierungen
            if(this.dataTask && this.dataTask !== "null"){
                this.convertTaskData(this.dataTask);
                this.ready = true;
            }
        },
        mounted() {
            this.triggerAnswerLoaded.$on('loaded', this.convertAnswerData);
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
                options: {
                    //Monaco Editor Options
                },
                answer:null,
                answerFresh: "",
            }
        },
        methods: {
            triggerSave(){
                this.$emit('save');
            },
            triggerReset(affirm){
                this.answer = this.answerFresh;
                this.$emit('reset', affirm);
            },
            /**
             * Wandele die Task-Daten in ein Format um, dass diese Aufgabe benötigt.
             * Manipulier gegebenenfalls die DOM
             * @param task
             */
            convertTaskData(task){
                //Falls eine Umwandlung der Daten stattfinden soll
                this.task = task;
                this.answerFresh = task.data.code;
                if(!this.answer) {
                    this.answer = task.data.code;
                }
            },
            /**
             * Wandele die Antwort-Daten in ein Format um, dass diese Aufgabe benötigt.
             * @param data
             */
            convertAnswerData(data){
                //Falls eine Umwandlung der Daten stattfinden soll
                this.answer = data;
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

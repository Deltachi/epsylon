<template>
    <div class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <input v-model="answer" name="answer" type="text" class="form-control" placeholder="Antwort..." >
            </div>
            <task-footer @save="triggerSave" @reset="triggerReset"></task-footer>
        </form>
    </div>
</template>
<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    export default {
        name: "task1",
        props: [
            'dataTask',
            'triggerAnswerLoaded',
        ],
        components: {
            TaskHeader,
            TaskFooter,
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
             * @param data
             */
            convertTaskData(task){
                //Falls eine Umwandlung der Daten stattfinden soll
                this.task = task;
            },
            /**
             * Wandele die Antwort-Daten in ein Format um, dass diese Aufgabe benötigt.
             * @param data
             */
            convertAnswerData(data){
                //Falls eine Umwandlung der Daten stattfinden soll
                this.answer = data;
            },
        },
        data(){
            return {
                type: 1,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: null,
                    points: 0.0,
                },
                answer: "",
                answerFresh: "",
            }
        }
    }
</script>

<style scoped>

</style>

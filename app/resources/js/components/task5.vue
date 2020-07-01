<template>
    <div class="card">
        <form name="form">
            <task-header v-bind:task="task"></task-header>
            <div class="card-body p-5">
                <div class="form-group" v-for="(choice, index) in task.data">
                    <div class="form-check">
                        <input :id="'choice-'+task.id+'-'+index" class="form-check-input" type="radio" :value="choice" v-model="answer">
                        <label :for="'choice-'+task.id+'-'+index" class="form-check-label" >{{choice}}</label>
                    </div>
                </div>
            </div>
            <task-footer @save="triggerSave" @reset="triggerReset"></task-footer>
        </form>
    </div>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";

    export default {
        name: "task5",
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
            triggerSave(next = false){
                this.$emit('save', next);
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
        data() {
            return {
                type: 5,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: [],
                    points: 0.0,
                },
                answer:[],
                answerFresh:[],
            }
        },
    }
</script>

<style scoped>

</style>

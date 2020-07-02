<template>
    <div class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <div class="pl-3">
                    <div class="card-body">
                        <p id="blanks-sentence">
                            <template v-for="(words, index) in task.data.sentence_exploded">
                                <input v-if="words === task.data.blank" type="text" v-model="answer[getID(index)]" :name="'blank-'+getID(index)" class="form-control blank-space">
                                <span v-else>{{words}} </span>
                            </template>
                        </p>
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
    import TaskServerMessage from "./TaskServerMessage";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task8",
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
                answer:[],
                answerFresh:[],
            }
        },
        mounted() {
            this.triggerAnswerLoaded.$on('loaded', this.convertAnswerData);
        },
        methods: {
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
            triggerSave(next = false){
                this.$emit('save', next);
            },
            triggerReset(affirm){
                this.answer = "";
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
                this.task.data.sentence = this.replaceAll(this.task.data.sentence, this.task.data.blank, '~'+this.task.data.blank+'~');
                this.task.data.sentence_exploded = this.task.data.sentence.split("~");
                this.task.data.blank_ids = [];

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

    }
</script>

<style scoped>
    .blank-space{
        margin: 8px 4px;
        width: auto;
        display: inline;
    }
</style>

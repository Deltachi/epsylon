<!-- Antworten in die richtige Reihenfolge bringen -->
<template>
    <div class="card">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body d-flex flex-column align-items-start pl-5 pr-5">
            <div class="task-top" v-if="task.data.top">{{task.data.top}}</div>
            <ul class="task-body" id="sortable">
                <li :class="'task-option target target-'+task.id" v-for="(option, index) in task.data.options">
                    <div class="data-target">{{option}}</div>
                </li>
            </ul>
            <div class="task-bottom" v-if="task.data.bottom">{{task.data.bottom}}</div>
        </div>
        <task-footer @save="triggerSave" @reset="triggerReset"></task-footer>
    </div>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskServerMessage from "./TaskServerMessage";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task6",
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
            console.log(this.task.data);
            $(function () {
                $("#sortable").sortable({
                    placeholder: "ui-state-highlight",
                    revert: false
                });
            });
        },
        mounted() {
            this.triggerAnswerLoaded.$on('loaded', this.insertAnswerData);
            this.triggerAnswerLoaded.$on('generate-answer', this.convertAnswer);
        },
        methods: {
            parseAnswer(_answer){
                let targets = document.getElementsByClassName("target-"+this.task.id);
                for(let target of targets){
                    let element = target.getElementsByClassName('data-target')[0];
                    if(Array.isArray(_answer) && _answer.length > 0){
                        element.innerText = _answer.shift();
                    }
                }
            },
            convertAnswer(){
                let targets = document.getElementsByClassName("target-"+this.task.id);
                this.answer = [];
                for(let target of targets){
                    let element = target.getElementsByClassName('data-target')[0];
                    let targetData = element.innerText;
                    if(targetData){
                        this.answer.push(targetData);
                    }
                }
            },
            resetAnswer(){
                let options = this.task.data.options;
                // Steal the lolli from the component
                this.task.data.options = null;
                this.$nextTick().then(() => {
                    // Give the lolli back and force a re-render
                    this.task.data.options = options;
                });
                this.answer = {};
            },
            triggerSave(next = false){
                this.convertAnswer();
                this.$emit('save', next);
            },
            triggerReset(affirm){
                this.resetAnswer();
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
            insertAnswerData(data){
                //Falls eine Umwandlung der Daten stattfinden soll
                this.parseAnswer(data);
                this.answer = data;
            },
        },
        data() {
            return {
                task: {
                    type: 6,
                    title: "",
                    description: "",
                    hint: "",
                    data: {
                        options: [{
                            name: "",
                            hint: "",
                        }],
                        top: "",
                        bottom: "",
                    },
                    points:0.0,
                },
                answer:[],
                answerFresh:[],
            }
        },
    }
</script>

<style scoped>
    .task-top {
        padding: 15px 25px;
        background-color: white;
        border-radius: 8px 8px 0 0;
        border: 1px lightgray solid;
        border-bottom: 1px white solid;
        z-index: 1;
    }

    ul#sortable.task-body {
        padding: 10px 25px;
        background-color: #f7f7f7;
        border: 1px lightgray solid;
        min-height: 100px;
        list-style-type: none;
        margin: 0;
        /*box-shadow: 3px 3px 8px rgba(0,0,0,.3);*/
        border-radius: 0 8px 8px 0;
        z-index: 2;
    }

    ul#sortable.task-body li {
        background-color: white;
        padding: 8px;
        margin: 10px 0;
        width: 300px;
        border-radius: 5px;
        border: 1px lightgray solid;
    }

    ul#sortable.task-body li:hover {
        cursor: pointer;
    }

    .task-bottom {
        padding: 15px 25px;
        background-color: white;
        border: 1px lightgray solid;
        border-top: 1px white solid;
        border-radius: 0 0 8px 8px;
        z-index: 1;
    }

</style>

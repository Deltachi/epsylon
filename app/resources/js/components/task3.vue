<template>
    <div class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body row p-5 quiz-wrapper">
                <div class="col-4">
                    <div><b>Antwortmöglichkeiten</b></div>
                    <ul class="list-group">
                        <div v-for="(word, index) in task.data.words">
                            <li class="list-group-item draggables"><a class="option" :data-word="'word-'+index">{{word}}</a></li>
                        </div>
                    </ul>
                </div>
                <div class="answers col-8 d-flex flex-column justify-content-center">
                    <ol>
                        <li :id="'sentence-'+index" class="droppables" v-for="(sentence, index) in task.data.sentences" v-html="getSentence(sentence, index)"></li>
                    </ol>
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
        name: "task3",
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
            $(document).ready( function() {
                //initialize the quiz options
                $('.quiz-wrapper').find('li.draggables>a').each( function(i) {
                    var $this = $(this);
                    //var answerValue = $this.data('target');
                    //var $target = $('.answers .target[data-accept="'+answerValue+'"]');
                    var labelText = $this.html();
                    $this.draggable( {
                        revert: true,
                        revertDuration: 0,
                        containment: ".quiz-wrapper"
                    });
                });
                $('.quiz-wrapper').find('li.droppables>span').each( function(i) {
                    var $this = $(this);
                    $this.droppable( {
                        //accept: 'li>a.option[data-target="'+answerValue+'"]',
                        accept: 'li.draggables>a',
                        drop: function( event, ui ) {
                            //$(ui.draggable).remove();
                            let item_text = $(ui.draggable).text();
                            //$this.droppable('destroy');
                            //$(ui.draggable).html('&nbsp;');
                            $($this).text(item_text);
                        }
                    });
                })
            });
        },
        mounted() {
            this.triggerAnswerLoaded.$on('loaded', this.insertAnswerData);
            this.triggerAnswerLoaded.$on('generate-answer', this.convertAnswer);
        },
        methods:{
            getSentence(string, id){
                string = string.replace("_BLANK", "<span class='target' data-target='sentence-"+id+"'></span>");
                return string;
            },
            parseAnswer(_answer){
                let targets = document.getElementsByClassName("target");
                for(let target of targets){
                    let targetData = target.getAttribute("data-target");
                    if (_answer[targetData]){
                        target.innerText = _answer[targetData];
                    }
                }
            },
            convertAnswer(){
                let targets = document.getElementsByClassName("target");
                for(let target of targets){
                    let targetData = target.getAttribute("data-target");
                    if(target.innerText){
                        this.answer[targetData] = target.innerText;
                    }
                }
            },
            resetAnswer(){
                let targets = document.getElementsByClassName("target");
                for(let target of targets){
                    target.innerText = "";
                }
                this.answer = {};
            },
            triggerSave(){
                this.convertAnswer();
                this.$emit('save');
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
        data(){
            return {
                type: 3,
                task: {
                    title: "Drag und Drop Aufgabe",
                    description: "<p>Fill in the blanks by dragging the missing answer.</p>",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    data: {
                        'sentences': [
                            "An _BLANK a day keeps the doctor away.",
                            "Honesty is the best _BLANK.",
                            "He who _BLANK last laughs longest.",
                            "Two _BLANK don't make it right.",
                        ],
                        'words': ["policy", "banana", "rights", "laughs", "apple", "word"],
                        'blank': "_BLANK"
                    },
                    points: 0.0,
                },
                answer: {},
            }
        },
    }
</script>

<style>

    .quiz-wrapper .option{
        z-index: 999;
    }
    .quiz-wrapper .option:hover{
        cursor: pointer;
    }
    .quiz-wrapper .answers {
        display: inline-block;
        line-height: 25px;
    }
    .quiz-wrapper .answers ol{
        margin: 0;
    }
    .quiz-wrapper .answers li:not(:last-child){
        margin-bottom: 25px;
    }
    .quiz-wrapper .answers .target {
        display: inline-block;
        width: 130px;
        background: lightgray;
        margin: 0px 3px;
        text-align: center;
        height: 22px;
        vertical-align: text-bottom;
        border-radius: 3px;
        border: 1px solid lightgray;
        transition: background-color .2s ease;
    }
</style>



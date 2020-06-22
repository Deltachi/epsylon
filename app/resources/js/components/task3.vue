<template>
    <div class="card">
        <form>
            <div class="card-header p-4 pl-5 pr-5">
                <h2>{{task.title}}</h2>
                <div v-html="task.description"></div>
                <div class="text-muted small">{{task.hint}}</div>
            </div>
            <div class="card-body row quiz-wrapper p-5">
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
                        <!-- <li>An <span class="target" data-accept="apple">&nbsp;</span> a day keeps the doctor away.</li>
                        <li>Honesty is the best <span class="target" data-accept="policy">&nbsp;</span>.</li>
                        <li>He who  <span class="target" data-accept="laughs">&nbsp;</span> last laughs longest.</li>
                        <li>Two <span class="target" data-accept="wrongs">&nbsp;</span> don't make it right.</li> -->
                        <li class="droppables" v-for="(sentence, index) in task.data.sentences" v-html="getSentence(sentence, index)"></li>
                    </ol>
                </div>
            </div>
            <div class="card-footer d-flex flex-column align-items-end">
                <button type="button" @click="submitTask()" class="btn btn-primary">Speichern</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "task3",
        created() {
            $(document).ready( function() {
                //initialize the quiz options
                var answersLeft = [];
                $('.quiz-wrapper').find('li.draggables>a').each( function(i) {
                    var $this = $(this);
                    //var answerValue = $this.data('target');
                    //var $target = $('.answers .target[data-accept="'+answerValue+'"]');
                    var labelText = $this.html();
                    $this.draggable( {
                        revert: "invalid",
                        containment: ".quiz-wrapper"
                    });
                });
                $('.quiz-wrapper').find('li.droppables>span').each( function(i) {
                    var $this = $(this);
                    $this.droppable( {
                        //accept: 'li>a.option[data-target="'+answerValue+'"]',
                        accept: 'li.draggables>a',
                        drop: function( event, ui ) {
                            $this.draggable('destroy');
                            $this.droppable('destroy');
                            $this.html('&nbsp;');
                            $this.html(labelText);
                            //answersLeft.splice( answersLeft.indexOf( answerValue ), 1 );
                        }
                    });
                })
            });
        },
        data(){
            return {
                task: {
                    type: 3,
                    title: "Drag und Drop Aufgabe",
                    description: "<p class=\"question-description\">Fill in the blanks by dragging the missing answer.</p>",
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
                    }
                },
                answer: {

                }
            }
        },
        methods:{
            submitTask(){
                alert("Antwort wird gespeichert!");
            },
            getSentence(string, id){
                string = string.replace("_BLANK", "<span class='target' data-target='sentence-"+id+"'>&nbsp;</span>");
                return string;
            }
        }
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



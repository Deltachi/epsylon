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
                        <div v-for="solutions in task.subtasks.solution.length" :key="solutions">
                            <li class="list-group-item"><a class="option">{{task.subtasks.solution[solutions]}}</a></li>
                        </div>
                    </ul>
                </div>
                <div class="answers col-8 d-flex flex-column justify-content-center">
                    <ol>
                        <li>An <span class="target" data-accept="apple">&nbsp;</span> a day keeps the doctor away.</li>
                        <li>Honesty is the best <span class="target" data-accept="policy">&nbsp;</span>.</li>
                        <li>He who  <span class="target" data-accept="laughs">&nbsp;</span> last laughs longest.</li>
                        <li>Two <span class="target" data-accept="wrongs">&nbsp;</span> don't make it right.</li>
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
                $('.quiz-wrapper').find('li>a.option').each( function(i) {
                    var $this = $(this);
                    var answerValue = $this.data('target');
                    var $target = $('.answers .target[data-accept="'+answerValue+'"]');
                    var labelText = $this.html();
                    $this.draggable( {
                        revert: "invalid",
                        containment: ".quiz-wrapper"
                    });

                    if ( $target.length > 0 ) {
                        $target.droppable( {
                            accept: 'li>a.option[data-target="'+answerValue+'"]',
                            drop: function( event, ui ) {
                                $this.draggable('destroy');
                                $target.droppable('destroy');
                                $this.html('&nbsp;');
                                $target.html(labelText);
                                answersLeft.splice( answersLeft.indexOf( answerValue ), 1 );
                            }
                        });
                        answersLeft.push(answerValue);
                    } else { }
                });
            });
        },
        data(){
            return {
                task: {
                    type: 3,
                    title: "Drag und Drop Aufgabe",
                    description: "<p class=\"question-description\">Fill in the blanks by dragging the missing answer.</p>",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    subtasks: [
                        {
                            id: 0,
                            title: "Hier ist die Frage 1",
                            hint: "Hier ist ein Hinweis zur Frage 1",
                            solution:["policy", "banana", "rights", "laughs", "apple", "word"]
                        }
                    ]
                },
                answer: {

                }
            }
        },
        methods:{
            submitTask(){
                alert("Antwort wird gespeichert!");
            }
        }
    }
</script>

<style scoped>

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



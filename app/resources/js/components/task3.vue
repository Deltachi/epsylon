<template>
    <div class="card">
        <form>
            <div class="card-header">
                <h2>{{task.title}}</h2>
                <div v-html="task.description"></div>
                <div class="text-muted small">{{task.hint}}</div>
            </div>
            <div class="card-body row quiz-wrapper">
                <div class="col-4">
                    <div><b>Antwortmöglichkeiten</b></div>
                    <ul class="list-group">
                        <li class="list-group-item"><a class="option" data-target="carraway">Nick Carraway</a></li>
                        <li class="list-group-item"><a class="option" data-target="fitz">F. Scott Fitzgerald</a></li>
                        <li class="list-group-item"><a class="option" data-target="westegg">West Egg</a></li>
                        <li class="list-group-item"><a class="option" data-target="buchanan">Tom Buchanan</a></li>
                        <li class="list-group-item"><a class="option" data-target="daisy">Daisy</a></li>
                        <li class="list-group-item"><a class="option" data-target="ashes">Valley of Ashes</a></li>
                    </ul>
                </div>
                <div class="answers col-8 d-flex flex-column justify-content-center">
                    <ol>
                        <li><span class="target" data-accept="fitz">&nbsp;</span>, a native of St Paul, Minnesota, and also a member of the "Lost Generation" finished four novels including "This Side of Paradise".</li>
                        <li><span class="target" data-accept="carraway">&nbsp;</span> attended Yale with the large and brooding<span class="target" data-accept="buchanan">&nbsp;</span>.</li>
                        <li>George Wilson owns an unsuccessful garage in an area known as the <span class="target" data-accept="ashes">&nbsp;</span>, where Tom brings Nick for a party.</li>
                        <li>Jay Gatsby, the Buchanans, and Nick himself all make<span class="target" data-accept="westegg">&nbsp;</span>their home.</li>
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
                    type: 1,
                    title: "Drag und Drop Aufgabe",
                    description: "<p class=\"question-description\">Fill in the blanks by dragging the missing answer.</p>",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    subtasks: [
                        {
                            id: 0,
                            title: "Hier ist die Frage 1",
                            hint: "Hier ist ein Hinweis zur Frage 1"
                        },
                        {
                            id: 1,
                            title: "Hier ist die Frage 2",
                            hint: "Hier ist ein Hinweis.."
                        },
                        {
                            id: 2,
                            title: "Hier ist die Frage 3",
                            hint: "Hier ist ein Hinweis.."
                        }
                    ]
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
    .quiz-wrapper .answers .target:hover{
        background-color: white;
    }

</style>



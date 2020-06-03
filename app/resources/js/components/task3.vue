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
                <div class="lightbox-bg"></div>
                <div class="status confirm">
                    <p>All Answers Answered</p>
                </div>
                <div class="status deny">
                    <p>Answers Remain</p>
                </div>
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
                $('.quiz-wrapper button[type="submit"]').click( function() {
                    if ( answersLeft.length > 0 ) {
                        $('.lightbox-bg').show();
                        $('.status.deny').show();
                        $('.lightbox-bg').click( function() {
                            $('.lightbox-bg').hide();
                            $('.status.deny').hide();
                            $('.lightbox-bg').unbind('click');
                        });
                    } else {
                        $('.lightbox-bg').show();
                        $('.status.confirm').show();
                    }
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
    .quiz-wrapper .answers {
        display: inline-block;
        width: 335px;
        font-size: 13px;
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
        width: 110px;
        background: lightgray;
        margin: 0px 3px;
        text-align: center;
        height: 22px;
        vertical-align: text-bottom;
        border-radius: 3px;
    }
    .quiz-wrapper button[type="submit"] {
        display: block;
        position: relative;
        margin: 10px auto;
        padding: 10px;
        background: #19286c;
        border: none;
        color: white;
        font-size: 16px;
    }
    .lightbox-bg {
        display: none;
        position: absolute;
        z-index: 100;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.7);
    }
    .status {
        display: none;
        position: absolute;
        z-index: 110;
        text-align: center;
        width: 80%;
        top: 220px;
        left: 47px;
    }
    .status p {
        background: white;
        padding: 30px;
    }

</style>



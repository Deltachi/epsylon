<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
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
                        <li :id="'sentence-'+index" class="droppables" v-for="(sentence, index) in task.data.sentences" v-html="getSentence(sentence, index)"></li>
                    </ol>
                </div>
            </div>
            <task-footer></task-footer>
        </form>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task3",
        props: [
            'dataTask'
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskLoadingError,
        },
        created() {
            this.loadTask();
            if(this.dataTask && this.dataTask !== "null"){
                this.task = JSON.parse(this.dataTask);
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
                ready: false,
            }
        },
        methods:{
            submitTask(){
                let targets = document.getElementsByClassName("target");
                for(let target of targets){
                    let targetData = target.getAttribute("data-target");
                    let value = target.innerText;
                    this.answer[targetData] = value;
                }
                alert("Antwort wird gespeichert!\n"+JSON.stringify(this.answer));
                this.localSave();
            },
            getSentence(string, id){
                string = string.replace("_BLANK", "<span class='target' data-target='sentence-"+id+"'>&nbsp;</span>");
                return string;
            },
            localSave(){
                localStorage.setItem("task_"+this.type,JSON.stringify(this.answer));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.type)){
                    this.answer = JSON.parse(localStorage.getItem("task_"+this.type));
                    let targets = document.getElementsByClassName("target");
                    for(let target of targets){
                        let targetData = target.getAttribute("data-target");
                        if (this.answer[targetData]){
                            let value = this.answer[targetData];
                            target.innerText = value;
                        }
                    }
                }
            },
            localDelete(){
                if(localStorage.getItem("task_"+this.type)){
                    localStorage.removeItem("task_"+this.type);
                }
            },
            resetTask(affirmation = false){
                if(affirmation || confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    //this.localDelete();
                    this.answer = {};

                    let targets = document.getElementsByClassName("target");
                    for(let target of targets){
                        target.innerText = " ";
                    }

                    //Database connection
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let url = '/answer';
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({
                            user: this.user_id,
                            exam: this.exam_id,
                            task: this.task_id,
                        }),
                    })
                        .then(response => response.json())
                        .then(data => this.serverMessage(data))
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                }
            },
            keyEvent(event) {
                if (event.ctrlKey || event.metaKey) {
                    switch (String.fromCharCode(event.which).toLowerCase()) {
                        case 's':
                            event.preventDefault();
                            this.submitTask();
                            break;
                    }
                }
            },
        },
        mounted() {
            this.localLoad();
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



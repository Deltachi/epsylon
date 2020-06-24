<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <div class="pl-3">
                    <div class="card-body">
                        <p id="blanks-sentence">
                            <template v-for="(words, index) in task.data.sentence_exploded">
                                <input v-if="words === task.data.blank" type="text" v-model="answer[getID(index)]" :name="'blank-'+getID(index)" class="blank-space">
                                <span v-else>{{words}} </span>
                            </template>
                        </p>
                    </div>
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
        name: "task8",
        props: [
            'dataTask'
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskLoadingError,
        },
        created() {
            //Methodenaufrufe
            this.localLoad();
            //Variablenzuweisungen
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.task.data.sentence = this.replaceAll(this.task.data.sentence, this.task.data.blank, '~'+this.task.data.blank+'~');
                this.task.data.sentence_exploded = this.task.data.sentence.split("~");
                this.task.data.blank_ids = [];
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
                answer: [],
                ready: false
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+JSON.stringify(this.answer));
                this.localSave()
            },
            localSave(){
                localStorage.setItem("task_"+this.type,JSON.stringify(this.answer));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.type)){
                    this.answer = JSON.parse(localStorage.getItem("task_"+this.type));
                }
            },
            localDelete(){
                if(localStorage.getItem("task_"+this.type)){
                    localStorage.removeItem("task_"+this.type);
                }
            },
            reset(){
                if(confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    this.localDelete();
                    this.answer = [];
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
            }
        }
    }
</script>

<style scoped>
    .blank-space{
        margin: 8px 4px;
    }
</style>

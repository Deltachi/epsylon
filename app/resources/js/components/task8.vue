<template>
    <div class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <div class="pl-3">
                    <div class="card-body">
                        <p id="blanks">{{task.data.sentences}}</p>
                    </div>
                </div>
            </div>
            <task-footer></task-footer>
        </form>
    </div>
</template>
<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task9",
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
            //Variablenzuweisungen
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
            $( function() {
                var stringreplace = "_BLANK";
                var str1 = document.getElementById("blanks").innerHTML;
                var countblank = (document.getElementById("blanks").value = str1.split(stringreplace).length) - 1;
                for(var i=0;i<countblank;i++){
                    var str = document.getElementById("blanks").innerHTML;
                    var replacename = "answer-" + i;
                    var replaceinput = "<input v-model='answer[" + i + "]' :name='" + replacename + "' type='text' placeholder='Antwort...'>";
                    var res = str.replace(stringreplace,replaceinput);
                    document.getElementById("blanks").innerHTML = res;
                }
            } );
        },
        data(){
            return {
                type: 9,
                task: {
                    title: "",
                    description:"",
                    hint: "",
                    data: [],
                    points: 0.0,
                },
                answer: "",
                ready: false
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+this.answer);
                console.log(this.answer);
            },
        }

    }
</script>

<style scoped>

</style>

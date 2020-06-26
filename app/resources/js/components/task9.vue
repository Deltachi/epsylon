<template>
    <div v-if="ready" class="card">
        <form>
            <div class="card-header p-4 pl-5 pr-5">
                <h2>{{task.title}}</h2>
                <div class="text-muted">{{task.hint}}</div>
            </div>
            <div class="card-body">
                <div class="card mb-4" v-for="subtask in task.subtasks">
                    <div class="card-header p-3 pl-4 pr-4">
                        <h4>{{subtask.title}}</h4>
                        <div class="text-muted">{{subtask.hint}}</div>
                    </div>
                    <div class="pl-3">
                        <div class="card-body">
                            <p id="blanks">{{subtask.solution}}</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer d-flex flex-column align-items-end">
                <button type="button" @click="submitTask()" class="btn btn-primary">Speichern</button>
            </div>
        </form>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>
<!--  <input v-model="answer[subtask.id]" :name="'answer-'+subtask.id" type="text" class="form-control" placeholder="Antwort..."> -->
<script>
    export default {
        name: "task9",
        created() {
            //Methodenaufrufe
            this.loadTask();
            //Variablenzuweisungen
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
                task: {
                    type: 9,
                    title: "Bitte füllen Sie den Corona-Lückentext aus",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    subtasks: [
                        {
                            id: 0,
                            title: "Aufgabe1: Aufgabenstellung des Lückentext",
                            hint: "Hier ist ein Hinweis zum Lückentext",
                            solution:"Wenn jeder von uns zu Hause _BLANK sich ganz allein _BLANK dann können wir blank auch besiegen. Es geht _BLANK um mich um uns um jeden den man schützen _BLANK. Auch wenn die Zeiten _BLANK bleib zu Haus"
                        },
                    ]
                },
                answer: {

                }
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

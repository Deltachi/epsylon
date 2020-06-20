<template>
    <div class="card">
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
</template>
<!--  <input v-model="answer[subtask.id]" :name="'answer-'+subtask.id" type="text" class="form-control" placeholder="Antwort..."> -->
<script>
    export default {
        name: "task9",
        created() {
            //Methodenaufrufe
            //Variablenzuweisungen
            $( function() {
                var replacestring = /blank/gi;
                for(var i=0;i<6;i++){
                    var str = document.getElementById("blanks").innerHTML;
                    var dynname = "answer-" + i;
                    var res = str.replace(replacestring,"<input v-model='answer[i]' :name='answer-' type='text' placeholder='Antwort...'>");
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
                            countblank: "6",
                            solution:"Wenn jeder von uns zu Hause blank sich ganz allein blank dann können wir blank auch besiegen. Es geht blank um mich um uns um jeden den man schützen blank. Auch wenn die Zeiten blank bleib zu Haus"
                        },
                    ]
                },
                answer: {

                }
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!");
            },
            myreplace(){

            }
        }

    }
</script>

<style scoped>

</style>

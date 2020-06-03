<template>
    <div class="card">
        <form>
            <div class="card-header">
                <h2>{{task.title}}</h2>
                <div class="text-muted">{{task.hint}}</div>
            </div>
            <div class="card-body">
                <div class="card mb-4" v-for="subtask in task.subtasks">
                    <div class="card-header">
                        <h4>{{subtask.title}}</h4>
                        <div class="text-muted">{{subtask.hint}}</div>
                    </div>
                    <div id="checkdistance">
                        <div class="form-group row" v-for="index in subtask.solution.length" :key="index">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check" >
                                <label class="form-check-label" for="check">{{subtask.solution[index-1]}}</label>
                            </div>
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

<script>
    export default {
        name: "task4",
        created() {
            //Methodenaufrufe
            //Variablenzuweisungen
        },
        data(){
            return {
                task: {
                    type: 0,
                    title: "Bitte Klicken Sie die richtigen Antworten an",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    subtasks: [
                        {
                            id: 0,
                            title: "Aufgabe1: Welche Farbe enthält die Flagge von Deutschland",
                            hint: "Hier ist ein Hinweis zur Frage 1",
                            solution:["blau", "rot","gelb","weiß","schwarz"]

                        },
                        {
                            id: 1,
                            title: "Aufgabe2: Welche Farbe enthält die Flagge von Frankreich",
                            hint: "Hier ist ein Hinweis zur Frage 2",
                            solution:["rot", "pink","weiß","magenta","gelb"]
                        },
                    ]
                }
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!");
            },

        }

    }
</script>

<style scoped>
    #checkdistance{
        padding-top: 10px;
        padding-left: 40px;
    }

</style>

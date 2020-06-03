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
                        <div class="card-body" v-for="index in subtask.solution.length" :key="index">
                            <div class="checkboxes">
                                <label for="check"><input type="radio" class="form-check-input" id="check">{{subtask.solution[index-1]}}</label>
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
        name: "task5",
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
                            title: "Aufgabe1: Aufgabenstellung",
                            hint: "Hier ist ein Hinweis zur Frage 1",
                            solution:["Lösung1", "Lösung2","Lösung3","Lösung4","Lösung5"]

                        },
                        {
                            id: 1,
                            title: "Aufgabe2: Aufgabenstellung",
                            hint: "Hier ist ein Hinweis zur Frage 2",
                            solution:["Lösung1", "Lösung2","Lösung3","Lösung4","Lösung5"]
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
        padding-left: 30px;
    }
</style>

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
                            <div class="form-check mb-2" v-for="index in subtask.solution.length" :key="index">
                                <input class="form-check-input" type="radio" :name="'gridRadios'+subtask.id" :id="'gridRadios'+subtask.id+'-'+index" :value="subtask.solution[index-1]" v-model="answer[subtask.id]">
                                <label class="form-check-label" :for="'gridRadios'+subtask.id+'-'+index">
                                    {{subtask.solution[index-1]}}
                                </label>
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
                    type: 5,
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
                },
                answer: {

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

</style>

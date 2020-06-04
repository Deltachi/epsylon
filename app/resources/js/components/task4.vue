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
                    <div id="checkdistance">
                        <div class="form-group row" v-for="index in subtask.solution.length" :key="index">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" :id="'check'+subtask.id+'-'+index" :value="subtask.solution[index-1]" v-model="answer[subtask.id]">
                                <label class="form-check-label" :for="'check'+subtask.id+'-'+index">{{subtask.solution[index-1]}}</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer d-flex flex-row justify-content-between">
                <button type="button" @click="reset()" class="btn btn-outline-info">Zurücksetzen</button>
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
            this.localLoad();
        },
        data(){
            return {
                task: {
                    type: 4,
                    title: "Bitte klicken Sie die richtigen Antworten an",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    subtasks: [
                        {
                            id: 0,
                            title: "Aufgabe 1: Welche Farben enthält die Flagge von Deutschland?",
                            hint: "Hier ist ein Hinweis zur Frage 1",
                            solution:["blau", "rot","gelb","weiß","schwarz"]

                        },
                        {
                            id: 1,
                            title: "Aufgabe 2: Welche Farben enthält die Flagge von Frankreich?",
                            hint: "Hier ist ein Hinweis zur Frage 2",
                            solution:["rot", "pink","weiß","magenta","gelb"]
                        },
                    ]
                },
                answer: [
                    [],[]
                ]
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+JSON.stringify(this.answer));
                this.localSave(JSON.stringify(this.answer));
            },
            localSave(){
                localStorage.setItem("task_"+this.task.type,JSON.stringify(this.answer));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.task.type)){
                    this.answer = JSON.parse(localStorage.getItem("task_"+this.task.type));
                }
            },
            localDelete(){
                if(localStorage.getItem("task_"+this.task.type)){
                    localStorage.removeItem("task_"+this.task.type);
                }
            },
            reset(){
                if(confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    this.localDelete();
                    this.answer = [
                        [],[]
                    ]
                }
            }
        }
    }
</script>

<style scoped>
    #checkdistance{
        padding-top: 10px;
        padding-left: 40px;
    }

</style>

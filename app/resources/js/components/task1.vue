<template>
    <div class="card">
        <form>
            <div class="card-header p-4 pl-5 pr-5">
                <h2>{{task.title}}</h2>
                <div v-html="task.description"></div>
                <div class="text-muted small">{{task.hint}}</div>
            </div>
            <div class="card-body">
                <input v-model="answer['text']" :name="'answer-text'" type="text" class="form-control" placeholder="Antwort...">
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
        name: "task1",
        props: [
          'dataTask'
        ],
        created() {
            //Methodenaufrufe
            //Variablenzuweisungen
            this.localLoad();
            this.task = JSON.parse(this.dataTask);
            console.log(this.task);
        },
        data(){
            return {
                uuid: "38631",
                type: 1,
                task: {},
                answer:{}
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+JSON.stringify(this.answer));
                this.localSave(JSON.stringify(this.answer))
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
                    this.answer = {}
                }
            }
        }

    }
</script>

<style scoped>

</style>

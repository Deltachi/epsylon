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
                    <div class="card-body">
                        <input :name="'answer-'+subtask.id" type="text" class="form-control" placeholder="Antwort...">
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
        name: "task1",
        data(){
            return {
                task: {
                    type: 0,
                    title: "Das hier ist eine Aufgabe mit vielen Fragen",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    subtasks: [
                        {
                            id: 0,
                            title: "Hier ist die Frage 1",
                            hint: "Hier ist ein Hinweis zur Frage 1"
                        },
                        {
                            id: 1,
                            title: "Hier ist die Frage 2",
                            hint: "Hier ist ein Hinweis.."
                        },
                        {
                            id: 2,
                            title: "Hier ist die Frage 3",
                            hint: "Hier ist ein Hinweis.."
                        }
                    ]
                }
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!");
            }
        }

    }
</script>

<style scoped>

</style>

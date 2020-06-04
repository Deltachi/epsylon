<!-- Antworten in die richtige Reihenfolge bringen -->
<template>
    <div class="card">
        <div class="card-header p-4 pl-5 pr-5">
            <h2>{{task.title}}</h2>
            <div v-html="task.description"></div>
            <div class="text-muted small">{{task.hint}}</div>
        </div>
        <div class="card-body d-flex flex-column align-items-start pl-5 pr-5">
            <div class="task-top" v-if="task.top">{{task.top}}</div>
            <ul class="task-body" id="sortable">
                <li class="task-option" v-for="option in task.options" :data="option.id">
                    <div>{{option.title}}</div>
                    <div class="text-muted small" v-if="option.hint">{{option.hint}}</div>
                </li>
            </ul>
            <div class="task-bottom" v-if="task.bottom">{{task.bottom}}</div>
        </div>
        <div class="card-footer d-flex flex-column align-items-end">
            <button type="button" @click="submitTask()" class="btn btn-primary">Speichern</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "task6",
        created() {
            $( function() {
                $( "#sortable" ).sortable({
                    placeholder: "ui-state-highlight",
                    revert: false
                });
            } );
        },
        data(){
            return {
                task: {
                    type: 6,
                    title: "Finden Sie die richtige Reihenfolge",
                    description: "<p>Sortieren Sie die Antworten von wichtigster Bedeutung zu unwichtigster.</p>",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    top: "wichtig",
                    bottom: "unwichtig",
                    options: [
                        {
                            id: 0,
                            title: "Option 1",
                            hint: "Hier ist ein Hinweis zur Option 1"
                        },
                        {
                            id: 1,
                            title: "Option 2",
                            hint: "Hier ist ein Hinweis.."
                        },
                        {
                            id: 2,
                            title: "Option 3",
                            hint: "Hier ist ein Hinweis.."
                        }
                    ]
                },
                answer: {

                }
            }
        },
        methods:{
            submitTask(){

                alert("Aufgabe wird abgegeben!\n"+this.code);
                console.log(this.code);
            }
        }
    }
</script>

<style scoped>
    .task-top{
        padding: 15px 25px;
        background-color: white;
        border-radius: 8px 8px 0 0;
        border: 1px lightgray solid;
        border-bottom: 1px white solid;
        z-index: 1;
    }
    ul#sortable.task-body{
        padding: 10px 25px;
        background-color: #f7f7f7;
        border: 1px lightgray solid;
        min-height: 100px;
        list-style-type: none;
        margin: 0;
        /*box-shadow: 3px 3px 8px rgba(0,0,0,.3);*/
        border-radius: 0 8px 8px 0;
        z-index: 2;
    }
    ul#sortable.task-body li{
        background-color: white;
        padding: 8px;
        margin: 10px 0;
        width: 300px;
        border-radius: 5px;
        border: 1px lightgray solid;
    }
    ul#sortable.task-body li:hover{
        cursor: pointer;
    }
    .task-bottom{
        padding: 15px 25px;
        background-color: white;
        border: 1px lightgray solid;
        border-top: 1px white solid;
        border-radius: 0 0 8px 8px;
        z-index: 1;
    }

</style>

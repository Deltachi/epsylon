<!-- Antworten in die richtige Reihenfolge bringen -->
<template>
    <div class="card">
        <div class="card-header p-4 pl-5 pr-5">
            <h2>{{task.title}}</h2>
            <div v-html="task.description"></div>
            <div class="text-muted small">{{task.hint}}</div>
        </div>
        <div class="card-body pl-5 pr-5">
            <div class="row drag-container">
                <div class="col-6 d-flex flex-column justify-content-center">
                    <ul class="drag-list">
                        <li v-for="(input, index) in task.options.input" :id="'draggable'+index" :data-index="index" class="draggable input"><span class="badge badge-pill badge-secondary">{{input}}</span></li>
                    </ul>
                </div>
                <div class="col-6">
                    <div class="card mb-3" v-for="(output, index) in task.options.output">
                        <div class="card-header"><b>{{output}}</b></div>
                        <div class="card-body">
                            <ul :id="'sortable'+index" class="sortable">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex flex-column align-items-end">
            <button type="button" @click="submitTask()" class="btn btn-primary">Speichern</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "task7",
        created() {
            $( function() {
                $( ".sortable").sortable({
                    connectWith: ".sortable",
                    revert: 'invalid',
                });
                $(".draggable").each(function(i){
                    $(this).draggable({
                        connectToSortable: ".sortable",
                        helper: "original",
                        revert: 'invalid',
                    });
                });
            } );
        },
        data(){
            return {
                task: {
                    type: 5,
                    title: "Welche Antworten passen zu welchen Aussagen?",
                    description: "<p>Ordnen Sie die Antworten den passenden Aussagen zu.</p>",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    options: {
                        input: [
                            "Fakt 1",
                            "Fakt 2",
                            "Fakt 3",
                            "Fakt 4"
                        ],
                        output: [
                            "Aussage 1",
                            "Aussage 2",
                            "Aussage 3"
                        ]
                    }
                }
            }
        },
        methods:{

        }
    }
</script>

<style scoped>
    .sortable, .drag-list{
        min-height: 50px;
        list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px;
    }
    .input{
        z-index: 999;
        margin: 5px;  width: 150px;
    }
    .input>.badge.badge-pill{
        font-size: 90%;
        font-weight: 400;
        padding: 7px 25px;
        width: 100%;
    }
</style>

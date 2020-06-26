<!-- Antworten in die richtige Reihenfolge bringen -->
<template>
    <div v-if="ready" class="card">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body pl-5 pr-5">
            <div class="row drag-container">
                <div class="col-6 d-flex flex-column justify-content-center">
                    <ul class="drag-list">
                        <li v-for="(input, index) in task.data.input" :id="'draggable'+index" :data-index="index" class="draggable input"><span class="badge badge-pill badge-secondary">{{input}}</span></li>
                    </ul>
                </div>
                <div class="col-6">
                    <div class="card mb-3" v-for="(output, index) in task.data.output">
                        <div class="card-header"><b>{{output}}</b></div>
                        <div class="card-body">
                            <ul :id="'sortable'+index" class="sortable">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <task-footer></task-footer>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task7",
        props: [
            'dataTask'
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskLoadingError,
        },
        created() {
            this.loadTask();
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
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
                    type: 7,
                    title: "",
                    description: "",
                    hint: "",
                    data: {
                        input: [],
                        output: []
                    },
                    points: 0.0,
                },
                answer: "",
                ready: false
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

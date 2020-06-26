<!-- Antworten in die richtige Reihenfolge bringen -->
<template>
    <div v-if="ready" class="card">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body d-flex flex-column align-items-start pl-5 pr-5">
            <div class="task-top" v-if="task.data.top">{{task.data.top}}</div>
            <ul class="task-body" id="sortable">
                <li class="task-option" v-for="option in task.data" :data="option" v-if="option.name">
                    <div v-if="option.name">{{option.name}}</div>
                    <div v-if="option.hint" class="text-muted small">{{option.hint}}</div>
                </li>
            </ul>
            <div class="task-bottom" v-if="task.data.bottom">{{task.data.bottom}}</div>
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
        name: "task6",
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
            console.log(this.task.data);
            $(function () {
                $("#sortable").sortable({
                    placeholder: "ui-state-highlight",
                    revert: false
                });
            });

        },
        data() {
            return {
                task: {
                    type: 6,
                    title: "",
                    description: "",
                    hint: "",
                    top: "",
                    bottom: "",
                    data: [],
                },
                answer: {}
            }
        },
        methods: {
            submitTask() {
                alert("Aufgabe wird abgegeben!\n" + this.code);
                console.log(this.code);
            }
        }
    }
</script>

<style scoped>
    .task-top {
        padding: 15px 25px;
        background-color: white;
        border-radius: 8px 8px 0 0;
        border: 1px lightgray solid;
        border-bottom: 1px white solid;
        z-index: 1;
    }

    ul#sortable.task-body {
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

    ul#sortable.task-body li {
        background-color: white;
        padding: 8px;
        margin: 10px 0;
        width: 300px;
        border-radius: 5px;
        border: 1px lightgray solid;
    }

    ul#sortable.task-body li:hover {
        cursor: pointer;
    }

    .task-bottom {
        padding: 15px 25px;
        background-color: white;
        border: 1px lightgray solid;
        border-top: 1px white solid;
        border-radius: 0 0 8px 8px;
        z-index: 1;
    }

</style>

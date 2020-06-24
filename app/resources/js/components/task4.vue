<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <div id="checkdistance">
                    <div class="form-group row" v-for="solutions in task.data.solution">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label">{{solutions}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <task-footer></task-footer>
        </form>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskLoadingError from "./TaskLoadingError";

    export default {
        name: "task4",
        props: [
            'dataTask'
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskLoadingError,
        },
        created() {
            this.localLoad();
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
        },
        data() {
            return {
                type: 4,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: {},
                    points: 0.0,
                },
                answer: "",
                ready: false
            }
        },
        methods: {
            submitTask() {
                alert("Aufgabe wird abgegeben!\n" + JSON.stringify(this.answer));
                this.localSave(JSON.stringify(this.answer));
            },
            localSave() {
                localStorage.setItem("task_" + this.type, JSON.stringify(this.answer));
            },
            localLoad() {
                if (localStorage.getItem("task_" + this.type)) {
                    this.answer = JSON.parse(localStorage.getItem("task_" + this.type));
                    console.log(this.answer);
                }
            },
            localDelete() {
                if (localStorage.getItem("task_" + this.type)) {
                    localStorage.removeItem("task_" + this.type);
                }
            },
            reset() {
                if (confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")) {
                    this.localDelete();
                    this.answer = [
                        []
                    ]
                }
            }
        }
    }
</script>

<style scoped>
    #checkdistance {
        padding-top: 10px;
        padding-left: 40px;
    }

</style>

<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <input v-model="answer" :name="'answer'" type="text" class="form-control" placeholder="Antwort..." >
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
        name: "task1",
        props: [
          'dataTask'
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskLoadingError,
        },
        created() {
            //Methodenaufrufe
            this.localLoad();
            //Variablenzuweisungen
            if(this.dataTask && this.dataTask !== "null"){
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
        },
        data(){
            return {
                type: 1,
                task: {
                    title: "",
                    description: "",
                    hint: "",
                    data: {},
                    points: 0.0,
                },
                answer:"",
                ready: false
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+JSON.stringify(this.answer));
                this.localSave()
            },
            localSave(){
                localStorage.setItem("task_"+this.type,JSON.stringify(this.answer));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.type)){
                    this.answer = JSON.parse(localStorage.getItem("task_"+this.type));
                }
            },
            localDelete(){
                if(localStorage.getItem("task_"+this.type)){
                    localStorage.removeItem("task_"+this.type);
                }
            },
            reset(){
                if(confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    this.localDelete();
                    this.answer = null
                }
            },
            keyEvent(event) {
                if (event.ctrlKey || event.metaKey) {
                    switch (String.fromCharCode(event.which).toLowerCase()) {
                        case 's':
                            event.preventDefault();
                            this.submitTask();
                            break;
                    }
                }
            }
        },
        mounted() {
            $(window).bind('keydown', this.keyEvent);
        },

    }
</script>

<style scoped>

</style>

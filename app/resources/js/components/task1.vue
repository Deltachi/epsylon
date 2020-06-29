<template>
    <form>
        <task-header v-bind:task="task"></task-header>
        <div class="card-body">
            <input v-model="answer" name="answer" type="text" class="form-control" placeholder="Antwort..." >
        </div>
        <task-footer @save="triggerSave" @reset="triggerReset"></task-footer>
    </form>
</template>

<script>
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";

    export default {
        name: "task1",
        props: [
            'dataTask',
            'dataAnswer',
            'triggerAnswerLoaded',
        ],
        components: {
            TaskHeader,
            TaskFooter,
        },
        created() {
            //Initialisierungen
            if(this.dataTask && this.dataTask !== "null"){
                this.convertTaskData(this.dataTask);
                this.ready = true;
            }
            if(this.dataAnswer && this.dataAnswer !== "null"){
                this.convertAnswerData(this.dataAnswer);
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
                answer: "",
                answerFresh: "",
            }
        },
        methods: {
            convertTaskData(data){
                this.task = data;
            },
            getAnswerConversion(data){
                return data;
            },
            convertAnswerData(data){
                this.answer = this.getAnswerConversion(data);
            },
            triggerSave(){
                this.$emit('save');
            },
            triggerReset(affirm){
                this.answer = this.answerFresh;
                this.$emit('reset', affirm);
            }
        },
        mounted() {
            this.triggerAnswerLoaded.$on('loaded', this.convertAnswerData);
        }
    }
</script>

<style scoped>

</style>

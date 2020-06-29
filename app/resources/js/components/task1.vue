<template>
    <div v-if="ready" class="card">
        <form>
            <task-header v-bind:task="task"></task-header>
            <div class="card-body">
                <input v-model="answer" name="answer" type="text" class="form-control" placeholder="Antwort..." >
            </div>
            <task-footer @save="triggerSave" @reset="triggerReset"></task-footer>
        </form>
    </div>
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
                user_id: 1,
                exam_id: 1,
                task_id: 1,
                ready: false,
                server_message: "",
                server_message_type: "",
                server_message_handle: new Vue(),
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

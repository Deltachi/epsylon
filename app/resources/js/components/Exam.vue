<script>
    import Task from "./Task";
    import Timer from "./Timer";
    import TaskServerMessage from "./TaskServerMessage";

    export default {
        name: "Exam",
        components: {
            Task,
            Timer,
            TaskServerMessage,
        },
        data() {
            return {
                activeTask: 1,
                wasActiveTask: 1,
                triggerSave: new Vue(),
                message: "",
                messageType: "",
                triggerMessage: new Vue(),
            }
        },
        methods:{
            switchTask(id){
                let task = document.getElementById('task-'+this.activeTask);
                let task_new = document.getElementById('task-'+id);
                if(task_new){
                    this.triggerSave.$emit('save');
                    task.classList.remove('active');
                    task_new.classList.add('active');
                    this.wasActiveTask = this.activeTask;
                    this.activeTask = id;
                }
            },
            isActive(task_id){
                  return (task_id === this.activeTask || task_id === this.wasActiveTask);
            },
            incomingMessage(data){
                this.message = data.message;
                this.messageType = data.messageType;
                this.triggerMessage.$emit('show');
            },
        },
        created() {
        }
    }
</script>

<style scoped>

</style>

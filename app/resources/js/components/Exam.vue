<template>
    <div class="row justify-content-center">
        <div class="col-3">
            <Timer :data-end="exam.end"></Timer>
            <div class="card ">
                <div class="card-header text-center">
                    <h5 class="m-0 font-weight-light">Aufgaben</h5>
                </div>
                <div class="card-body p-0">
                    <table class="exam-task-table table table-hover table-striped mb-0">
                        <tbody>
                        <template v-for="(task, index) in exam.tasks">
                            <tr @click="switchTask(index+1)" >
                                <th :class="'align-middle text-center px-2 ' + (task.answered ? 'bg-success text-white':'')" scope="row">
                                    <span v-if="task.answered" class="text-nowrap"><i class="fa fa-check"></i></span>
                                    <span v-else class="text-nowrap"><i class="fa fa-minus"></i></span>
                                </th>
                                <th class="align-middle text-center px-2" scope="row"><span class="font-weight-light">{{index+1}}</span> </th>
                                <td class="align-middle" v-text="task.title"></td>
                                <td class="align-middle text-right px-2" v-text="task.points+'P'"></td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    Bearbeitungsfortschritt:
                    <div class="progress mb-4" >
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">50%</div>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-block text-uppercase">Klausur abgeben</button>
                </div>
            </div>
        </div>
        <div class="col-md-9 d-flex flex-column justify-content-center">
            <template v-for="(task, index) in exam.tasks">
                <div :id="'task-'+(index+1)" :class="'task-container'+((index+1) === 1 ? ' active' : '')">
                    <task
                        :data-task="JSON.stringify(task)"
                        :data-exam="JSON.stringify(exam)"
                        :data-user-id="user.id"
                        :is-active="isActive(index+1)"
                        :was-active="wasActive(index+1)"
                        :trigger-save="triggerSave"
                        @server-message="incomingMessage"
                    ></task>
                </div>
            </template>
            <task-server-message
                v-bind:message="message"
                v-bind:message-type="messageType"
                :trigger-handle="triggerMessage"
            ></task-server-message>
        </div>
    </div>
</template>
<script>
    import Task from "./Task";
    import Timer from "./Timer";
    import TaskServerMessage from "./TaskServerMessage";

    export default {
        name: "Exam",
        props:[
          'dataTasks',
          'dataExam',
          'dataUser',
        ],
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
                task: null,
                tasks: null,
                user: {
                    id: 1,
                },
                exam: {
                    begin: "",
                    end: "",
                    status: "",
                    title: "",
                    tasks: {
                        id: 1,
                        type: 1,
                        points: 0,
                        title: "",
                        data: null,
                        answered: false,
                    },
                },
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
                  return (task_id === this.activeTask);
            },
            wasActive(task_id){
                return (task_id === this.wasActiveTask);
            },
            incomingMessage(data){
                this.message = data.message;
                this.messageType = data.messageType;
                this.triggerMessage.$emit('show');
            },
        },
        created() {
            console.log(JSON.parse(this.dataTasks));
            this.tasks = JSON.parse(this.dataTasks)
            console.log(JSON.parse(this.dataExam));
            this.exam = JSON.parse(this.dataExam);
            console.log(JSON.parse(this.dataUser));
            this.user = JSON.parse(this.dataUser);
        }
    }
</script>

<style scoped>

</style>

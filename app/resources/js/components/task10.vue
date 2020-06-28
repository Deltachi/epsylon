<template>
    <div v-if="ready" class="card task">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body p-0 task__body">
            <ckeditor :editor="editor" v-model="answer" :config="editorConfig"></ckeditor>
        </div>
        <task-server-message v-if="server_message" v-bind:message="server_message" v-bind:message_type="server_message_type" :animation_handle="server_message_handle"></task-server-message>
        <task-footer></task-footer>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
    import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials';
    import Heading from '@ckeditor/ckeditor5-heading/src/heading';
    import List from '@ckeditor/ckeditor5-list/src/list';
    import BoldPlugin from '@ckeditor/ckeditor5-basic-styles/src/bold';
    import ItalicPlugin from '@ckeditor/ckeditor5-basic-styles/src/italic';
    import LinkPlugin from '@ckeditor/ckeditor5-link/src/link';
    import ParagraphPlugin from '@ckeditor/ckeditor5-paragraph/src/paragraph';
    import Underline from '@ckeditor/ckeditor5-basic-styles/src/underline';
    import Strikethrough from '@ckeditor/ckeditor5-basic-styles/src/strikethrough';
    import Code from '@ckeditor/ckeditor5-basic-styles/src/code';
    import Subscript from '@ckeditor/ckeditor5-basic-styles/src/subscript';
    import Superscript from '@ckeditor/ckeditor5-basic-styles/src/superscript';
    import CodeBlock from '@ckeditor/ckeditor5-code-block/src/codeblock';
    import TaskHeader from "./TaskHeader";
    import TaskFooter from "./TaskFooter";
    import TaskLoadingError from "./TaskLoadingError";
    import TaskServerMessage from "./TaskServerMessage";

    export default {
        name: 'task10',
        props: [
            'dataTask',
            'dataAnswer',
            'dataUserId',
            'dataExamId',
            'dataTaskId',
        ],
        components: {
            TaskHeader,
            TaskFooter,
            TaskServerMessage,
            TaskLoadingError,
        },
        created() {
            //Methodenaufrufe
            this.loadTask();
            //Variablenzuweisungen
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
            }
            if(this.dataUserId && this.dataUserId !== "null"){
                this.user_id = this.dataUserId;
            }
            if(this.dataExamId && this.dataExamId !== "null"){
                this.exam_id = this.dataExamId;
            }
            if(this.dataTaskId && this.dataTaskId !== "null"){
                this.task_id = this.dataTaskId;
            }
            this.answer = this.task.data.editorData;
        },
        data() {
            return {
                type: 10,
                editor: ClassicEditor,
                editorConfig: {
                    language: 'de',
                    plugins: [
                        EssentialsPlugin,
                        Heading,
                        List,
                        BoldPlugin,
                        ItalicPlugin,
                        Underline, Strikethrough, Code, Subscript, Superscript,
                        LinkPlugin,
                        CodeBlock,
                        ParagraphPlugin
                    ],

                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic','underline', 'strikethrough', 'code','subscript', 'superscript',
                            'link',
                            'bulletedList',
                            'numberedList',
                            'codeBlock',
                            '|',
                            'undo',
                            'redo'
                        ]
                    },
                },
                task: {
                    title: "Eine Aufgabe mit WYSIWYG-Editor",
                    description:"Hier kann ein vollformatierter Text geschrieben werden, der auch in der DB erhalten bleibt.",
                    hint: "",
                    data: {
                        editorData: '<p>Hello there.</p>',
                    },
                    points: 10.0,
                },
                answer:"",
                user_id: 1,
                exam_id: 1,
                task_id: 10,
                ready: true,
                server_message: "",
                server_message_type: "",
                server_message_handle: new Vue(),
            };
        },
        methods: {
            loadTask(){
                //Database connection
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let url = '/answer/'+this.user_id+"/"+this.exam_id+"/"+this.task_id;
                fetch(url, {
                    method: 'GET',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                })
                    .then(response => response.json())
                    .then(data => this.serverData(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            submitTask(){
                //alert("Aufgabe wird abgegeben!\n"+JSON.stringify(this.answer));
                console.log(this.answer);
                //this.localSave()
                //Database connection
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let url = '/answer';
                fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        user: this.user_id,
                        exam: this.exam_id,
                        task: this.task_id,
                        data: this.answer
                    }),
                })
                    .then(response => response.json())
                    .then(data => this.serverMessage(data))
                    .catch((error) => {
                        console.error('Error:', error);
                    });
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
            resetTask(affirmation = false){
                if(affirmation || confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    //this.localDelete();
                    this.answer = null;

                    //Database connection
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let url = '/answer';
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({
                            user: this.user_id,
                            exam: this.exam_id,
                            task: this.task_id,
                        }),
                    })
                        .then(response => response.json())
                        .then(data => this.serverMessage(data))
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                }
            },
            reset(){
                if(confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")){
                    this.localDelete();
                    this.answer = '';
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
            },
            serverMessage(response){
                console.log(response.message);
                this.server_message = response.message;
                this.server_message_type = response.message_type;

                this.server_message_handle.$emit('animate');
            },
            serverData(response){
                if(response.success){
                    console.log(response.data);
                    this.answer = JSON.parse(response.data);
                }
                console.log(response.message);
                this.server_message = response.message;
                this.server_message_type = response.message_type;
                this.server_message_handle.$emit('animate');
            }
        }
    };
</script>
<style>
    .task .task__body .ck-toolbar.ck-toolbar_grouping, .task .task__body .ck-content.ck-editor__editable:not(.ck-focused){
        border-color: transparent;
        padding: 0 3em;
    }
    .task .task__body .ck-content.ck-editor__editable{
        padding: 0 3em;
    }
    .task .task__body .ck-toolbar.ck-toolbar_grouping{
        border-bottom-color: #c4c4c4;
        border-bottom-width: 1px;
    }
</style>

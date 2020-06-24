<template>
    <div v-if="ready" class="card task">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body p-0 task__body">
            <ckeditor :editor="editor" v-model="answer" :config="editorConfig"></ckeditor>
        </div>
        <task-footer></task-footer>
    </div>
    <task-loading-error v-else></task-loading-error>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
    import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials';
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

    export default {
        name: 'task10',
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
            //Variablenzuweisungen
            if (this.dataTask && this.dataTask !== "null") {
                this.task = JSON.parse(this.dataTask);
                this.ready = true;
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
                        BoldPlugin,
                        ItalicPlugin,
                        Underline, Strikethrough, Code, Subscript, Superscript,
                        LinkPlugin,
                        CodeBlock,
                        ParagraphPlugin
                    ],

                    toolbar: {
                        items: [
                            'bold',
                            'italic','underline', 'strikethrough', 'code','subscript', 'superscript',
                            'link',
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
                answer: "",
                ready: true
            };
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+JSON.stringify(this.answer));
                //this.localSave()
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

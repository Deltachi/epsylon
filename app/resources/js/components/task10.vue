<template>
    <div class="card task">
        <task-header v-bind:task="task"></task-header>
        <div class="card-body p-0 task__body">
            <ckeditor :editor="editor" v-model="answer" :config="editorConfig"></ckeditor>
        </div>
        <task-footer @save="triggerSave" @reset="triggerReset"></task-footer>
    </div>
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

    export default {
        name: 'task10',
        props: [
            'dataTask',
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
                    title: "",
                    description: "",
                    hint: "",
                    data: null,
                    points: 0.0,
                },
                answer: "",
                answerFresh: "",
            };
        },
        mounted() {
            this.triggerAnswerLoaded.$on('loaded', this.convertAnswerData);
        },
        methods: {
            triggerSave(next = false){
                this.$emit('save', next);
            },
            triggerReset(affirm){
                this.answer = "";
                this.$emit('reset', affirm);
            },
            /**
             * Wandele die Task-Daten in ein Format um, dass diese Aufgabe benötigt.
             * Manipulier gegebenenfalls die DOM
             * @param task
             */
            convertTaskData(task){
                //Falls eine Umwandlung der Daten stattfinden soll
                this.task = task;
            },
            /**
             * Wandele die Antwort-Daten in ein Format um, dass diese Aufgabe benötigt.
             * @param data
             */
            convertAnswerData(data){
                //Falls eine Umwandlung der Daten stattfinden soll
                this.answer = data;
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

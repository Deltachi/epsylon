<template>
    <div class="col-12">
        <div class="card mb-5">
            <div class="card-header">
                <h1>Klausurdaten</h1>
            </div>
            <div class="card-body spacing">
                <label>Titel der Klausur</label>
                <input class="form-control" type="text" v-model="exam.title">
                <label>Beginn der Klausur</label>
                <input class="form-control" type="text" v-model="exam.begin">
                <label>Ende der Klausur</label>
                <input class="form-control" type="text" v-model="exam.end">
                <div class="form-group mt-4">
                    <input class="form-check-inline" type="checkbox" v-model="exam.reenter">
                    <label class="form-check-label">Kann die Klausur vom Studenten nach Beenden (im Zeitrahmen) wieder geöffnet werden?</label><br>
                </div>
                <label>Allgemeine Hinweise zur Klausur</label>
                <ckeditor v-model="exam.terms" :editor="editor" :config="editorConfig"></ckeditor>
            </div>
        </div>
        <div v-for="(task, index) in tasks" class="card task-data createtask spacing mb-4">
            <div class="card-header">
                <button @click="deleteTask(index)" class="btn btn-outline-danger btn-sm float-right"><i class="fa fa-times"></i></button>
                <h2>Aufgabe {{index+1}}</h2>
                <hr>
                <label>Aufgabentyp</label>
                <select class="form-control" name="taskType" id="taskType" v-model="task.type" @change="checkTaskData(task)">
                    <option value="1">Einfaches Textfeld als Antwortfeld</option>
                    <option value="10">Text-Editor als Antwortfeld</option>
                    <option value="2">Code Editor</option>
                    <option value="3">Lückentext mit Antwortmöglichkeiten</option>
                    <option value="8">Lückentext mit Freitextfeldern</option>
                    <option value="4">Multiple Choice (mehrere Antworten möglich)</option>
                    <option value="5">Multiple Choice (eine Antwort möglich)</option>
                    <option value="6">Sortieren von Begriffen</option>
                    <!--<option value="7">Zuordnen von Begriffen</option>-->
                </select>
                <label>Titel</label>
                <input v-model="task.title" type="text" class="title form-control" >
                <label>Aufgabenstellung</label>
                <ckeditor v-model="task.description" :editor="editor" :config="editorConfig"></ckeditor>
                <label>Hinweis</label>
                <input v-model="task.hint" type="text" class="title form-control" >
            </div>
            <div v-if="data[task.type]" class="card-body">
                <label>Aufgabeninhalt</label>
                <MonacoEditor
                    width="100%"
                    height="300px"
                    theme="vs-dark"
                    language="javascript"
                    :options="options"
                    v-model="task.data"
                ></MonacoEditor>
            </div>
            <div class="card-footer">
                <label>Erwartungshorizont</label>
                <ckeditor  v-model="task.solution" :editor="editor" :config="editorConfig"></ckeditor>
            </div>
        </div>
        <div class="mt-4 d-flex">
            <button @click="addTask" class="btn btn-primary btn-block mt-0 mr-2">Aufgabe Hinzufügen</button>
            <button @click="saveExam" class="btn btn-success btn-block mt-0 ml-2">Klausur Speichern</button>
        </div>
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
    import MonacoEditor from 'monaco-editor-vue';

    export default {
        name: "ExamEditor",
        props: [
            'dataExam',
            'dataTasks',
        ],
        components:{
            MonacoEditor,
        },
        created() {
            if (this.dataExam){
                console.log(this.dataExam);
                this.exam = JSON.parse(this.dataExam);
            }
            if (this.exam.tasks){
                this.tasks = this.exam.tasks;
                for(let task of this.tasks){
                    console.log(task.data);
                    task.data = JSON.stringify(task.data);
                }
            }
            this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        },
        data(){
            return {
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
                options: {
                    //Monaco Editor Options
                    wordWrap: "on"
                },
                exam: {
                    id: 1,
                    subject_id: 1,
                    title: "",
                    begin: "",
                    end: "",
                    reenter: false,
                    terms: "",
                },
                tasks: [],
                data: {
                    1: null,
                    2: "\/\/Hier kann bereits Code vorgegeben sein.",
                    3: "{\"sentences\":[\"An _BLANK a day keeps the doctor away.\", \"Honesty is the best _BLANK.\"],\"words\":[\"policy\", \"banana\", \"rights\", \"laughs\", \"apple\", \"wrongs\"],\"blank\":\"_BLANK\"}",
                    4: "[\"blau\",\"rot\",\"gelb\",\"weiß\",\"schwarz\"]",
                    5: "\"Auswahl 1\", \"Auswahl 2\",\"Auswahl 3\",\"Auswahl 4\",\"Auswahl 5\"",
                    6: "{\"options\":[\"Begriff 1\",\"Begriff 2\",\"Begriff 3\"],\"top\":\"Ganz wichtig\",\"bottom\":\"Nicht so wichtig\"}",
                    8: "{\"sentence\":\"In diesem Lückentext stehen _BLANK. Diese _BLANK können ausgefüllt werden.\",\"blank\":\"_BLANK\"}",
                    10: null,
                },
                token: null,
            }
        },
        methods:{
            addTask(){
              this.tasks.push({
                  type:1,
                  id:null,
              });
            },
            checkTaskData(task){
                if (this.data[task.type]){
                    task.data = this.data[task.type];
                }
            },
            deleteTask(taskId){
                if(this.tasks[taskId]){
                    if (this.tasks[taskId].id){
                        this.submitDeleteTask(this.tasks[taskId].id);
                    }
                    this.tasks.splice(taskId,1);
                }
            },
            saveExam(){
                this.submitData();
                window.location.href = "http://localhost/exam/edit/"+this.exam.subject_id;
            },
            submitData(){
                //Answer Data
                let submit_data = JSON.stringify({
                    exam: this.exam.id,
                    data: this.exam,
                });
                //Database connection
                let url = '/edit_exam';
                fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": this.token
                    },
                    credentials: "same-origin",
                    body: submit_data,
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Response:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
            submitDeleteTask(taskId){
                //Database connection
                let url = '/task';
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": this.token
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        task: taskId,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Response:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            },
        },
    }
</script>

<style>
    .spacing input, .spacing select, .spacing .ck-editor{
        margin-bottom: 20px!important;
    }
</style>

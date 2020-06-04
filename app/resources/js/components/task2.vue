<template>
    <div class="card">
        <form>
            <div class="card-header p-4 pl-5 pr-5">
                <h2>{{task.title}}</h2>
                <div v-html="task.description"></div>
                <div class="text-muted small">{{task.hint}}</div>
            </div>
            <div class="card-body editor-wrapper p-0">
                <MonacoEditor
                    width="100%"
                    height="500px"
                    theme="vs-dark"
                    language="cpp"
                    :options="options"
                    :value="code"
                    v-model="code"
                    @change="onChange"
                ></MonacoEditor>
            </div>
            <div class="card-footer d-flex flex-row justify-content-between">
                <button type="button" @click="reset()" class="btn btn-outline-info">Zurücksetzen</button>
                <button type="button" @click="submitTask()" class="btn btn-primary">Speichern</button>
            </div>
        </form>
    </div>
</template>

<script>
    import MonacoEditor from 'monaco-editor-vue';
    export default {
        name: "task2",
        components: {
            MonacoEditor
        },
        created() {
            this.localLoad();
        },
        data(){
            return {
                code: 'int x = 0;\n' +
                    'int myFunc(int a, int b){\n' +
                    '    int out = a + b;\n' +
                    '    return out;\n' +
                    '}',
                task: {
                    type: 2,
                    title: "Das hier ist eine Programmier-Aufgabe in C++",
                    description: "<p>Hier ist eine detaillierte Beschreibung der Aufgabe</p><ul><li>Aufgabe 1.1</li><li>Aufgabe 1.2</li><li>Aufgabe 1.3</li></ul>",
                    hint: "Hier stehen Hinweise zur Aufgabe",
                    subtasks: [
                        {
                            id: 0,
                            title: "Hier ist die Frage 1",
                            hint: "Hier ist ein Hinweis zur Frage 1"
                        },
                        {
                            id: 1,
                            title: "Hier ist die Frage 2",
                            hint: "Hier ist ein Hinweis.."
                        },
                        {
                            id: 2,
                            title: "Hier ist die Frage 3",
                            hint: "Hier ist ein Hinweis.."
                        }
                    ]
                },
                answer:"",
                options: {
                    //Monaco Editor Options
                }
            }
        },
        methods: {
            submitTask(){
                alert("Aufgabe wird abgegeben!\n"+this.code);
                this.localSave();
            },
            onChange(value) {
                //this.code = value;
                //console.log(value);
            },
            localSave(){
                localStorage.setItem("task_"+this.type,JSON.stringify(this.code));
            },
            localLoad(){
                if(localStorage.getItem("task_"+this.type)){
                    this.code = JSON.parse(localStorage.getItem("task_"+this.type));
                }
            },
            localDelete(){
                if(localStorage.getItem("task_"+this.type)){
                    localStorage.removeItem("task_"+this.type);
                }
            },
            reset(){
                if(confirm("Möchten Sie die Bearbeitung Ihrer Aufgabe zurücksetzen?")) {
                    this.localDelete();
                    this.code = "";
                }
            }
        }

    }
</script>

<style scoped>
    .editor-wrapper{
        width: calc(100%);
        overflow: hidden;
    }
</style>

<template>
    <div class="card">
        <form>
            <div class="card-header">
                <h2>{{task.title}}</h2>
                <div class="text-muted">{{task.hint}}</div>
            </div>
            <div class="card-body">
                <MonacoEditor
                    width="800"
                    height="500"
                    theme="vs-dark"
                    language="cpp"
                    :options="options"
                    :value="code"
                    v-model="code"
                    @change="onChange"
                ></MonacoEditor>
            </div>
            <div class="card-footer d-flex flex-column align-items-end">
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
        data(){
            return {
                code: 'int x = 0;\n' +
                    'int myFunc(int a, int b){\n' +
                    '    int out = a + b;\n' +
                    '    return out;\n' +
                    '}',
                task: {
                    type: 1,
                    title: "Das hier ist eine Programmier-Aufgabe in C++",
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
                options: {
                    //Monaco Editor Options
                }
            }
        },
        methods: {
            submitTask(){

                alert("Aufgabe wird abgegeben!\n"+this.code);
                console.log(this.code);
            },
            onChange(value) {
                //this.code = value;
                //console.log(value);
            }
        }

    }
</script>

<style scoped>

</style>

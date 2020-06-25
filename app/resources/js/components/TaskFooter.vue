<template>
    <div class="card-footer d-flex flex-row justify-content-between">
        <button type="button" @click="reset()" class="btn btn-outline-info">Zurücksetzen</button>
        <button type="button" @click="submitTask()" class="btn btn-primary">Speichern</button>
    </div>
</template>

<script>
    export default {
        name: "TaskFooter",
        methods: {
            reset(){
                this.$parent.resetTask();
            },
            submitTask(){
                this.$parent.submitTask();
            }
        }
    }
</script>

<style scoped>

</style>

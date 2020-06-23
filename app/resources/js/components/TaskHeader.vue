<template>
    <div class="card-header p-4 pl-5 pr-5">
        <div class="float-right badge badge-secondary px-2 py-1 font-weight-light" style="font-size: medium">{{task.points}} Punkte</div>
        <h2>{{task.title}}</h2>
        <div v-html="task.description"></div>
        <div class="text-muted small">{{task.hint}}</div>
    </div>
</template>

<script>
    export default {
        name: "taskHeader",
        props: ['task'],
    }
</script>

<style scoped>

</style>

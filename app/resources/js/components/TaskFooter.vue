<template>
    <div class="card-footer d-flex flex-row justify-content-between">
        <!--<button type="button" @click="reset()" class="btn btn-outline-info">Zurücksetzen</button>-->
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#resetAffirmation">
            Zurücksetzen
        </button>

        <!-- Modal -->
        <div class="modal fade" id="resetAffirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Möchten Sie die Bearbeitung wirklich zurücksetzen?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-primary" @click="reset(true)" data-dismiss="modal">Zurücksetzen</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" @click="submitTask()" class="btn btn-primary">Speichern</button>
    </div>
</template>

<script>
    export default {
        name: "TaskFooter",
        methods: {
            reset(affirm = false){
                this.$parent.resetTask(affirm);
            },
            submitTask(){
                this.$parent.submitTask();
            }
        }
    }
</script>

<style scoped>

</style>

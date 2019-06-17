<template><div class="card">
    <h3 class="card-header">
        {{ assignment.name }}
        <button class="float-right btn btn-sm btn-soft-success px-3"
            v-on:click="editAssignment">
            <i class="fas fa-edit"></i>
        </button>
    </h3>
    <div class="card-body" v-html="assignment.content_html"></div>
    <div class="card-footer">
        <span class="float-right">
            <assignment-d-d-l-partial
                    :api="api + '/' + assignment.id"
                    :due_time="assignment.due_time"
                    :finished_at="assignment.finished_at"
            ></assignment-d-d-l-partial>
        </span>
    </div>

    <assignment-editor-personal
            :id="editorID"
            :api="api + '/' + assignment.id"
            :assignment="assignment"
            v-on:updateAssignment="updateAssignment"
            v-on:deleteAssignment="deleteAssignment"
    ></assignment-editor-personal>
</div>
</template>

<script>
    import AssignmentDDLPartial from "./AssignmentDDLPartial";
    import AssignmentEditorPersonal from "./AssignmentEditorPersonal";
    export default {
        name: "AssignmentItemPersonal",
        components: {AssignmentEditorPersonal, AssignmentDDLPartial},
        props: ['api', 'assignment'],
        data: function () {
            return {
                editorID: 'AssignmentEditor' + this.assignment.id,
            }
        },
        methods: {
            editAssignment() {
                window.$('#' + this.editorID).modal('show');
            },
            updateAssignment(newAssignment) {
                this.$emit('updateAssignment', {
                    oldAssignment: this.assignment,
                    newAssignment: newAssignment,
                });
            },
            deleteAssignment() {
                this.$emit('deleteAssignment', this.assignment);
            }
        }
    }
</script>

<style scoped>

</style>
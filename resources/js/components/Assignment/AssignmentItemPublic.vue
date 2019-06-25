<template>
    <div class="card">
        <h3 class="card-header">
            {{ assignment.course_name }} - {{ assignment.name }}
            <button v-if="assignment.is_course_admin"
                    class="float-right btn btn-sm btn-soft-info px-3"
                    v-on:click="editAssignment">
                <i class="fas fa-edit"></i>
            </button>
        </h3>
        <div ref="content" class="card-body" v-html="assignment.content_html"></div>
        <div class="card-footer">
            <assignment-rate-partial
                    :api="api + '/' + assignment.id + '/rate'"
                    :rate_info="assignment.rate_info"
            ></assignment-rate-partial>
            <assignment-d-d-l-partial
                    :api="api + '/' + assignment.id"
                    :due_time="assignment.due_time"
                    :finished_at="assignment.finished_at"
            ></assignment-d-d-l-partial>
        </div>

        <assignment-editor
                :id="editorID"
                :api="api + '/' + assignment.id"
                :assignment="assignment"
                v-on:updateAssignment="updateAssignment"
                v-on:deleteAssignment="deleteAssignment"
        ></assignment-editor>
    </div>
</template>

<script>
    import AssignmentDDLPartial from "./AssignmentDDLPartial";
    import AssignmentRatePartial from "./AssignmentRatePartial";
    import AssignmentEditor from "./AssignmentEditor";
    import renderMathInElement from "../../../../public/katex/contrib/auto-render";

    export default {
        name: "AssignmentItemPublic",
        components: {AssignmentEditor, AssignmentRatePartial, AssignmentDDLPartial},
        props: ['api', 'assignment'],
        data: function () {
            return {
                editorID: 'AssignmentEditorPublic' + this.assignment.id,
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
        },
        mounted() {
            if (renderMathInElement) {
                renderMathInElement(this.$refs.content, {
                    delimiters: [
                        {left: "$$", right: "$$", display: true},
                        {left: "\\[", right: "\\]", display: true},
                        {left: "$", right: "$", display: false},
                        {left: "\\(", right: "\\)", display: false}
                    ]
                });
            }
        },
    }
</script>

<style scoped>

</style>
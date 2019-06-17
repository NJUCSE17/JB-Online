<template><div class="card">
    <h3 class="card-header">
        {{ assignment.name }}
        <button class="float-right btn btn-sm btn-soft-success px-3">
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
</div>
</template>

<script>
    import AssignmentDDLPartial from "./AssignmentDDLPartial";
    export default {
        name: "AssignmentItemPersonal",
        components: {AssignmentDDLPartial},
        props: ['api', 'assignment'],
    }
</script>

<style scoped>

</style>
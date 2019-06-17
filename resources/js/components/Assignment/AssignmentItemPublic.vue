<template><div class="card">
    <h3 class="card-header">
        {{ assignment.course_name }} - {{ assignment.name }}
        <button v-if="assignment.is_course_admin" class="float-right btn btn-sm btn-soft-info px-3">
            <i class="fas fa-edit"></i>
        </button>
    </h3>
    <div class="card-body" v-html="assignment.content_html"></div>
    <div class="card-footer">
        <assignment-rate-partial
                :api="api + '/' + assignment.id + '/rate'"
                :rate_info="assignment.rate_info"
        ></assignment-rate-partial>
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
    import AssignmentRatePartial from "./AssignmentRatePartial";
    export default {
        name: "AssignmentItemPublic",
        components: {AssignmentRatePartial, AssignmentDDLPartial},
        props: ['api', 'assignment'],
    }
</script>

<style scoped>

</style>
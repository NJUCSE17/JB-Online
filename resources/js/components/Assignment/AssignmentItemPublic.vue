<template><div class="card">
    <h3 class="card-header">
        {{ assignment.name }}
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
                    :finish_record="assignment.finish_record"
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
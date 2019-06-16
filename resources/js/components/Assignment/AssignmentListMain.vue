<template>
    <div v-if="initializing">
        <div class="row">
            <div class="col text-center">
                <div class="spinner spinner-border" role="status"></div>
            </div>
        </div>
    </div>
    <div v-else-if="assignments" id="assignmentList">
        <div v-for="assignment in assignments">
            <assignment-item-public
                    v-if="assignment.course_id"
                    :api="api_public"
                    :assignment="assignment"
            ></assignment-item-public>
            <assignment-item-personal
                    v-else
                    :api="api_personal"
                    :assignment="assignment"
            ></assignment-item-personal>
        </div>
    </div>
    <div v-else>
        <div class="row">
            <div class="col text-center">
                <p>现在没有作业。</p>
            </div>
        </div>
    </div>
</template>

<script>
    import AssignmentItemPersonal from "./AssignmentItemPersonal";
    import AssignmentItemPublic from "./AssignmentItemPublic";
    export default {
        name: "AssignmentListMain",
        components: {AssignmentItemPublic, AssignmentItemPersonal},
        props: [],
        data: function () {
            return {
                initializing: true,
                api_public: "/api/assignment",
                api_personal: "/api/personalAssignment",
                assignments: [],
            }
        },
        created: function () {
            this.loadAssignments();
        },
        methods: {
            sortByDDL(a, b) {
                return window.Dayjs(a.due_time).isBefore(window.Dayjs(b.due_time)) ? -1 : 1;
            },
            loadAssignments() {
                window.axios.get(this.api_public, {
                    params: {
                        due_after: window.Dayjs().format('YYYY-MM-DD HH:mm:ss'),
                    }
                })
                    .then(res => {
                        this.assignments = this.assignments.concat(res.data);
                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                        window.axios.get(this.api_personal, {
                            params: {
                                due_after: window.Dayjs().format('YYYY-MM-DD HH:mm:ss'),
                            }
                        })
                            .then(res => {
                                this.assignments = this.assignments.concat(res.data);
                                this.assignments.sort(this.sortByDDL);
                                console.debug(this.assignments);
                            })
                            .catch(err => {
                                console.log(err);
                            })
                            .finally(() => {
                                this.initializing = false;
                            });
                    });
            }
        }
    }
</script>

<style scoped>

</style>
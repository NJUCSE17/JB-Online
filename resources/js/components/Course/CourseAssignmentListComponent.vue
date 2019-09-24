<template>
    <div class="modal fade" v-bind:id="id"
         tabindex="-1" role="dialog" v-bind:aria-labelledby="id + 'Title'" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-bind:id="id + 'Title'">
                        {{ course.name }}的作业
                        <span class="d-inline-block" v-if="!initializing && course.is_course_admin">
                            <assignment-creator-main
                                :courses="[course]"
                                :api_public="api"
                                :auto_select="0"
                                :timezone="timezone"
                                v-on:addAssignment="addAssignment"
                            ></assignment-creator-main>
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-bind:id="id + 'AssignmentListMain'">
                        <div v-if="initializing">
                            <div class="row">
                                <div class="col text-center mb-3">
                                    <div class="spinner spinner-border" role="status"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <p>{{ init_status }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="assignments.length > 0" v-bind:id="id + 'AssignmentListContent'">
                            <div v-for="assignment in assignments_sorted">
                                <assignment-item-public
                                    v-if="assignment.course_id"
                                    :api="api"
                                    :assignment="assignment"
                                    :timezone="timezone"
                                    v-on:updateAssignment="updateAssignment"
                                    v-on:deleteAssignment="deleteAssignment"
                                ></assignment-item-public>
                            </div>
                        </div>
                        <div v-else>
                            <div class="row">
                                <div class="col text-center mb-3">
                                    <i class="fas fa-box-open" style="font-size:150%;"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <p>现在没有作业</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AssignmentCreatorMain from "../Assignment/AssignmentCreatorMain";
    export default {
        name: "CourseAssignmentListComponent",
        components: {AssignmentCreatorMain},
        props: ['id', 'course', 'timezone'],
        data: function () {
            return {
                initializing: true,
                init_status: "",
                api: "/api/assignment",
                assignments: [],
            }
        },
        computed: {
            assignments_sorted: function () {
                return this.assignments.sort(this.compareByDDL)
            }
        },
        methods: {
            compareByDDL(a, b) {
                return window.Dayjs(a.due_time).isBefore(window.Dayjs(b.due_time)) ? -1 : 1;
            },
            loadAssignments() {
                this.init_status = '正在加载课程作业...';
                window.axios.get(this.api, {
                    params: {
                        course_id: this.course.id,
                    }
                }).then(res => {
                    this.assignments = res.data;
                }).catch(err => {
                    console.error(err);
                }).finally(() => {
                    console.log("Assignments of course " + this.course.id + " loaded.");
                    this.initializing = false;
                    this.init_status = null;
                });
            },
            addAssignment(assignment) {
                this.assignments = this.assignments.concat([assignment]);
                console.log("Assignment added to list.");
                this.$forceUpdate();
            },
            updateAssignment(data) {
                let pos = this.assignments.indexOf(data.oldAssignment);
                this.assignments[pos] = data.newAssignment;
                this.$forceUpdate();
            },
            deleteAssignment(assignment) {
                let pos = this.assignments.indexOf(assignment);
                this.assignments.splice(pos, 1);
                this.$forceUpdate();
            }
        }
    }
</script>

<style scoped>

</style>

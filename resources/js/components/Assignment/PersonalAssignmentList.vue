<template>
    <div id="personalAssignmentMain">
        <div id="personalAssignmentControl">
            <p class="h3">
                个人作业
                <span class="float-right" v-if="!initializing">
                    <assignment-creator-main
                            :courses="[]"
                            :api_public="api_public"
                            :api_personal="api_personal"
                            v-on:addAssignment="addAssignment"
                    ></assignment-creator-main>
                </span>
            </p>
        </div>
        <hr/>
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
        <div v-else-if="assignments.length > 0" id="personalAssignmentContent">
            <div v-for="assignment in assignments">
                <assignment-item-personal
                        :api="api_personal"
                        :assignment="assignment"
                        v-on:updateAssignment="updateAssignment"
                        v-on:deleteAssignment="deleteAssignment"
                ></assignment-item-personal>
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
                    <p>没有个人作业</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AssignmentItemPersonal from "./AssignmentItemPersonal";
    import AssignmentCreatorMain from "./AssignmentCreatorMain";

    export default {
        name: "PersonalAssignmentList",
        components: {AssignmentCreatorMain, AssignmentItemPersonal},
        props: [],
        data: function () {
            return {
                initializing: true,
                init_status: "",
                api_public: "/api/assignment",
                api_personal: "/api/personalAssignment",
                assignments: [],
            }
        },
        created: function () {
            this.loadCoursesAndAssignments();
        },
        methods: {
            loadCoursesAndAssignments() {
                this.init_status = '正在加载个人作业...';
                window.axios.get(this.api_personal, {
                    due_after: '2000-01-01 00:00:00'
                }).then(res => {
                    this.assignments = this.assignments.concat(res.data);
                    console.debug(this.assignments);
                }).catch(err => {
                    console.error(err);
                }).finally(() => {
                    console.log("Personal assignments loaded.");
                    this.initializing = false;
                    this.init_status = null;
                });
            },
            addAssignment(assignment) {
                let ddl = window.Dayjs(assignment.due_time);
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
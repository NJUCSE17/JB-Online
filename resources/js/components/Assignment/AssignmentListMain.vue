<template>
    <div id="assignmentListMain">
        <div id="assignmentListControl">
            <p class="h3">
                当前作业
                <span class="float-right" v-if="!initializing">
                    <assignment-creator-main
                            :courses="courses"
                            :api_public="api_public"
                            :api_personal="api_personal"
                            :timezone="timezone"
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
        <div v-else-if="assignments.length > 0" id="assignmentListContent">
            <div v-for="assignment in assignments_sorted" v-bind:key="assignment.uid">
                <assignment-item-public
                        v-if="assignment.course_id"
                        :api="api_public"
                        :assignment="assignment"
                        :timezone="timezone"
                        v-on:updateAssignment="updateAssignment"
                        v-on:deleteAssignment="deleteAssignment"
                ></assignment-item-public>
                <assignment-item-personal
                        v-else
                        :api="api_personal"
                        :assignment="assignment"
                        :timezone="timezone"
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
                    <p>现在没有作业</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AssignmentItemPersonal from "./AssignmentItemPersonal";
    import AssignmentItemPublic from "./AssignmentItemPublic";
    import AssignmentCreatorMain from "./AssignmentCreatorMain";

    export default {
        name: "AssignmentListMain",
        components: {AssignmentCreatorMain, AssignmentItemPublic, AssignmentItemPersonal},
        props: ["timezone"],
        data: function () {
            return {
                initializing: true,
                init_status: "",
                api_course: '/api/course',
                api_public: "/api/assignment",
                api_personal: "/api/personalAssignment",
                courses: [],
                assignments: [],
            }
        },
        computed: {
            assignments_sorted: function () {
                for (let i = 0; i < this.assignments.length; ++i) {
                    if (this.assignments[i].hasOwnProperty("uid")) continue;
                    if (this.assignments[i].hasOwnProperty("course_id")) {
                        this.assignments[i].uid = "public-" + this.assignments[i].id;
                    } else {
                        this.assignments[i].uid = "private-" + this.assignments[i].id;
                    }
                }
                return this.assignments.sort(this.sortByDDL);
            }
        },
        created: function () {
            this.loadCoursesAndAssignments();
        },
        methods: {
            sortByDDL(a, b) {
                return window.Dayjs(a.due_time).isBefore(window.Dayjs(b.due_time)) ? -1 : 1;
            },
            loadCoursesAndAssignments() {
                this.init_status = '正在加载课程列表...';
                window.axios.get(this.api_course, {
                    params: {
                        'start_before': window.Dayjs().format('YYYY-MM-DD HH:mm:ss'),
                        'end_after': window.Dayjs().format('YYYY-MM-DD HH:mm:ss'),
                    }
                }).then(res => {
                    console.debug(res);
                    this.courses = res.data;
                }).catch(err => {
                    console.error(err);
                }).finally(() => {
                    this.init_status = '正在加载课程作业...';
                    window.axios.get(this.api_public, {
                        params: {
                            due_after: window.Dayjs().format('YYYY-MM-DD HH:mm:ss'),
                        }
                    }).then(res => {
                        this.assignments = this.assignments.concat(res.data);
                    }).catch(err => {
                        console.error(err);
                    }).finally(() => {
                        this.init_status = '正在加载个人作业...';
                        window.axios.get(this.api_personal, {
                            params: {
                                due_after: window.Dayjs().format('YYYY-MM-DD HH:mm:ss'),
                            }
                        }).then(res => {
                            this.assignments = this.assignments.concat(res.data);
                            console.debug(this.assignments);
                        }).catch(err => {
                            console.error(err);
                        }).finally(() => {
                            console.log("Courses and assignments loaded.");
                            this.initializing = false;
                            this.init_status = null;
                        });
                    });
                });
            },
            addAssignment(assignment) {
                window.Vue.set(this.assignments, this.assignments.length, assignment);
                console.log("Assignment added to list.");
            },
            updateAssignment(assignment) {
                for (let pos = 0; pos < this.assignments.length; ++pos) {
                    if (this.assignments[pos].id === assignment.id) {
                        window.Vue.set(this.assignments, pos, assignment);
                        break;
                    }
                }
            },
            deleteAssignment(assignment) {
                let pos = this.assignments.indexOf(assignment);
                window.Vue.delete(this.assignments, pos);
            }
        }
    }
</script>

<style scoped>

</style>

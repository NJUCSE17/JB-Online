<template>
    <div id="AssignmentCreatorMain">
        <div v-if="initializing" class="spinner-grow mr-2" role="status"></div>
        <button v-else class="btn btn-sm btn-soft-primary fadeIn animated" type="button"
            v-on:click="openInitModal">
            <i class="fas fa-plus"></i>
        </button>

        <div class="modal fade" id="createAssignmentModal"
             tabindex="-1" role="dialog" aria-labelledby="createAssignmentModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAssignmentModalTitle">
                            请选择作业类型
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <button class="btn btn-soft-success w-100" type="button"
                                v-on:click="proceedToPersonal">
                            <i class="fas fa-user mr-2"></i>个人作业
                        </button>
                        <div v-if="hasCourseToSelect">
                            <hr />
                            <select class="custom-select form-control mb-3" v-model="courseSelected">
                                <option disabled value="">请选择课程</option>
                                <option v-for="(course, index) in courses"
                                        v-if="course.is_course_admin" :value="index">
                                    {{ course.name }}
                                </option>
                            </select>
                            <button class="btn btn-soft-info w-100" type="button"
                                    v-on:click="proceedToPublic"
                                    :disabled="!courseSelected">
                                <i class="fas fa-book mr-2"></i>课程作业
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <assignment-creator-personal
                :api="this.api_personal"
        ></assignment-creator-personal>

        <assignment-creator-public
                :api="this.api_public"
                :course="this.courses[this.courseSelected]"
        ></assignment-creator-public>
    </div>
</template>

<script>
    import AssignmentCreatorPersonal from "./AssignmentCreatorPersonal";
    import AssignmentCreatorPublic from "./AssignmentCreatorPublic";
    export default {
        name: "CreateAssignmentComponent",
        components: {AssignmentCreatorPublic, AssignmentCreatorPersonal},
        created: function() {
            this.loadCourses();
        },
        data: function () {
            return {
                initializing: true,
                init_failed: false,
                api_course: '/api/course',
                api_personal: '/api/personalAssignment',
                api_public: '/api/assignment',
                courses: {},
                courseSelected: '',
            }
        },
        computed: {
            hasCourseToSelect: function () {
                for (let i = 0; i < this.courses.length; ++i) {
                    if (this.courses[i].is_course_admin) return true;
                }
                return false;
            }
        },
        methods: {
            loadCourses() {
                window.axios.get(this.api_course)
                    .then(res => {
                        console.debug(res);
                        this.courses = res.data;
                        console.log("Course data loaded. "
                            + (this.hasCourseToSelect ? "Has" : "No")
                            + " public course available.");
                        this.initializing = false;
                    })
                    .catch(err => {
                        console.log(err);
                        console.log("Loading course data failed.");
                        this.initializing = false;
                    });
            },
            openInitModal() {
                if (this.hasCourseToSelect) {
                    window.$('#createAssignmentModal').modal('show');
                } else {
                    this.proceedToPersonal();
                }
            },
            proceedToPersonal() {
                window.$('#createAssignmentModal').modal('hide');
                window.$('#personalAssignmentModal').modal('show');
            },
            proceedToPublic() {
                window.$('#createAssignmentModal').modal('hide');
                window.$('#publicAssignmentModal').modal('show');
            },
        }
    }
</script>

<style scoped>

</style>
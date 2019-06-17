<template>
    <div id="AssignmentCreatorMain">
        <button class="btn btn-sm btn-soft-primary px-3" type="button"
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
                                    :disabled="courseSelected === ''">
                                <i class="fas fa-book mr-2"></i>课程作业
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <assignment-creator-personal
                :api="this.api_personal"
                v-on:addAssignment="addAssignment"
        ></assignment-creator-personal>

        <assignment-creator-public
                v-if="hasCourseToSelect"
                :api="this.api_public"
                :course="this.courses[this.courseSelected]"
                v-on:addAssignment="addAssignment"
        ></assignment-creator-public>
    </div>
</template>

<script>
    import AssignmentCreatorPersonal from "./AssignmentCreatorPersonal";
    import AssignmentCreatorPublic from "./AssignmentCreatorPublic";
    export default {
        name: "AssignmentCreatorMain",
        components: {AssignmentCreatorPublic, AssignmentCreatorPersonal},
        props: ['courses', 'api_public', 'api_personal'],
        data: function () {
            return {
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
            addAssignment(assignment) {
                this.$emit("addAssignment", assignment);
            }
        }
    }
</script>

<style scoped>

</style>
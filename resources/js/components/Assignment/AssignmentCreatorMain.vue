<template>
    <div id="AssignmentCreatorMain">
        <button class="btn btn-sm btn-soft-primary px-3" type="button" v-on:click="openInitModal">
            <i class="fas fa-plus"></i>
        </button>

        <div class="modal fade" v-bind:id="thisID"
             tabindex="-1" role="dialog" v-bind:aria-labelledby="thisID + 'Title'" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-bind:id="thisID + 'Title'">
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
                            <hr/>
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

        <assignment-creator
                v-if="!isAutoSelected"
                :id="personalID"
                :type="'personal'"
                :api="this.api_personal"
                :course="null"
                :timezone="timezone"
                v-on:addAssignment="addAssignment"
        ></assignment-creator>

        <assignment-creator
                v-if="hasCourseToSelect"
                :id="publicID"
                :type="'public'"
                :api="this.api_public"
                :course="this.courses[this.courseSelected]"
                :timezone="timezone"
                v-on:addAssignment="addAssignment"
        ></assignment-creator>
    </div>
</template>

<script>
    import AssignmentCreator from "./AssignmentCreator";

    export default {
        name: "AssignmentCreatorMain",
        components: {AssignmentCreator},
        props: ['courses', 'api_public', 'api_personal', 'auto_select', 'timezone'],
        data: function () {
            return {
                thisID: 'AssignmentCreatorMainModal',
                publicID: 'AssignmentCreatorPublicModal',
                personalID: 'AssignmentCreatorPersonalModel',
                courseSelected: '',
            }
        },
        computed: {
            hasCourseToSelect() {
                for (let i = 0; i < this.courses.length; ++i) {
                    if (this.courses[i].is_course_admin) return true;
                }
                return false;
            },
            isAutoSelected() {
                if (this.api_personal) return false;
                if (!this.hasCourseToSelect) return false;
                if (this.auto_select === null) return false;
                return this.auto_select < this.courses.length;
            },
        },
        methods: {
            openInitModal() {
                if (this.isAutoSelected) {
                    this.courseSelected = this.auto_select;
                    this.proceedToPublic();
                } else if (this.hasCourseToSelect) {
                    window.$('#' + this.thisID).modal('show');
                } else {
                    this.proceedToPersonal();
                }
            },
            proceedToPersonal() {
                window.$('#' + this.thisID).modal('hide');
                window.$('#' + this.personalID).modal('show');
            },
            proceedToPublic() {
                window.$('#' + this.thisID).modal('hide');
                window.$('#' + this.publicID).modal('show');
            },
            addAssignment(assignment) {
                this.$emit("addAssignment", assignment);
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <div class="mb-3">
        <div class="list-group-item">
            <div class="d-flex align-items-center justify-content-between">
                <div class="mr-3 text-left">
                    <button v-if="!course.is_in_course"
                            v-on:click="enrollCourse"
                            type="button" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-star mr-2"></i> 加入
                    </button>
                    <button v-else
                            v-on:click="quitCourse"
                            type="button" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-door-open mr-2"></i> 退出
                    </button>
                </div>

                <div class="flex-fill text-limit">
                    <h6 class="progress-text mb-1 text-sm d-block text-limit">
                        第{{ course.semester }}学期 - {{ course.name }}
                    </h6>
                    <div class="progress progress-xs mb-0">
                        <div class="progress-bar" role="progressbar"
                             aria-valuemin="0" aria-valuemax="100"
                             v-bind:class="'bg-' + status.color"
                             v-bind:style="'width:' + status.value + '%'"
                             v-bind:aria-valuenow="status.value">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between text-xs text-muted text-right mt-1">
                        <div>
                        <span class="font-weight-bold"
                              v-bind:class="'text-' + status.color">
                            {{ status.text }} ({{ status.value }}%)
                        </span>
                        </div>
                        <div>
                            {{ beg_date }} 至 {{ end_date }}
                        </div>
                    </div>
                </div>
                <div class="ml-3 text-right">
                    <button type="button" class="btn btn-sm"
                            v-bind:class="show_assignments ? 'btn-primary' : 'btn-outline-primary'"
                            v-on:click="triggerAssignmentListComponent">
                        <i class="fas fa-pencil mr-2"></i> 作业
                    </button>

                    <button v-if="this.course.is_course_admin"
                            type="button" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-edit mr-2"></i> 编辑
                    </button>
                </div>
            </div>
        </div>

        <div v-if="course.notice_html && !show_assignments"
             class="list-group-item pb-0"
             v-html="course.notice_html"></div>

        <course-assignment-list-component
                v-if="show_assignments"
                :id="listID"
                :course="course"
                v-on:close="() => {show_assignments = false}"
        ></course-assignment-list-component>
    </div>
</template>

<script>
    import CourseAssignmentListComponent from "./CourseAssignmentListComponent";

    export default {
        name: "CourseItemComponent",
        components: {CourseAssignmentListComponent},
        props: ['id', 'api', 'course'],
        data: function () {
            return {
                show_assignments: false,
                listID: 'CourseAssignmentListComponent' + this.course.id,
                editorID: 'CourseEditorComponent' + this.course.id,
            }
        },
        computed: {
            beg_date() {
                return window.Dayjs(this.course.start_time).format("YYYY-MM-DD");
            },
            end_date() {
                return window.Dayjs(this.course.end_time).format("YYYY-MM-DD");
            },
            status() {
                let now = window.Dayjs();
                let beg = window.Dayjs(this.course.start_time);
                let end = window.Dayjs(this.course.end_time);
                if (now.isBefore(beg)) {
                    return {
                        text: '未开始',
                        color: 'info',
                        value: 100,
                    };
                } else if (now.isAfter(end)) {
                    return {
                        text: '已结束',
                        color: 'danger',
                        value: 100,
                    };
                } else {
                    return {
                        text: '进行中',
                        color: 'warning',
                        value: Math.ceil((now.diff(beg, 'day')) / (end.diff(beg, 'day')) * 100),
                    };
                }
            },
        },
        methods: {
            triggerAssignmentListComponent() {
                this.show_assignments = !this.show_assignments;
            },
            enrollCourse() {
                this.submit(true);
            },
            quitCourse() {
                this.submit(false);
            },
            submit(is_enroll) {
                window.axios.post(this.api + (is_enroll ? '/enroll' : '/quit'), {
                    // no data
                }).then(res => {
                    console.debug(res);
                    window.$.alert({
                        type: 'green',
                        icon: 'fas fa-check',
                        title: '成功',
                        content: '成功' + (is_enroll ? '加入' : '退出')
                            + '课程' + this.course.name + '。',
                    });
                    let course_upd = this.course;
                    course_upd.is_in_course = is_enroll;
                    this.$emit('updateCourse', {
                        oldCourse: this.course,
                        newCourse: course_upd,
                    });
                }).catch(res => {
                    console.err(res);
                    window.$.alert({
                        type: 'red',
                        icon: 'fas fa-times',
                        title: '错误',
                        content: err,
                    });
                });
            }
        },
    }
</script>

<style scoped>

</style>
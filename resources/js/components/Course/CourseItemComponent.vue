<template>
    <div class="col-lg-4 col-md-6">
        <div class="card" v-bind:id="id + 'Card'">
            <div class="card-body">
                <div>
                    <small class="d-inline-block text-sm mb-2">{{ beg_date }} 至 {{ end_date }}</small>
                    <span class="d-inline-block float-right" v-if="status.color === 'warning' && (self_is_admin || !course.is_course_admin)">
                        <a v-if="!course.is_in_course"
                           v-on:click="enrollCourse"
                           v-bind:href="'#' + id + 'Card'" class="text-success"
                           data-toggle="tooltip" data-placement="top" title="加入课程">
                            <i class="fas fa-star"></i>
                        </a>
                        <a v-else v-on:click="quitCourse"
                           v-bind:href="'#' + id + 'Card'" class="text-danger"
                           data-toggle="tooltip" data-placement="top" title="退出课程">
                            <i class="fas fa-door-open"></i>
                        </a>
                    </span>
                </div>
                <div class="progress progress-xs mb-4">
                    <div class="progress-bar" role="progressbar"
                         aria-valuemin="0" aria-valuemax="100"
                         v-bind:class="'bg-' + status.color"
                         v-bind:style="'width:' + status.value + '%'"
                         v-bind:aria-valuenow="status.value">
                    </div>
                </div>
                <h5>{{ course.name }}</h5>
                <div v-html="course.notice_html"></div>
            </div>
            <div class="card-footer mx-3">
                <div class="row">
                    <div class="w-100 btn-group btn-group-sm">
                        <button type="button" class="btn btn-sm btn-outline-primary"
                                v-on:click="showAssignments">
                            <i class="fas fa-folder mr-2"></i> 作业
                        </button>
                        <button v-if="course.is_course_admin"
                                type="button" class="btn btn-sm btn-outline-info"
                                v-on:click="editCourse">
                            <i class="fas fa-edit mr-2"></i> 编辑
                        </button>
                        <button v-if="course.is_course_admin && status.color === 'warning'"
                                type="button" class="btn btn-sm btn-outline-warning"
                                v-on:click="showEnrollRecords">
                            <i class="fas fa-users-cog mr-2"></i> 管理
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <course-assignment-list-component
            ref="list"
            :id="listID"
            :course="course"
            :timezone="timezone"
        ></course-assignment-list-component>

        <course-editor-component
            :id="editorID"
            :api="api_course"
            :course="course"
            :timezone="timezone"
            v-on:updateCourse="updateCourse"
            v-on:deleteCourse="deleteCourse"
        ></course-editor-component>

        <course-enroll-records-component
            v-if="status.color === 'warning'"
            ref="records"
            :id="recordsID"
            :self_is_admin="self_is_admin"
            :api_user="api_user"
            :api_course="api_course"
            :course="course"
        ></course-enroll-records-component>
    </div>
</template>

<script>
    import CourseAssignmentListComponent from "./CourseAssignmentListComponent";
    import CourseEditorComponent from "./CourseEditorComponent";
    import CourseEnrollRecordsComponent from "./CourseEnrollRecordsComponent";

    export default {
        name: "CourseItemComponent",
        components: {CourseEnrollRecordsComponent, CourseEditorComponent, CourseAssignmentListComponent},
        props: ['id', 'self_is_admin', 'api_user', 'api_course', 'course', 'timezone'],
        data: function () {
            return {
                assignments_loaded: false,
                enroll_records_loaded: false,
                listID: 'CourseAssignmentListComponent' + this.course.id,
                editorID: 'CourseEditorComponent' + this.course.id,
                recordsID: 'CourseEnrollRecordsComponent' + this.course.id,
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
            editCourse() {
                window.$('#' + this.editorID).modal('show');
            },
            showAssignments() {
                window.$('#' + this.listID).modal('show');
                if (!this.assignments_loaded) {
                    this.$refs.list.loadAssignments();
                    this.assignments_loaded = true;
                }
            },
            showEnrollRecords() {
                window.$('#' + this.recordsID).modal('show');
                if (!this.enroll_records_loaded) {
                    this.$refs.records.loadUserAndRecords();
                    this.enroll_records_loaded = true;
                }
            },
            enrollCourse() {
                this.submit(true);
            },
            quitCourse() {
                this.submit(false);
            },
            submit(is_enroll) {
                window.axios.post(this.api_course + (is_enroll ? '/enroll' : '/quit'), {
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
                    let course_upd = Object.assign({}, this.course);
                    course_upd.is_in_course = is_enroll;
                    this.$emit('updateCourse', course_upd);
                }).catch(res => {
                    console.err(res);
                    window.$.alert({
                        type: 'red',
                        icon: 'fas fa-times',
                        title: '错误',
                        content: err,
                    });
                });
            },
            updateCourse(course) {
                this.$emit('updateCourse', course);
            },
            deleteCourse() {
                this.$emit('deleteCourse', this.course);
            }
        },
    }
</script>

<style scoped>

</style>

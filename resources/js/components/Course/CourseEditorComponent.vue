<template>
    <div class="modal fade" v-bind:id="id"
         tabindex="-1" role="dialog" v-bind:aria-labelledby="id + 'Title'" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-bind:id="id + 'Title'">
                        <span>修改课程{{ course.name }}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-bind:id="id + 'DeleteButton'">
                        <button v-if="!isNameCorrect" class="btn btn-danger w-100 disabled" disabled>
                            <i class="fas fa-lock mr-2"></i> 输入课程名称来删除
                        </button>
                        <button v-else-if="!submitting" class="btn btn-danger w-100" v-on:click="destroy">
                            <i class="fas fa-trash mr-2"></i> 删除这个课程
                        </button>
                        <button class="btn btn-danger disabled w-100" v-else disabled>
                            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                            处理中
                        </button>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="form-control-label">课程名称</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-edit"></i></span>
                            </div>
                            <input class="form-control"
                                   v-on:keyup.enter="submit"
                                   v-bind:name="id + 'NameInput'"
                                   v-model="courseName"
                                   v-bind:placeholder="course.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">课程学期</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-school"></i></span>
                            </div>
                            <select v-model="courseSemester" class="form-control"
                                    v-bind:name="id + 'SemesterSelect'"
                                    v-bind:disabled="!isNameCorrect">
                                <option disabled value="">请选择学期</option>
                                <option v-for="s in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]"
                                        v-bind:value="s"
                                >第{{s}}学期
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">起始时间 {{ begWeekday }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <masked-input
                                    type="text"
                                    class="form-control"
                                    placeholder="YYYY-MM-DD HH:mm:ss"
                                    v-bind:name="id + 'BegDateInput'"
                                    v-bind:disabled="!isNameCorrect"
                                    v-on:keyup.enter="submit"
                                    v-model="courseBegDate"
                                    v-bind:pipe="datePipe"
                                    v-bind:mask="[
                                            /\d/, /\d/, /\d/, /\d/, '-', /\d/, /\d/, '-', /\d/, /\d/,
                                            ' ', /\d/, /\d/, ':', /\d/, /\d/, ':', /\d/, /\d/
                                        ]"
                                    v-bind:guide="true" placeholderChar="_">
                            </masked-input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">结束时间 {{ endWeekday }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <masked-input
                                    type="text"
                                    class="form-control"
                                    placeholder="YYYY-MM-DD HH:mm:ss"
                                    v-bind:name="id + 'EndDateInput'"
                                    v-bind:disabled="!isNameCorrect"
                                    v-on:keyup.enter="submit"
                                    v-model="courseEndDate"
                                    v-bind:pipe="datePipe"
                                    v-bind:mask="[
                                            /\d/, /\d/, /\d/, /\d/, '-', /\d/, /\d/, '-', /\d/, /\d/,
                                            ' ', /\d/, /\d/, ':', /\d/, /\d/, ':', /\d/, /\d/
                                        ]"
                                    v-bind:guide="true" placeholderChar="_">
                            </masked-input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">课程公告 （Markdown）</label>
                        <div class="input-group">
                                <textarea id="CourseNoticeInput"
                                          class="form-control"
                                          v-model="courseNotice"
                                          v-bind:disabled="!isNameCorrect">
                                </textarea>
                        </div>
                    </div>
                    <hr/>
                    <div v-bind:id="id + 'SubmitButton'">
                        <button v-if="!isNameCorrect"
                                class="btn btn-info w-100 disabled" disabled>
                            <i class="fas fa-lock mr-2"></i> 输入课程名称来编辑
                        </button>
                        <button v-else-if="!isReady"
                                class="btn btn-info w-100 disabled" disabled>
                            <i class="fas fa-lock mr-2"></i> {{ notReadyReason }}
                        </button>
                        <button v-else-if="!submitting" class="btn btn-info w-100"
                                v-on:click="submit"
                                v-bind:disabled="!isReady">
                            <i class="fas fa-check mr-2"></i> 修改这个课程
                        </button>
                        <button class="btn btn-info disabled w-100" v-else disabled>
                                <span class="spinner-border spinner-border-sm mr-2" role="status"
                                      aria-hidden="true"></span>
                            处理中
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import createAutoCorrectedDatePipe from 'text-mask-addons/dist/createAutoCorrectedDatePipe';

    export default {
        name: "CourseEditorComponent",
        props: ['id', 'api', 'course'],
        watch: {
            course: function (newVal, oldVal) {
                this.courseName = '';
                this.courseSemester = newVal.semester;
                this.courseNotice = newVal.notice;
                this.courseBegDate = newVal.start_time;
                this.courseEndDate = newVal.end_time;
            }
        },
        data: function () {
            return {
                datePipe: createAutoCorrectedDatePipe('yyyy-mm-dd HH:MM:SS'),
                submitting: false,
                courseName: '',
                courseSemester: this.course.semester,
                courseNotice: this.course.notice,
                courseBegDate: this.course.start_time,
                courseEndDate: this.course.end_time,
            }
        },
        computed: {
            begWeekday() {
                return this.getWeekday(this.courseBegDate);
            },
            endWeekday() {
                return this.getWeekday(this.courseEndDate);
            },
            isNameCorrect() {
                return this.courseName === this.course.name;
            },
            notReadyReason() {
                if (!this.isNameCorrect) return '课程名不正确';
                if (!this.courseSemester) return '请选择课程学期';

                if (!this.courseBegDate || this.courseBegDate.indexOf('_') >= 0) return '请输入起始日期';
                if (!this.courseEndDate || this.courseEndDate.indexOf('_') >= 0) return '请输入结束日期';
                if (window.Dayjs(this.courseBegDate).isAfter(window.Dayjs(this.courseEndDate))) return '起始日期需要在结束日期前';
                return null;
            },
            isReady() {
                return this.notReadyReason === null;
            }
        },
        methods: {
            getWeekday(date) {
                date = date.substring(0, 10);
                if (!date || date.indexOf('_') >= 0) {
                    return '（无效）';
                } else {
                    return '（' + window.Dayjs(date).format('ddd') + '）';
                }
            },
            submit() {
                if (!this.isReady) return;

                this.submitting = true;
                window.axios.put(this.api, {
                    name: this.courseName,
                    semester: this.courseSemester,
                    start_time: this.courseBegDate,
                    end_time: this.courseEndDate,
                    notice: this.courseNotice,
                }).then(res => {
                    console.debug(res);
                    window.$.alert({
                        type: 'green',
                        icon: 'fas fa-check',
                        title: '成功',
                        content: '成功更新课程' + this.courseName + '。',
                    });
                    window.$('#' + this.id).modal('hide');
                    this.$emit('updateCourse', res.data);
                }).catch(err => {
                    console.error(err);
                    window.$.alert({
                        type: 'red',
                        icon: 'fas fa-times',
                        title: '错误',
                        content: err,
                    });
                }).finally(() => {
                    this.submitting = false;
                });
            },
            destroy() {
                window.$.confirm({
                    type: 'red',
                    icon: 'fas fa-exclamation-triangle',
                    title: '注意',
                    content: '你确定要删除课程“' + this.course.name + '”吗？',
                    buttons: {
                        confirm: {
                            text: '确定',
                            btnClass: 'btn-danger',
                            action: () => {
                                this.doDestroy();
                            }
                        },
                        cancel: {
                            text: '取消',
                        },
                    }
                });
            },
            doDestroy() {
                this.submitting = true;
                window.axios.delete(this.api, {
                    // no data
                }).then(res => {
                    console.debug(res);
                    window.$.alert({
                        type: 'green',
                        icon: 'fas fa-check',
                        title: '成功',
                        content: '成功删除课程' + this.course.name + '。',
                    });
                    window.$('#' + this.id).modal('hide');
                    this.$emit('deleteCourse', this.course);
                }).catch(err => {
                    console.error(err);
                    window.$.alert({
                        type: 'red',
                        icon: 'fas fa-times',
                        title: '错误',
                        content: err,
                    });
                }).finally(() => {
                    this.submitting = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
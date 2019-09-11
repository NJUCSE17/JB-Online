<template>
    <div class="modal fade" v-bind:id="id"
         tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span v-if="assignment.course_name">
                            修改{{ assignment.course_name }}的作业 - {{ assignment.name }}
                        </span>
                        <span v-else>修改个人作业 - {{ assignment.name }}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-bind:id="id + 'DeleteButton'">
                        <button v-if="!submitting" class="btn btn-danger w-100" v-on:click="destroy">
                            <i class="fas fa-trash mr-2"></i> 删除这个作业
                        </button>
                        <button v-else class="btn btn-danger disabled w-100" disabled>
                            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                            处理中
                        </button>
                    </div>
                    <hr/>
                    <div v-if="hasError" class="alert alert-outline-success" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        提示：可能遇到的错误和解决方法：
                        <ul class="mb-0">
                            <li>419-XSRF令牌过期，请刷新页面；</li>
                            <li>422-服务器检验后发现存在违法数据。</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">作业名称</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-edit"></i></span>
                            </div>
                            <input class="form-control"
                                   v-on:keyup.enter="submit"
                                   v-model="assignmentName"
                                   v-bind:id="id + 'InputName'"
                                   v-bind:placeholder="assignment.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">作业内容 （Markdown）</label>
                        <div class="input-group">
                            <textarea class="form-control"
                                      v-bind:id="id + 'InputContent'"
                                      v-model="assignmentContent">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">截止时间 {{ weekday }} [{{ timezone }}]</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <flat-pickr class="form-control"
                                        v-model="assignmentDDL"
                                        v-bind:id="id + 'InputDDL'">
                            </flat-pickr>
                        </div>
                    </div>
                    <hr/>
                    <div v-bind:id="id + 'SubmitButton'">
                        <button v-if="!isReady"
                                class="btn btn-success w-100 disabled" disabled>
                            <i class="fas fa-lock mr-2"></i> 填写以上信息来修改作业
                        </button>
                        <button v-else-if="!submitting"
                                class="btn btn-success w-100"
                                v-on:click="submit"
                                v-bind:disabled="!isReady"
                                v-bind:class="assignment.course_id ? 'btn-info' : 'btn-success'">
                            <i class="fas fa-edit mr-2"></i> 更新这个作业
                        </button>
                        <button v-else class="btn disabled w-100" disabled
                                v-bind:class="assignment.course_id ? 'btn-info' : 'btn-success'">
                            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                            处理中
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AssignmentEditor",
        props: ['id', 'api', 'assignment', 'timezone'],
        watch: {
            assignment: function (newVal, oldVal) {
                this.assignmentName = newVal.name;
                this.assignmentContent = newVal.content;
                this.assignmentDDL= newVal.due_time;
            }
        },
        data: function () {
            return {
                assignmentName: this.assignment.name,
                assignmentContent: this.assignment.content,
                assignmentDDL: this.assignment.due_time,
                submitting: false,
                hasError: false,
            }
        },
        computed: {
            weekday() {
                let date = this.assignmentDDL.substring(0, 10);
                if (!date || date.indexOf('_') >= 0) {
                    return '（无效）';
                } else {
                    return '（' + window.Dayjs(date).format('ddd') + '）';
                }
            },
            isReady() {
                if (!this.assignmentName) return false;
                if (!this.assignmentContent) return false;
                if (!this.assignmentDDL) return false;
                return !(this.assignmentDDL.indexOf('_') >= 0);
            }
        },
        methods: {
            submit() {
                if (!this.isReady) return;

                this.submitting = true;
                window.axios.put(this.api, {
                    name: this.assignmentName,
                    content: this.assignmentContent,
                    due_time: this.assignmentDDL,
                }).then(res => {
                    console.debug(res);
                    console.log("Assignment updated.");
                    window.$.alert({
                        type: 'green',
                        icon: 'fas fa-check',
                        title: '成功',
                        content: '成功更新作业' + this.assignmentName + '。',
                    });
                    window.$('#' + this.id).modal('hide');
                    this.$emit('updateAssignment', res.data);
                }).catch(err => {
                    console.error(err);
                    this.hasError = true;
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
                    content: '你确定要删除作业“' + this.assignment.name + '”吗？',
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
                        content: '成功删除作业' + this.assignment.name + '。',
                    });
                    window.$('#' + this.id).modal('hide');
                    this.$emit('deleteAssignment', this.assignment);
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

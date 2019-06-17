<template>
    <div class="modal fade" v-bind:id="id"
         tabindex="-1" role="dialog" v-bind:aria-labelledby="id + 'Title'" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-bind:id="id + 'Title'">创建个人作业</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
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
                            <input id="assignmentName"
                                   v-on:keyup.enter="submit"
                                   v-model="assignmentName"
                                   class="form-control" placeholder="作业名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">作业内容 （Markdown）</label>
                        <div class="input-group">
                                <textarea id="assignmentContent"
                                          v-model="assignmentContent"
                                          class="form-control">
                                </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">截止时间 {{ weekday }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <masked-input
                                    type="text" name="AssignmentDDLInput"
                                    class="form-control"
                                    placeholder="YYYY-MM-DD HH:mm:ss"
                                    v-on:keyup.enter="submit"
                                    v-model="assignmentDDL"
                                    :pipe="datePipe"
                                    :mask="[
                                        /\d/, /\d/, /\d/, /\d/, '-', /\d/, /\d/, '-', /\d/, /\d/,
                                        ' ', /\d/, /\d/, ':', /\d/, /\d/, ':', /\d/, /\d/
                                    ]"
                                    :guide="true" placeholderChar="_">
                            </masked-input>
                        </div>
                    </div>
                    <hr />
                    <div id="AssignmentCreatorSubmitButton">
                        <button v-if="!isReady"
                                class="btn w-100 disabled" disabled
                                v-bind:class="type === 'public' ? 'btn-info' : 'btn-success'">
                            <i class="fas fa-lock mr-2"></i> 填写以上信息来新建作业
                        </button>
                        <button v-else-if="!submitting" class="btn w-100" v-on:click="submit" :disabled="!isReady"
                                v-bind:class="type === 'public' ? 'btn-info' : 'btn-success'">
                            <i class="fas fa-check mr-2"></i> 新建作业
                        </button>
                        <button class="btn disabled w-100" v-else disabled
                                v-bind:class="type === 'public' ? 'btn-info' : 'btn-success'">
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
    import createAutoCorrectedDatePipe from 'text-mask-addons/dist/createAutoCorrectedDatePipe';
    export default {
        name: "AssignmentCreator",
        props: ['id', 'type', 'api', 'course'],
        data: function () {
            return {
                datePipe: createAutoCorrectedDatePipe('yyyy-mm-dd HH:MM:SS'),
                assignmentName: '',
                assignmentContent: '',
                assignmentDDL: '',
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
                window.axios.post(this.api, {
                    course_id: this.course ? this.course.id : '',
                    name: this.assignmentName,
                    content: this.assignmentContent,
                    due_time: this.assignmentDDL,
                }).then(res => {
                    console.debug(res);
                    console.log("Assignment created, ID is " + this.type + '-' + res.data.id + '.');
                    this.$emit('addAssignment', res.data);
                    window.$('#' + this.id).modal('hide');
                }).catch(err => {
                    console.error(err);
                    this.hasError = true;
                    window.$.alert({
                        type: 'red',
                        title: '错误',
                        content: err,
                    });
                }).finally(() => {
                    this.submitting = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
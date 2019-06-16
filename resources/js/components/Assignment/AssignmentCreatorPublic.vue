<template>
    <div v-if="!course"></div>
    <div v-else class="modal fade" id="publicAssignmentModal"
         tabindex="-1" role="dialog" aria-labelledby="publicAssignmentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="publicAssignmentModalTitle">创建{{ course.name }}的作业</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-outline-info" role="alert">
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
                            <input id="publicAssignmentName"
                                   v-model="publicAssignmentName"
                                   class="form-control" placeholder="作业名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">作业内容</label>
                        <div class="input-group">
                                <textarea id="publicAssignmentContent"
                                          v-model="publicAssignmentContent"
                                          class="form-control">
                                </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">截止时间</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <input id="publicAssignmentDDL" class="form-control"
                                   v-model="publicAssignmentDDL"
                                   type="tel" v-mask="'####-##-## ##:##:##'"
                                   placeholder="2017-09-01 14:00:00">
                        </div>
                    </div>
                    <hr />
                    <button v-if="!submitting" class="btn btn-info w-100" v-on:click="submit"
                            v-bind:class="{ disabled : !isReady }" :disabled="!isReady">
                        <i class="fas fa-check mr-2"></i> 提交
                    </button>
                    <button class="btn btn-info disabled w-100" v-else disabled>
                        <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                        处理中
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AssignmentCreatorPublic",
        props: ['api', 'course'],
        data: function () {
            return {
                publicAssignmentName: '',
                publicAssignmentContent: '',
                publicAssignmentDDL: '',
                submitting: false,
            }
        },
        computed: {
            isReady() {
                if (!this.publicAssignmentName) return false;
                if (!this.publicAssignmentContent) return false;
                if (!this.publicAssignmentDDL) return false;
                return !(this.publicAssignmentDDL.indexOf('_') >= 0);
            }
        },
        methods: {
            submit() {
                this.submitting = true;
                window.axios.post(this.api, {
                    course_id: this.course.id,
                    name: this.publicAssignmentName,
                    content: this.publicAssignmentContent,
                    due_time: this.publicAssignmentDDL,
                }).then(res => {
                    console.log(res);
                    location.reload();
                }).catch(err => {
                    console.log(err);
                    window.$.alert({
                        type: 'red',
                        title: '错误',
                        content: err,
                    });
                    this.submitting = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
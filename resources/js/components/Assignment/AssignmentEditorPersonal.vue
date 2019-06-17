<template>
    <div class="modal fade" v-bind:id="id"
         tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">修改个人作业 - {{ assignment.name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-bind:id="id + 'DeleteButton'">
                        <button v-if="!isNameCorrect" class="btn btn-danger w-100 disabled" disabled>
                            <i class="fas fa-lock mr-2"></i> 请输入作业名称来解锁
                        </button>
                        <button v-else-if="!submitting" class="btn btn-danger w-100" v-on:click="destroy">
                            <i class="fas fa-trash mr-2"></i> 删除这个作业
                        </button>
                        <button class="btn btn-danger disabled w-100" v-else disabled>
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
                                   v-model="personalAssignmentName"
                                   v-bind:id="id + 'InputName'"
                                   v-bind:placeholder="assignment.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">作业内容</label>
                        <div class="input-group">
                            <textarea class="form-control"
                                      v-bind:id="id + 'InputContent'"
                                      v-bind:disabled="!isNameCorrect"
                                      v-model="personalAssignmentContent">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">截止时间</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <input class="form-control"
                                   v-bind:id="id + 'InputDDL'"
                                   v-bind:disabled="!isNameCorrect"
                                   v-on:keyup.enter="submit"
                                   v-model="personalAssignmentDDL"
                                   type="tel" v-mask="'####-##-## ##:##:##'"
                                   placeholder="2017-09-01 14:00:00">
                        </div>
                    </div>
                    <hr/>
                    <div v-bind:id="id + 'SubmitButton'">
                        <button v-if="!isNameCorrect" class="btn btn-success w-100 disabled" disabled>
                            <i class="fas fa-lock mr-2"></i> 请输入作业名称来解锁
                        </button>
                        <button v-else-if="!submitting" class="btn btn-success w-100" v-on:click="submit"
                                v-bind:class="{ disabled : !isReady }" :disabled="!isReady">
                            <i class="fas fa-edit mr-2"></i> 更新作业
                        </button>
                        <button class="btn btn-success disabled w-100" v-else disabled>
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
        name: "AssignmentEditorPersonal",
        props: ['id', 'api', 'assignment'],
        data: function () {
            return {
                personalAssignmentName: '',
                personalAssignmentContent: this.assignment.content,
                personalAssignmentDDL: this.assignment.due_time,
                submitting: false,
                hasError: false,
            }
        },
        computed: {
            isNameCorrect() {
                return this.personalAssignmentName === this.assignment.name;
            },
            isReady() {
                if (!this.isNameCorrect) return false;
                if (!this.personalAssignmentContent) return false;
                if (!this.personalAssignmentDDL) return false;
                return this.personalAssignmentDDL.length === 19;
            }
        },
        methods: {
            submit() {
                this.submitting = true;
                window.axios.put(this.api, {
                    name: this.personalAssignmentName,
                    content: this.personalAssignmentContent,
                    due_time: this.personalAssignmentDDL,
                }).then(res => {
                    console.debug(res);
                    console.log("Personal assignment updated.");
                    window.$('#' + this.id).modal('hide');
                    this.$emit('updateAssignment', res.data);
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
            destroy() {
                window.$.confirm({
                    type: 'red',
                    title: '注意',
                    content: '你确定要删除个人作业“' + this.assignment.name + '”吗？',
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
                window.axios.delete(this.api)
                    .then(res => {
                        console.debug(res);
                        window.$('#' + this.id).modal('hide');
                        this.$emit('deleteAssignment', this.assignment);
                    })
                    .catch(err => {
                        console.error(err);
                        window.$.alert({
                            type: 'red',
                            title: '错误',
                            content: err,
                        });
                    })
                    .finally(() => {
                        this.submitting = false;
                    })
            },
        }
    }
</script>

<style scoped>

</style>
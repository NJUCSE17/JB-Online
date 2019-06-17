<template>
    <div class="modal fade" v-bind:id="id" tabindex="-1" role="dialog"
         v-bind:aria-labelledby="id + 'Title'" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-bind:id="id + 'Title'">修改密码</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="self.id !== user.id" class="alert alert-outline-warning">
                        <i class="fas fa-exclamation-circle mr-2"></i> 警告：你正在修改其他用户的信息。
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">原密码</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input id="oldPassword" type="password"
                                   class="form-control"
                                   v-on:keyup.enter="submit"
                                   v-model="oldPassword"
                                   v-bind:disabled="isSuperUser || !isSelf"
                                   v-bind:placeholder="isSuperUser ? '管理员无需提供密码' : ''">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">
                            新密码（至少 8 位，当前长度{{ newPasswordValid ? '有效' : '无效' }}）
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="newPassword" type="password"
                                   class="form-control"
                                   v-on:keyup.enter="submit"
                                   v-model="newPassword">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">
                            重复一遍（{{ newPasswordConfirmed ? '一致' : '不一致' }}）
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-redo"></i></span>
                            </div>
                            <input id="newPasswordRepeat" type="password"
                                   class="form-control"
                                   v-on:keyup.enter="submit"
                                   v-model="newPasswordRepeat">
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col">
                            <button v-if="!isReady" class="btn btn-warning w-100 disabled" disabled>
                                <i class="fas fa-lock mr-2"></i> 当前输入的密码不合法
                            </button>
                            <button v-else-if="!submitting" class="btn btn-warning w-100"
                                    v-bind:disabled="!isReady"
                                    v-on:click="submit">
                                <i class="fas fa-edit mr-2"></i> 提交更改
                            </button>
                            <button v-else class="btn btn-warning w-100 disabled" disabled>
                                <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                                处理中
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChangePasswordComponent",
        props: ['id', 'api', 'self', 'user', 'isSuperUser', 'isSelf'],
        data: function () {
            return {
                oldPassword: '',
                newPassword: '',
                newPasswordRepeat: '',
                submitting: false,
            }
        },
        computed: {
            newPasswordValid() {
                return this.newPassword.length >= 8;
            },
            newPasswordConfirmed() {
                return this.newPassword === this.newPasswordRepeat;
            },
            isReady() {
                if (!this.isSuperUser && this.isSelf && !this.oldPassword) return false;
                return this.newPasswordValid && this.newPasswordConfirmed;
            }
        },
        methods: {
            submit() {
                if (!this.isReady) return;

                this.submitting = true;
                window.axios.put(this.api, {
                    password: this.isSuperUser || this.isSelf
                        ? this.oldPassword : 'AdminDoesNotNeedToGivePassword',
                    new_password: this.newPassword,
                }).then(res => {
                    console.debug(res);
                    window.$.alert({
                        type: 'green',
                        title: '成功',
                        content: '成功修改密码。',
                    });
                    window.$('#' + this.id).modal('hide');
                }).catch(err => {
                    console.error(err);
                    window.$.alert({
                        type: 'red',
                        title: '错误',
                        content: err,
                    });
                }).finally(() => {
                    this.submitting = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>
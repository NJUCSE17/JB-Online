<template>
    <div class="modal fade" v-bind:id="id" tabindex="-1" role="dialog"
         v-bind:aria-labelledby="id + 'Title'" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-bind:id="id + 'Title'">
                        {{ canEdit ? '编辑' : '查看' }}用户信息
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="canEdit && !isSelf" class="alert alert-outline-success">
                        <i class="fas fa-exclamation-circle mr-2"></i> 警告：你正在修改其他用户的信息。
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">用户名</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="UserName" type="text"
                                   class="form-control"
                                   placeholder="Alice / Bob"
                                   v-on:keyup.enter="submit"
                                   v-model="userName"
                                   v-bind:readonly="!canEdit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">
                            邮箱地址
                            <strong v-if="canEdit">（注意：修改邮箱地址后需要重新认证。）</strong>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input id="UserEmail" type="email"
                                   class="form-control"
                                   placeholder="alice@nju.edu.cn"
                                   v-on:keyup.enter="submit"
                                   v-model="userEmail"
                                   v-bind:readonly="!canEdit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">
                            接收邮件通知（包括且不限于每日提示和作业修改通知）
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                            </div>
                            <select id="UserWantEmail"
                                    class="form-control"
                                    v-on:keyup.enter="submit"
                                    v-model="userWantEmail"
                                    v-bind:readonly="!canEdit">
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">博客RSS/Feed地址（选填，支持RSS/Atom格式）</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-rss"></i></span>
                            </div>
                            <input id="UserBlogFeedURL" type="url"
                                   class="form-control"
                                   placeholder="https://your-site.com/rss"
                                   v-on:keyup.enter="submit"
                                   v-model="userBlogFeedURL"
                                   v-bind:readonly="!canEdit">
                        </div>
                    </div>
                    <div v-if="canEdit" v-bind:id="id + 'Control'">
                        <hr/>
                        <div class="form-group">
                            <label class="form-control-label">输入密码以验证身份</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input id="UserPassword" type="password"
                                       class="form-control"
                                       v-on:keyup.enter="submit"
                                       v-model="userPassword"
                                       v-bind:disabled="isSuperUser || !isSelf"
                                       v-bind:placeholder="isSuperUser ? '管理员无需提供密码' : ''">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button v-if="!isReady" class="btn btn-success w-100 disabled" disabled>
                                    <i class="fas fa-lock mr-2"></i> {{ notReadyReason }}
                                </button>
                                <button v-else-if="!submitting" class="btn btn-success w-100"
                                        v-bind:disabled="!isReady"
                                        v-on:click="submit">
                                    <i class="fas fa-edit mr-2"></i> 提交更改
                                </button>
                                <button v-else class="btn btn-success w-100 disabled" disabled>
                                <span class="spinner-border spinner-border-sm mr-2" role="status"
                                      aria-hidden="true"></span>
                                    处理中
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserInfoEditorComponent",
        props: ['id', 'api', 'self', 'user', 'isSuperUser', 'isSelf', 'canEdit'],
        data: function () {
            return {
                userName: this.user.name,
                userEmail: this.user.email,
                userWantEmail: this.user.want_email ? 1 : 0,
                userBlogFeedURL: this.user.blog_feed_url,
                userPassword: '',
                submitting: '',
            }
        },
        computed: {
            notReadyReason() {
                if (!this.userName) {
                    return '未提供用户名';
                } else if (!this.userEmail || !(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.userEmail))) {
                    return '未提供邮箱或格式非法';
                } else if (this.userBlogFeedURL && !(/http[s]?:\/\/[^\s]+\.[^\s]+\/[^\s]+$/).test(this.userBlogFeedURL)) {
                    return '博客RSS/Feed地址不正确';
                } else if (!this.isSuperUser && this.isSelf && this.userPassword.length < 8) {
                    return '未提供密码';
                } else {
                    return null;
                }
            },
            isReady() {
                return this.notReadyReason === null;
            }
        },
        methods: {
            submit() {
                if (!this.isReady) return;

                if (this.userEmail !== this.user.email) {
                    window.$.confirm({
                        type: 'red',
                        icon: 'fas fa-exclamation-triangle',
                        title: '警告',
                        content: '你确定要修改邮箱地址吗？<br/>这将会导致账户被注销认证并禁用，直到您重新认证邮箱地址为止。',
                        buttons: {
                            confirm: {
                                text: '确定',
                                btnClass: 'btn-danger',
                                action: () => {
                                    this.doSubmit();
                                }
                            },
                            cancel: {
                                text: '取消',
                            },
                        }
                    });
                } else {
                    this.doSubmit();
                }
            },
            doSubmit() {
                this.submitting = true;
                window.axios.put(this.api, {
                    password: !this.isSuperUser && this.isSelf
                        ? this.userPassword : 'AdminDoesNotNeedToGivePassword',
                    name: this.userName,
                    email: this.userEmail,
                    want_email: this.userWantEmail,
                    blog_feed_url: this.userBlogFeedURL,
                }).then(res => {
                    console.debug(res);
                    window.$.alert({
                        type: 'green',
                        icon: 'fas fa-check',
                        title: '成功',
                        content: '成功修改用户信息。',
                    });
                    window.$('#' + this.id).modal('hide');
                    if (this.userEmail !== this.user.email) {
                        location.reload();
                    }
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
            }
        }
    }
</script>

<style scoped>

</style>
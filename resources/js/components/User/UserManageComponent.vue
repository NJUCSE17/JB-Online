<template>
    <div class="modal fade" v-bind:id="id" tabindex="-1" role="dialog"
         v-bind:aria-labelledby="id + 'Title'" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-bind:id="id + 'Title'">用户管理</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <div v-if="user.is_verified" class="h3 text-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div v-else class="h3 text-danger">
                                    <i class="fas fa-times"></i>
                                </div>
                                <h6>{{ user.is_verified ? '已验证' : '未验证'}}</h6>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <div v-if="is_active" class="h3 text-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div v-else class="h3 text-danger">
                                    <i class="fas fa-times"></i>
                                </div>
                                <h6>{{ is_active ? '已启用' : '未启用' }}</h6>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <div class="h3 text-primary">
                                    <span v-if="user.privilege_level === 0" class="text-primary">0</span>
                                    <span v-if="user.privilege_level === 1" class="text-danger">1</span>
                                    <span v-if="user.privilege_level === 2" class="text-warning">2</span>
                                    <span v-if="user.privilege_level === 3" class="text-success">3</span>
                                </div>
                                <h6>权限级别</h6>
                            </div>
                        </div>
                    </div>
                    <div v-if="user.privilege_level >= 2" v-bind:id="id + 'Control'">
                        <hr/>
                        <div class="form-group">
                            <label class="form-control-label">输入学号以确认</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input id="StudentID" type="text"
                                       class="form-control"
                                       v-on:keyup.enter="submit"
                                       v-bind:placeholder="user.student_id"
                                       v-model="studentID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button v-if="!isReady" class="btn btn-warning w-100 disabled" disabled>
                                    <i class="fas fa-lock mr-2"></i> 学号不正确
                                </button>
                                <button v-else-if="!submitting && is_active" class="btn btn-danger w-100"
                                        v-on:click="submit">
                                    <i class="fas fa-user-times mr-2"></i> 禁用用户
                                </button>
                                <button v-else-if="!submitting && !is_active" class="btn btn-success w-100"
                                        v-on:click="submit">
                                    <i class="fas fa-user-check mr-2"></i> 启用用户
                                </button>
                                <button v-else class="btn btn-warning w-100 disabled" disabled>
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
        name: "UserManageComponent",
        props: ['id', 'api', 'self', 'user', 'isSuperUser', 'isSelf'],
        data: function () {
            return {
                is_active: this.user.is_active,
                api_activate: this.api + '/activate',
                api_deactivate: this.api + '/deactivate',
                studentID: '',
                submitting: false,
            }
        },
        computed: {
            isReady() {
                return parseInt(this.studentID) === this.user.student_id;
            },
        },
        methods: {
            submit() {
                if (!this.isReady) return;
                if (this.is_active) {
                    this.deactivate();
                } else {
                    this.activate();
                }
            },
            activate() {
                this.submitting = true;
                window.axios.post(this.api_activate, {
                    // no data
                }).then(res => {
                    console.debug(res);
                    window.$.alert({
                        type: 'green',
                        icon: 'fas fa-check',
                        title: '成功',
                        content: '成功启用用户' + this.user.name + '。',
                    });
                    this.is_active = true;
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
            deactivate() {
                this.submitting = true;
                window.axios.post(this.api_deactivate, {
                    // no data
                }).then(res => {
                    console.debug(res);
                    window.$.alert({
                        type: 'green',
                        icon: 'fas fa-check',
                        title: '成功',
                        content: '成功禁用用户' + this.user.name + '。',
                    });
                    this.is_active = false;
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
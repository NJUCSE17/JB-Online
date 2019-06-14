<template>
    <div id="createAssignmentComponent">
        <button class="btn btn-sm btn-soft-primary" type="button"
            v-on:click="openInitModal">
            <i class="fas fa-plus"></i>
        </button>

        <div class="modal fade" id="waitingModal"
             tabindex="-1" role="dialog" aria-labelledby="waitingModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="spinner-grow" role="status"></div>
                        </div>
                        <h5 class="modal-title text-center" id="waitingModalTitle">请稍等</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createAssignmentModal"
             tabindex="-1" role="dialog" aria-labelledby="createAssignmentModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAssignmentModalTitle">
                            请选择作业类型
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <button class="btn btn-soft-success w-100" type="button"
                                v-on:click="proceedToPersonal">
                            <i class="fas fa-user mr-2"></i>个人作业
                        </button>
                        <hr />
                        <select class="custom-select form-control mb-3" v-model="courseSelected">
                            <option disabled value="">TODO: 从服务器获取可编辑课程列表，让用户选择</option>
                        </select>
                        <button class="btn btn-soft-info w-100" type="button"
                                v-on:click="proceedToPublic1"
                                :disabled="!courseSelected">
                            <i class="fas fa-book mr-2"></i>课程作业
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="personalAssignmentModal"
             tabindex="-1" role="dialog" aria-labelledby="personalAssignmentModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="personalAssignmentModalTitle">创建个人作业</h5>
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
                                <input id="personalAssignmentName"
                                       v-model="personalAssignmentName"
                                       class="form-control" placeholder="作业名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">作业内容</label>
                            <div class="input-group">
                                <textarea id="personalAssignmentContent"
                                          v-model="personalAssignmentContent"
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
                                <input id="personalAssignmentDDL" class="form-control"
                                       v-model="personalAssignmentDDL"
                                       data-inputmask="'mask': '9999-99-99 99:99:99'"
                                       placeholder="2017-09-01 14:00:00">
                            </div>
                        </div>
                        <hr />
                        <button class="btn btn-success w-100" v-on:click="submitPersonal"
                            v-bind:class="{ disabled : !isPersonalReady }"
                            :disabled="!isPersonalReady">
                            <i class="fas fa-check mr-2"></i> 提交
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CreateAssignmentComponent",
        props: ['_api_personal', '_api_public'],
        data: function () {
            return {
                api_personal: this._api_personal,
                api_public: this._api_public,
                personalAssignmentName: '',
                personalAssignmentContent: '',
                personalAssignmentDDL: '',
                courseSelected: '',
            }
        },
        computed: {
            isPersonalReady() {
                if (!this.personalAssignmentName) return false;
                if (!this.personalAssignmentContent) return false;
                if (!this.personalAssignmentDDL) return false;
                return !(this.personalAssignmentDDL.indexOf('_') >= 0);
            }
        },
        methods: {
            openInitModal() {
                window.$('#createAssignmentModal').modal('show');
            },
            proceedToPersonal() {
                window.$('#createAssignmentModal').modal('hide');
                window.$('#personalAssignmentModal').modal('show');
            },
            submitPersonal() {
                let name = window.$('#personalAssignmentName').val();
                let content = window.$('#personalAssignmentContent').val();
                let ddl = window.$('#personalAssignmentDDL').val();

                window.$('#personalAssignmentModal').modal('hide');
                window.$('#waitingModal').modal('show');
                window.axios.post(this.api_personal, {
                    name: name,
                    content: content,
                    due_time: ddl,
                }).then(res => {
                    console.log(res);
                    location.reload();
                }).catch(err => {
                    console.log(err);
                    window.$('#waitingModal').modal('hide');
                    window.$.alert({
                        type: 'red',
                        title: '错误',
                        content: err,
                    });
                    window.$('#personalAssignmentModal').modal('show');
                });
            },
            proceedToPublic1() {
                window.$('#createAssignmentModal').modal('hide');
                window.$('#publicAssignmentModal1').modal('show');
            },
            proceedToPublic2() {
                window.$('#publicAssignmentModal1').modal('hide');
                window.$('#publicAssignmentModal2').modal('show');
            }
        }
    }
</script>

<style scoped>

</style>
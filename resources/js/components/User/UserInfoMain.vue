<template>
    <div id="UserInfo">
        <div id="UserInfoControl">
            <p class="h3">用户设置</p>
        </div>
        <hr/>
        <div v-if="initializing">
            <div class="row">
                <div class="col text-center mb-3">
                    <div class="spinner spinner-border" role="status"></div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <p>{{ init_status }}</p>
                </div>
            </div>
        </div>
        <div v-else id="UserInfoContent">
            <div class="row">
                <div v-if="canEdit" class="col col-12 mb-2"
                    v-bind:class="isSuperUser ? 'col-md-4' : 'col-md-6'">
                    <button class="btn btn-soft-success w-100 disabled">
                        <i class="fas fa-user-edit mr-2"></i> 修改用户信息
                    </button>
                </div>
                <div v-else class="col col-12 mb-2">
                    <button class="btn btn-soft-info w-100 disabled">
                        <i class="fas fa-user mr-2"></i> 查看用户信息
                    </button>
                </div>

                <div v-if="canEdit" class="col col-12 mb-2"
                     v-bind:class="isSuperUser ? 'col-md-4' : 'col-md-6'">
                    <button class="btn btn-soft-warning w-100"
                            v-on:click="changePassword">
                        <i class="fas fa-key mr-2"></i> 修改登录密码
                    </button>
                    <change-password-component
                            :id="passwordID"
                            :api="api + '/' + user.id"
                            :self="self"
                            :user="user"
                            :isSuperUser="isSuperUser"
                            :isSelf="isSelf"
                    ></change-password-component>
                </div>

                <div v-if="isSuperUser" class="col col-12 col-md-4 mb-2">
                    <button class="btn btn-soft-danger w-100 disabled">
                        <i class="fas fa-user-cog mr-2"></i> 用户管理选项
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ChangePasswordComponent from "./ChangePasswordComponent";
    export default {
        name: "UserInfoMain",
        components: {ChangePasswordComponent},
        props: ['user_id'],
        data: function () {
            return {
                initializing: true,
                init_status: '',
                api: '/api/user',
                self: null,
                user: null,
                passwordID: 'ChangePasswordComponent',
            }
        },
        computed: {
            isSuperUser() {
                return this.self.privilege_level <= 1;
            },
            isSelf() {
                return this.self.id === this.user_id;
            },
            canEdit() {
                return this.isSuperUser || this.isSelf;
            }
        },
        created: function () {
            this.getInfo();
        },
        methods: {
            getInfo() {
                this.init_status = '正在检查你的信息...';
                window.axios.get(this.api, {
                    params: {
                        self: 1,
                    }
                }).then(res => {
                    console.log(res);
                    this.self = res.data;
                }).catch(err => {
                    console.error(err);
                }).finally(() => {
                    this.init_status = '正在获取目标用户...';
                    window.axios.get(this.api + '/' + this.user_id, {
                        // no data
                    }).then(res => {
                        console.log(res);
                        this.user = res.data;
                    }).catch(err => {
                        console.error(err);
                    }).finally(() => {
                        console.log("User info loaded.");
                        this.initializing = false;
                    });
                })
            },
            changePassword() {
                window.$('#' + this.passwordID).modal('show');
            },
        }
    }
</script>

<style scoped>

</style>
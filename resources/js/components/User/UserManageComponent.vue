<template>
    <div class="modal fade" v-bind:id="id" tabindex="-1" role="dialog"
         v-bind:aria-labelledby="id + 'Title'" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-bind:id="id + 'Title'">用户信息</h5>
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
                                <h6>已验证</h6>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <div v-if="user.is_active" class="h3 text-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div v-else class="h3 text-danger">
                                    <i class="fas fa-times"></i>
                                </div>
                                <h6>已启用</h6>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <div class="h3 text-primary">
                                    {{ user.privilege_level }}
                                </div>
                                <h6>权限级别</h6>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div v-if="!isSelf" class="alert alert-outline-success">
                        <i class="fas fa-exclamation-circle mr-2"></i> 警告：你正在修改其他用户的信息。
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">用户名</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="userName" type="text"
                                   class="form-control"
                                   v-on:keyup.enter="submit"
                                   v-model="userName">
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
        props: ['id', 'api', 'self', 'user', 'isSuperUser', 'isSelf'],
        data: function () {
            return {
                userName: this.user.name,
                userEmail: this.user.email,
                userBlogFeedURL: this.user.blog_feed_url,
            }
        },
        computed: {
            isReady() {

            },
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
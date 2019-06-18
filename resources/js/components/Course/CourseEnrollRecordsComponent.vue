<template>
    <div class="list-group-item pt-4 pb-0">
        <div v-bind:id="id">
            <div v-bind:id="id + 'Control'">
                <p class="h3">
                    {{ course.name }}的用户列表
                </p>
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
            <div v-else class="table-responsive">
                <table class="table align-items-center">
                    <thead>
                    <tr>
                        <td class="text-center">学号</td>
                        <td class="text-center">姓名</td>
                        <td class="text-center">状态</td>
                        <td class="text-center">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users_with_records">
                        <td class="text-center">{{ user.student_id }} ({{ user.id }}/{{ user.privilege_level }})</td>
                        <td class="text-center">{{ user.name }}</td>
                        <td class="text-center">
                            <span v-if="user.is_in_course && user.is_course_admin" class="text-warning">
                                <i class="fas fa-check-double mr-2"></i> 管理员
                            </span>
                            <span v-else-if="user.is_in_course" class="text-success">
                                <i class="fas fa-check mr-2"></i> 已注册
                            </span>
                            <span v-else class="text-danger">
                                <i class="fas fa-times mr-2"></i> 未注册
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button v-if="!user.is_in_course" class="btn btn-sm btn-soft-success"
                                        v-on:click="enrollCourse($event, user.id, 0)">
                                    用户
                                </button>
                                <button v-if="!user.is_in_course" class="btn btn-sm btn-soft-warning"
                                        v-on:click="enrollCourse($event, user.id, 1)">
                                    管理员
                                </button>
                                <button v-if="user.is_in_course" class="btn btn-sm btn-soft-danger"
                                        v-on:click="quitCourse($event, user.id)">
                                    移除注册
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CourseEnrollRecordsComponent",
        props: ['id', 'api_user', 'api_course', 'course'],
        data: function () {
            return {
                initializing: true,
                init_status: '',
                users: [],
                records: [],
            }
        },
        computed: {
            users_with_records() {
                let ret = [];
                for (let i = 0; i < this.users.length; ++i) {
                    let user = {
                        id: this.users[i].id,
                        name: this.users[i].name,
                        student_id: this.users[i].student_id,
                        privilege_level: this.users[i].privilege_level,
                        is_in_course: false,
                        is_course_admin: false,
                    };
                    for (let j = 0; j < this.records.length; ++j) {
                        if (this.records[j].user_id === user.id) {
                            user.is_in_course = true;
                            user.is_course_admin = this.records[j].type_is_admin;
                            break;
                        }
                    }
                    ret = ret.concat([user]);
                }
                return ret;
            }
        },
        created: function () {
            this.loadUserAndRecords();
        },
        methods: {
            loadUserAndRecords() {
                this.init_status = '正在加载用户列表...';
                window.axios.get(this.api_user, {
                    // no data
                }).then(res => {
                    console.debug(res);
                    this.users = res.data;
                }).catch(err => {
                    console.error(err);
                }).finally(() => {
                    this.init_status = '正在加载注册记录...';
                    window.axios.get(this.api_course + '/records', {
                        // no data
                    }).then(res => {
                        console.debug(res);
                        this.records = res.data;
                    }).catch(err => {
                        console.error(res);
                    }).finally(() => {
                        this.initializing = false;
                        this.init_status = '';
                    })
                });
            },
            enrollCourse(event, id, type_is_admin) {
                window.axios.post(this.api_course + '/enroll', {
                    user_id: id,
                    type_is_admin: type_is_admin,
                }).then(res => {
                    console.debug(res);
                    for (let j = 0; j < this.records.length; ++j) {
                        if (this.records[j].user_id === id) {
                            this.records.splice(j, 1);
                            break;
                        }
                    }
                    this.records = this.records.concat([res.data]);
                }).catch(err => {
                    console.error(err);
                });
            },
            quitCourse(event, id) {
                window.axios.post(this.api_course + '/quit', {
                    user_id: id,
                }).then(res => {
                    console.debug(res);
                    for (let j = 0; j < this.records.length; ++j) {
                        if (this.records[j].user_id === id) {
                            this.records.splice(j, 1);
                            break;
                        }
                    }
                    this.records = this.records.concat([res.data]);
                }).catch(err => {
                    console.error(err);
                });
            },
        }
    }
</script>

<style scoped>

</style>
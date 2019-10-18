<template>
    <div id="CourseListMain">
        <div id="CourseListControl">
            <p class="h3">
                课程列表
                <span class="float-right" v-if="!initializing">
                    <course-creator-component
                            v-if="self.privilege_level <= 2"
                            :id="creatorID"
                            :api="api_course"
                            :timezone="timezone"
                            v-on:addCourse="addCourse"
                    ></course-creator-component>
                </span>
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
        <div v-else-if="courses.length > 0" id="CourseListContent">
            <div class="mb-4" v-for="course_type in courses_classified" v-bind:key="course_type.name">
                <p class="h5">{{ course_type.name }}</p>
                <div class="row my-4">
                    <course-item-component
                        v-for="course in course_type.courses"
                        v-bind:key="course.id"
                        :id="itemID + course.id"
                        :self_is_admin="self.privilege_level < 3"
                        :api_user="api_user"
                        :api_course="api_course + '/' + course.id"
                        :course="course"
                        :timezone="timezone"
                        v-on:updateCourse="updateCourse"
                        v-on:deleteCourse="deleteCourse"
                    ></course-item-component>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row">
                <div class="col text-center mb-3">
                    <i class="fas fa-box-open" style="font-size:150%;"></i>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <p>没有课程</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CourseCreatorComponent from "./CourseCreatorComponent";
    import CourseItemComponent from "./CourseItemComponent";

    export default {
        name: "CourseListMain",
        components: {CourseItemComponent, CourseCreatorComponent},
        props: ['timezone'],
        data: function () {
            return {
                initializing: true,
                init_status: '',
                api_user: '/api/user',
                api_course: '/api/course',
                self: null,
                courses: [],
                creatorID: 'CourseCreatorComponent',
                itemID: 'CourseItemComponent',
            }
        },
        computed: {
            courses_classified() {
                let res = [
                    {
                        'name': "已加入的当前课程",
                        'hide': false,
                        'courses': [],
                    },
                    {
                        'name': "其他进行中的课程",
                        'hide': false,
                        'courses': [],
                    },
                    {
                        'name': "已结束/未开始的课程",
                        'hide': true,
                        'courses': [],
                    },
                ];
                let now = window.Dayjs();
                for (let i = 0; i < this.courses.length; ++i) {
                    let course = this.courses[i];
                    if (window.Dayjs(course.start_time).isBefore(now)
                        && window.Dayjs(course.end_time).isAfter(now)) {
                        if (course.is_in_course) {
                            res[0].courses.push(course);
                        } else {
                            res[1].courses.push(course);
                        }
                    } else {
                        res[2].courses.push(course);
                    }
                }
                return res;
            }
        },
        created: function () {
            this.loadCourses();
        },
        methods: {
            cmp(a, b) {
                return a.begin_time > b.begin_time ? -1 : (a.name > b.name ? -1 : 1);
            },
            loadCourses() {
                this.init_status = '正在检查你的信息...';
                window.axios.get(this.api_user, {
                    params: {
                        self: 1,
                    }
                }).then(res => {
                    console.debug(res);
                    this.self = res.data;
                }).catch(err => {
                    console.error(err);
                }).finally(() => {
                    this.init_status = '正在获取课程列表...';
                    window.axios.get(this.api_course, {
                        // no data
                    }).then(res => {
                        console.debug(res);
                        this.courses = res.data;
                        this.courses = this.courses.sort(this.cmp);
                    }).catch(err => {
                        console.error(err);
                    }).finally(() => {
                        this.initializing = false;
                        this.init_status = '';
                    });
                });
            },
            addCourse(course) {
                window.Vue.set(this.courses, this.courses.length, course);
                console.log("Course added to list.");
            },
            updateCourse(course) {
                for (let pos = 0; pos < this.courses.length; ++pos) {
                    if (this.courses[pos].id === course.id) {
                        window.Vue.set(this.courses, pos, course);
                        break;
                    }
                }
            },
            deleteCourse(course) {
                let pos = this.courses.indexOf(course);
                window.Vue.delete(this.courses, pos);
            }
        }
    }
</script>

<style scoped>

</style>

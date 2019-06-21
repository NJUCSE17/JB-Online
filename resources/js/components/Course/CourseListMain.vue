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
            <div v-for="course in courses_sorted" class="list-group">
                <course-item-component
                        :id="itemID + course.id"
                        :api_user="api_user"
                        :api_course="api_course + '/' + course.id"
                        :course="course"
                        v-on:updateCourse="updateCourse"
                        v-on:deleteCourse="deleteCourse"
                ></course-item-component>
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
            courses_sorted() {
                return this.courses.sort(this.compareBySemester);
            }
        },
        created: function () {
            this.loadCourses();
        },
        methods: {
            compareBySemester(a, b) {
                return a.semester > b.semester ? -1 : 1;
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
                    }).catch(err => {
                        console.error(err);
                    }).finally(() => {
                        this.initializing = false;
                        this.init_status = '';
                    });
                });
            },
            addCourse(course) {
                this.courses = this.courses.concat([course]);
                console.log("Course added to list.");
                this.$forceUpdate();
            },
            updateCourse(data) {
                let pos = this.courses.indexOf(data.oldCourse);
                this.courses[pos] = data.newCourse;
                this.$forceUpdate();
            },
            deleteCourse(course) {
                let pos = this.courses.indexOf(course);
                this.courses.splice(pos, 1);
                this.$forceUpdate();
            }
        }
    }
</script>

<style scoped>

</style>
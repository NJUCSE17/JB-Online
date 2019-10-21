<template>
    <div id="AssignmentKanban">
        <div class="alert alert-outline-info py-2" role="alert">
            <i class="far fa-gift mr-1"></i>
            新功能：点击并拖动作业来改变状态。之前2小时内截止的作业现在也会显示在主页上。
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <kanban-board :stages="stages" :blocks="assignments_classified">
            <div v-for="stage in stages" :slot="stage" :key="stage">
                <h5>{{ stages_str[stage] }}</h5>
            </div>
            <div v-for="assignment in assignments_classified" :slot="assignment.id" :key="assignment.id">
                <div class="card shadow-none px-0">
                    <div class="card-body p-3">
                        <strong class="card-title">
                            {{ assignment.name }}
                            <a v-if="!assignment.course_id" class="float-right text-muted"
                               v-bind:href="'#' + assignment.id"
                               v-on:click.prevent="editAssignment(assignment.id)">
                                <i class="fas fa-user-edit"></i>
                            </a>
                            <a v-else-if="assignment.is_course_admin" class="float-right text-muted"
                               v-bind:href="'#' + assignment.id"
                               v-on:click.prevent="editAssignment(assignment.id)">
                                <i class="fas fa-edit"></i>
                            </a>
                        </strong>
                        <div v-html="assignment.content_html"></div>
                        <kanban-d-d-l-partial
                            :api="null"
                            :due_time="assignment.due_time"
                            :finished_at="assignment.finished_at"
                        ></kanban-d-d-l-partial>
                    </div>
                </div>
                <assignment-editor
                    :id="assignment.id + '-editor'"
                    :api="assignment.api"
                    :assignment="assignment"
                    :timezone="timezone"
                    v-on:updateAssignment="updateAssignment"
                    v-on:deleteAssignment="deleteAssignment"
                ></assignment-editor>
            </div>
        </kanban-board>
    </div>
</template>

<script>
    import vueKanban from 'vue-kanban';
    import KanbanDDLPartial from "./KanbanDDLPartial";
    import AssignmentEditor from "../Assignment/AssignmentEditor";
    window.Vue.use(vueKanban);
    export default {
        name: 'KanbanMain',
        components: {AssignmentEditor, KanbanDDLPartial},
        props: ['assignments', 'timezone'],
        data: function () {
            return {
                stages: [0, 1, 2],
                stages_str: ['未处理', '进行中', '已完成'],
                blocks: [],
            }
        },
        computed: {
            assignments_classified() {
                let arr = [];
                this.assignments.forEach(assignment => {
                    assignment = $.extend({}, assignment);
                    assignment.id = assignment.uid;
                    if (assignment.finished_at) {
                        assignment.status = 2;
                    } else if (assignment.is_ongoing) {
                        assignment.status = 1;
                    } else {
                        assignment.status = 0;
                    }
                    arr.push(assignment);
                });
                return arr;
            }
        },
        methods: {
            assignmentDetail(assignment) {
                return "<ul class='m-0 pl-3 text-left'>"
                    + "<li>课程：" + assignment.course_name + "</li>"
                    + "<li>作业：" + assignment.name + "</li>"
                    + "<li>DDL：" + assignment.due_time + "</li>"
                    + "</ul>";
            },
            editAssignment(assignmentID) {
                window.$('#' + assignmentID + '-editor').modal('show');
            },
            updateAssignment(assignment) {
                this.$emit('updateAssignment', assignment);
            },
            deleteAssignment() {
                this.$emit('deleteAssignment', this.assignment);
            }
        }
    }
</script>

<style lang="scss">
    $ease-out: all .5s cubic-bezier(0.23, 1, 0.32, 1);

    ul.drag-list, ul.drag-inner-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .drag-container {
        max-width: 1000px;
        margin: 20px auto;
    }

    .drag-list {
        display: flex;
        align-items: flex-start;

        @media (max-width: 690px) {
            display: block;
        }
    }

    .drag-column {
        flex: 1;
        margin: 0 5px;
        position: relative;
        overflow: hidden;

        @media (max-width: 690px) {
            margin-bottom: 30px;
        }
    }

    .drag-column-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
    }

    .drag-inner-list {
        @media (max-width: 690px) {
            min-height: 100px;
        }
        @media (min-width: 691px) {
            min-height: 300px;
        }
    }

    .drag-item {
        margin: 10px;
        transition: $ease-out;

        &.is-moving {
            transform: scale(1.1);
        }
    }

    .drag-header-more {
        cursor: pointer;
    }

    .drag-options {
        position: absolute;
        top: 44px;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 10px;
        transform: translateX(100%);
        opacity: 0;
        transition: $ease-out;

        &.active {
            transform: translateX(0);
            opacity: 1;
        }

        &-label {
            display: block;
            margin: 0 0 5px 0;

            input {
                opacity: 0.6;
            }

            span {
                display: inline-block;
                font-size: 0.9rem;
                font-weight: 400;
                margin-left: 5px;
            }
        }
    }

    /* Dragula CSS  */

    .gu-mirror {
        position: fixed !important;
        margin: 0 !important;
        z-index: 9999 !important;
        opacity: 0.8;
        list-style-type: none;
    }

    .gu-hide {
        display: none !important;
    }

    .gu-unselectable {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
    }

    .gu-transit {
        opacity: 0.2;
    }
</style>

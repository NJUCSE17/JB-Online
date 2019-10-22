<template>
    <div id="AssignmentKanban">
        <div class="alert alert-outline-info py-2" role="alert">
            <i class="far fa-gift mr-1"></i>
            新功能：点击作业名称来查看详细信息，点击并拖动作业来改变状态。之前2小时内截止的作业现在也会显示在主页上。
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <kanban-board :stages="stages" :blocks="assignments_classified"
                      v-on:update-block="updateAssignmentStatus">
            <div v-for="stage in stages" :slot="stage" :key="stage">
                <h5>{{ stages_str[stage] }}</h5>
            </div>
            <div v-for="assignment in assignments_classified" :slot="assignment.id" :key="assignment.id">
                <div class="card shadow-none px-0"
                     v-bind:id="assignment.id">
                    <div class="card-body p-3">
                        <div class="card-title">
                            <a class="text-muted" style="font-weight: bold;" tabindex="0"
                               data-toggle="popover"
                               data-html="true"
                               data-trigger="focus"
                               v-bind:data-title="assignment.name"
                               v-bind:data-content="assignmentDetail(assignment)"
                               v-bind:id="assignment.id + '-title'"
                               v-bind:href="'#' + assignment.id"
                               v-on:click.prevent="triggerAssignmentPopover(assignment.id)">
                                {{ assignment.name }}
                            </a>
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
                        </div>
                        <div class="d-block d-xl-none" v-html="assignment.content_html"></div>
                        <kanban-rate-partial
                            v-if="assignment.hasOwnProperty('course_id')"
                            :id="assignment.id + '-rate'"
                            :api="assignment.api + '/rate'"
                            :rate_info="assignment.rate_info"
                        ></kanban-rate-partial>
                        <kanban-d-d-l-partial
                            :api="null"
                            :due_time="assignment.due_time"
                            :finished_at="assignment.finished_at"
                        ></kanban-d-d-l-partial>
                        <hr class="my-2 d-flex d-xl-none">
                        <div class="row text-center d-flex d-xl-none">
                            <div class="col" v-if="assignment.status !== 0">
                                <a class="badge badge-secondary"
                                   v-bind:href="'#' + assignment.id"
                                   v-on:click.prevent="updateAssignmentStatus(assignment.id, 0)">
                                    <i class="far fa-trash-alt"></i> 没有做
                                </a>
                            </div>
                            <div class="col" v-if="assignment.status !== 1">
                                <a class="badge badge-secondary"
                                   v-bind:href="'#' + assignment.id"
                                   v-on:click.prevent="updateAssignmentStatus(assignment.id, 1)">
                                    <i class="far fa-pen-alt"></i> 在做了
                                </a>
                            </div>
                            <div class="col" v-if="assignment.status !== 2">
                                <a class="badge badge-secondary"
                                   v-bind:href="'#' + assignment.id"
                                   v-on:click.prevent="updateAssignmentStatus(assignment.id, 2)">
                                    <i class="far fa-check-circle"></i> 做完了
                                </a>
                            </div>
                        </div>
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
    import AssignmentEditor from "../Assignment/AssignmentEditor";
    import KanbanDDLPartial from "./KanbanDDLPartial";
    import KanbanRatePartial from "./KanbanRatePartial";
    export default {
        name: 'KanbanMain',
        components: {KanbanRatePartial, AssignmentEditor, KanbanDDLPartial},
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
        mounted() {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus'
            });
        },
        updated() {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus'
            });
        },
        methods: {
            assignmentDetail(assignment) {
                return assignment.content_html
                    + "<ul class='m-0 pl-3 text-left'>"
                    + "<li>课程：" + assignment.course_name + "</li>"
                    + "<li>作业：" + assignment.name + "</li>"
                    + "<li>DDL：" + assignment.due_time + "</li>"
                    + "</ul>";
            },
            triggerAssignmentPopover(assignmentID) {
                $('#'+assignmentID+'-title').focus();
            },
            disposeAssignmentPopover(assignmentID) {
                $('#'+assignmentID+'-title').popover('dispose');
            },
            editAssignment(assignmentID) {
                window.$('#' + assignmentID + '-editor').modal('show');
            },
            updateAssignmentStatus(assignmentID, status) {
                this.disposeAssignmentPopover(assignmentID);
                if (typeof status === 'string') status = parseInt(status);
                console.log('Status of ' + assignmentID + ' updated => ' + status);
                let assignment = this.assignments_classified.find(a => a.id === assignmentID);
                switch (status) {
                    case 0: // reset
                        window.axios.post(assignment.api + '/reset', {
                            // no data
                        }).then(res => {
                            console.debug(res);
                            this.$emit('updateAssignmentStatus', assignmentID, {
                                is_ongoing:  null,
                                finished_at: null,
                            });
                        }).catch(err => {
                            console.error(err);
                            window.$.alert({
                                type: 'red',
                                icon: 'fas fa-times',
                                title: '错误',
                                content: err,
                            });
                        });
                        break;
                    case 1: // ongoing
                        window.axios.post(assignment.api + '/finish', {
                            is_ongoing: true
                        }).then(res => {
                            console.debug(res);
                            this.$emit('updateAssignmentStatus', assignmentID, res.data);
                        }).catch(err => {
                            console.error(err);
                            window.$.alert({
                                type: 'red',
                                icon: 'fas fa-times',
                                title: '错误',
                                content: err,
                            });
                        });
                        break;
                    case 2: // finished
                        window.axios.post(assignment.api + '/finish', {
                            is_ongoing: false
                        }).then(res => {
                            console.debug(res);
                            this.$emit('updateAssignmentStatus', assignmentID, res.data);
                        }).catch(err => {
                            console.error(err);
                            window.$.alert({
                                type: 'red',
                                icon: 'fas fa-times',
                                title: '错误',
                                content: err,
                            });
                        });
                        break;
                }
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
    $xl: 1199px;

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

        @media (max-width: $xl) {
            display: block;
        }
    }

    .drag-column {
        flex: 1;
        margin: 0 5px;
        position: relative;
        overflow: hidden;

        @media (max-width: $xl) {
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
        @media (max-width: $xl) {
            min-height: 100px;
        }
        @media (min-width: $xl) {
            min-height: 300px;
        }
    }

    .drag-item {
        margin: 10px;
        transition: $ease-out;

        @media (min-width: $xl) {
            &.is-moving {
                transform: scale(1.1);
            }
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
    @media (min-width: $xl) {
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
    }
</style>

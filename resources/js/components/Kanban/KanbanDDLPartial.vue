<template>
    <span class="text-sm">
        <span v-bind:class="'badge badge-' + this.color">{{ this.label }}</span><br/>
        <span>{{ this.dueTime }}</span>
    </span>
</template>

<script>
    export default {
        name: "KanbanDDLPartial",
        props: ['api', 'due_time', 'finished_at'],
        data: function () {
            return {
                nr_periods: 7,
                periods: [
                    ['year', '年'],
                    ['month', '个月'],
                    ['week', '周'],
                    ['day', '天'],
                    ['hour', '小时'],
                    ['minute', '分钟'],
                    ['second', '秒']
                ],
                api_finish: this.api + '/finish',
                api_reset: this.api + '/reset',
                record: this.finished_at,
                color: '',
                label: '',
            }
        },
        computed: {
            dueTime() {
                return window.Dayjs(this.due_time).format('MM月DD日 (ddd) HH:mm');
            },
        },
        created: function () {
            this.color = this.getColor();
            this.label = this.getLabel();
            window.setInterval(() => {
                this.color = this.getColor();
                this.label = this.getLabel();
            }, 1000);
        },
        methods: {
            getColor() {
                let now = window.Dayjs();
                let ddl = window.Dayjs(this.due_time);
                let delta = ddl.diff(now, 'day');
                if (now.isAfter(ddl)) {
                    return 'dark';
                } else if (this.finished_at) {
                    return 'success';
                } else {
                    if (delta <= 1) {
                        return 'danger';
                    } else if (delta <= 2) {
                        return 'warning';
                    } else if (delta <= 5) {
                        return 'info';
                    } else {
                        return 'secondary';
                    }
                }
            },
            getLabel() {
                let now = window.Dayjs();
                let ddl = window.Dayjs(this.due_time);
                if (now.isAfter(ddl)) {
                    return '已截止';
                } else {
                    let ret = '剩余';
                    let left = 2;
                    for (let i = 0; i < this.nr_periods && left > 0; ++i) {
                        let diff = ddl.diff(now, this.periods[i][0]);
                        if (diff > 0) {
                            --left;
                            now = now.add(diff, this.periods[i][0]);
                            ret += diff + this.periods[i][1];
                        }
                    }
                    if (left === 2) ret += '0秒';
                    return ret;
                }
            },
            finish() {
                window.axios.post(this.api_finish, {
                    // no data
                }).then(res => {
                    console.debug(res);
                    this.record = res.data;
                }).catch(err => {
                    console.error(err);
                    window.$.alert({
                        type: 'red',
                        icon: 'fas fa-times',
                        title: '错误',
                        content: err,
                    });
                });
            },
            reset() {
                window.axios.post(this.api_reset, {
                    // no data
                }).then(res => {
                    console.debug(res);
                    this.record = null;
                }).catch(err => {
                    console.error(err);
                    window.$.alert({
                        type: 'red',
                        title: '错误',
                        content: err,
                    });
                })
            }
        }
    }
</script>

<style scoped>

</style>

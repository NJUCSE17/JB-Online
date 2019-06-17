<template>
    <a v-if="record" v-bind:class="'text-success'"
       href="#" @click.prevent="reset">
        <i class="fas fa-check mr-1"></i>
        <span>
            <s>
                {{ this.label }}
            </s>
        </span>
    </a>
    <a v-else v-bind:class="this.color"
       href="#" @click.prevent="finish">
        <i class="fas fa-times mr-1"></i>
        <span>
            {{ this.label }}
        </span>
    </a>
</template>

<script>
    export default {
        name: "AssignmentDDLPartial",
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
        created: function() {
            this.color = this.getColor();
            this.label = this.getLabel();
            window.setInterval(() => {
                this.label = this.getLabel();
            }, 1000);
        },
        methods: {
            getColor() {
                let now = window.Dayjs();
                let ddl = window.Dayjs(this.due_time);
                let delta = ddl.diff(now, 'day');
                if (delta <= 1) {
                    return 'text-danger';
                } else if (delta <= 2) {
                    return 'text-warning';
                } else if (delta <= 5) {
                    return 'text-info';
                } else {
                    return 'text-muted';
                }
            },
            getLabel() {
                let now = window.Dayjs();
                let ddl = window.Dayjs(this.due_time);
                let ret = ddl.format('YYYY-MM-DD （ddd） HH:mm:ss');
                if (ddl.isBefore(now)) {
                    return ret + '，已截止';
                } else {
                    ret += '，剩余';
                    let left = 2;
                    for (let i = 0; i < this.nr_periods && left > 0; ++i) {
                        let diff = ddl.diff(now, this.periods[i][0]);
                        if (diff > 0) {
                            --left;
                            now = now.add(diff, this.periods[i][0]);
                            ret += diff + this.periods[i][1];
                        }
                    }
                    return ret;
                }
            },
            finish() {
                window.axios.post(this.api_finish)
                    .then(res => {
                        console.debug(res);
                        this.record = res.data;
                    })
                    .catch(err => {
                        console.error(err);
                        window.$.alert({
                            type: 'red',
                            title: '错误',
                            content: err,
                        });
                    });
            },
            reset() {
                window.axios.post(this.api_reset)
                    .then(res => {
                        console.debug(res);
                        this.record = null;
                    })
                    .catch(err => {
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
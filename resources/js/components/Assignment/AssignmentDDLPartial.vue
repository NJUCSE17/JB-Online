<template>
    <a v-if="record" v-bind:class="'text-success'"
       href="#" @click.prevent="reset">
        <i class="fas fa-check mr-1"></i>
        <span>
            <s>
                {{ this.ddl_for_human }}
            </s>
        </span>
    </a>
    <a v-else v-bind:class="this.ddl_color"
       href="#" @click.prevent="finish">
        <i class="fas fa-times mr-1"></i>
        <span>
            {{ this.ddl_for_human }}
        </span>
    </a>
</template>

<script>
    export default {
        name: "AssignmentDDLPartial",
        props: ['api', 'due_time', 'finish_record'],
        data: function() {
            return {
                api_finish: this.api + "/finish",
                api_reset: this.api + "/reset",
                record: this.finish_record,
            }
        },
        computed: {
            ddl_color: function() {
                let delta = (Date(this.due_time) - Date()) / (24 * 3600 * 1000);
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
            ddl_for_human: function () {
                let now = window.Dayjs();
                let ddl = window.Dayjs(this.due_time);
                let ret = ddl.format('YYYY-MM-DD （ddd） HH:mm:ss， 剩余');
                ret += ddl.diff(now, 'day') + "天";
                ret += ddl.diff(now, 'hour') % 24 + "小时";
                return ret;
            }
        },
        methods: {
            finish() {
                window.axios.post(this.api_finish)
                    .then(res => {
                        console.debug(res);
                        this.record = res.data;
                    })
                    .catch(err => {
                        console.log(err);
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
                        console.log(err);
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
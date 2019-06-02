<template>
    <a v-if="finished_at" v-bind:class="'text-success'"
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
        name: "DDLComponent",
        props: ['_api_finish', '_api_reset', '_due_time', '_finished_at'],
        data: function () {
            return {
                api_finish: this._api_finish,
                api_reset: this._api_reset,
                due_time: this._due_time,
                finished_at: this._finished_at,
            }
        },
        computed: {
            ddl_color: function () {
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
                return window.DateTime.fromISO(this.due_time).toISODate();
            }
        },
        methods: {
            finish() {
                window.axios.post(this.api_finish)
                    .then(res => {
                        console.log(res);
                        this.finished_at = res.data.finished_at;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            reset() {
                window.axios.post(this.api_reset)
                    .then(res => {
                        console.log(res);
                        this.finished_at = null;
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>

<style scoped>

</style>
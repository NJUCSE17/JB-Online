<template>
    <span>
        <a class="badge"
           v-bind:class="info.rated === 'dislike' ? 'btn-danger' : 'btn-soft-danger'"
           v-on:click.prevent="rate(false)">
            <i class="fas fa-heart-broken mr-1"></i> {{ info.stats.dislike }}
        </a>
        <a class="badge"
           v-bind:class="info.rated === 'like' ? 'btn-success' : 'btn-soft-success'"
           v-on:click.prevent="rate(true)">
            <i class="fas fa-heart mr-1"></i> {{ info.stats.like }}
        </a>
    </span>
</template>

<script>
    export default {
        name: "KanbanRatePartial",
        props: ['id', 'api', 'rate_info'],
        data: function () {
            return {
                info: this.rate_info,
            }
        },
        methods: {
            rate(like) {
                window.axios.post(this.api, {
                    'like': like
                }).then(res => {
                    console.debug(res);
                    this.info = res.data;
                }).catch(err => {
                    console.error(err);
                    window.$.alert({
                        type: 'red',
                        icon: 'fas fa-times',
                        title: '错误',
                        content: err,
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>

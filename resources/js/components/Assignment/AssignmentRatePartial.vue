<template>
    <div class="d-flex d-md-inline-flex">
        <div class="btn-group btn-group-sm w-100 mb-2 mb-md-0">
            <button class="btn btn-sm"
                    v-bind:class="info.rated === 'dislike' ? 'btn-danger' : 'btn-soft-danger'"
                    v-on:click="rate(false)">
                <i class="fas fa-heart-broken mr-1"></i> {{ info.stats.dislike }}
            </button>
            <button class="btn btn-sm"
                    v-bind:class="info.rated === 'like' ? 'btn-success' : 'btn-soft-success'"
                    v-on:click="rate(true)">
                <i class="fas fa-heart mr-1"></i> {{ info.stats.like }}
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AssignmentRatePartial",
        props: ['api', 'rate_info'],
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
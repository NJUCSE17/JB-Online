<template>
    <div class="d-inline-flex">
        <span class="mr-3">
            <a v-bind:class="info.rated === 'dislike' ? 'text-danger' : 'text-muted'"
               href="#" @click.prevent="rate(false)">
                <i class="fas fa-heart-broken mr-1"></i> {{ info.stats.dislike }}
            </a>
        </span>
        <span>
            <a v-bind:class="info.rated === 'like' ? 'text-success' : 'text-muted'"
               href="#" @click.prevent="rate(true)">
                <i class="fas fa-heart mr-1"></i> {{ info.stats.like }}
            </a>
        </span>
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
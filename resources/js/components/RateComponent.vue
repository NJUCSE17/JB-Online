<template>
    <div class="d-inline-flex">
        <span class="mr-3">
            <a v-bind:class="this.rated === 'dislike' ? 'text-danger' : 'text-muted'"
               href="#" @click.prevent="rate(false)">
                <i class="fas fa-heart-broken mr-1"></i> {{ this.stats.dislike }}
            </a>
        </span>
        <span>
            <a v-bind:class="this.rated === 'like' ? 'text-success' : 'text-muted'"
               href="#" @click.prevent="rate(true)">
                <i class="fas fa-heart mr-1"></i> {{ this.stats.like }}
            </a>
        </span>
    </div>
</template>

<script>
    export default {
        name: "RateComponent",
        props: ['_api', '_rated', '_stats'],
        data: function () {
            return {
                api: this._api,
                rated: this._rated,
                stats: this._stats,
            }
        },
        methods: {
            rate(like) {
                window.axios.post(this.api, {
                    'like': like
                }).then(res => {
                    console.log(res);
                    this.rated = res.data.rated;
                    this.stats = res.data.stats;
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>

<style scoped>

</style>
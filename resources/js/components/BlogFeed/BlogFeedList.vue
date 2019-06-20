<template>
    <div id="LatestBlogFeeds">
        <div id="LatestBlogFeedsControl">
            <p class="h3">最新博客</p>
        </div>
        <hr/>
        <div v-if="initializing">
            <div class="row">
                <div class="col text-center mb-3">
                    <div class="spinner spinner-border" role="status"></div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <p>{{ init_status }}</p>
                </div>
            </div>
        </div>
        <div v-else id="LatestBlogFeedsContent">
            <div v-if="!(feeds.length > 0)">
                <div class="row">
                    <div class="col text-center mb-3">
                        <i class="fas fa-book-open" style="font-size:150%;"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <p>没有博客</p>
                    </div>
                </div>
            </div>
            <div v-else-if="simple" id="LatestBlogFeedsSimpleList">
                <div v-for="feed in feeds" class="card card-stats mb-2">
                    <div class="card-body">
                        <div class="row flex-column flex-md-row align-items-center">
                            <div class="col ml-md-n2 text-center text-md-left">
                                <a v-bind:href="'/user/' + feed.user_id"
                                   class="h6 text-sm text-muted mb-0">
                                    {{ feed.user_name }} @ <span>{{ feed.published_at }}</span>
                                </a>
                                <a v-bind:href="'/blog/' + feed.id">
                                    <p class="card-text text-dark mt-3">
                                        {{ feed.title }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else id="LatestBlogFeedsDetailedList">
                <div v-for="feed in feeds" class="card mb-3 hover-shadow-lg">
                    <div class="card-body py-3">
                        <div class="row flex-column flex-md-row align-items-center">
                            <div class="col-auto">
                                <a v-bind:href="'/user/' + feed.user_id"
                                   class="avatar rounded-circle">
                                    <img v-bind:alt="feed.user_name" v-bind:src="feed.user_avatar" class="">
                                </a>
                            </div>
                            <div class="col ml-md-n2 text-center text-md-left">
                                <a v-bind:href="'/user/' + feed.user_id"
                                   class="h6 text-sm mb-0">
                                    {{ feed.user_name }}
                                    @ <span>{{ feed.published_at }}</span>
                                </a>
                                <p class="card-text text-muted mb-0">
                                    {{ feed.title }}
                                </p>
                            </div>
                            <hr class="divider divider-fade my-3 d-md-none">
                            <div class="col-12 col-md-auto d-flex justify-content-between align-items-center">
                                <a v-bind:href="'/blog/' + feed.id" class="btn btn-sm btn-secondary w-100">阅读</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BlogFeedList",
        props: ['simple', 'user_id', 'limit'],
        data: function () {
            return {
                initializing: true,
                init_status: '',
                api: '/api/blogFeed',
                feeds: [],
            }
        },
        computed: {
            params() {
                let ret = {};
                if (this.user_id) ret.user_id = this.user_id;
                if (this.limit) ret.limit = this.limit;
                return ret;
            }
        },
        created: function () {
            this.loadFeeds();
        },
        methods: {
            loadFeeds() {
                this.init_status = '正在获取最新博客...';
                window.axios.get(this.api, {
                    params: this.params,
                }).then(res => {
                    console.debug(res);
                    this.feeds = res.data;
                    for (let i = 0; i < this.feeds.length; ++i) {
                        this.feeds[i].published_at = window.Dayjs(this.feeds[i].published_at).format('YYYY-MM-DD HH:mm');
                    }
                }).catch(err => {
                    console.error(err);
                }).finally(() => {
                    console.log('Blog feeds loaded. (' + this.feeds.length + ' entries)');
                    this.initializing = false;
                    this.init_status = '';
                });
            }
        },
    }
</script>

<style scoped>

</style>
<template>
    <div class="card">
        <h3 class="card-header">
            {{ name }}
        </h3>
        <div class="card-body">
            {{ content }}
        </div>
        <div class="card-footer">
            <div class="d-inline-flex" v-if="type === 'public'">
                <span class="mr-3">
                    <a href="#" v-bind:class="{ 'text-dark': true }">
                        <i class="fas fa-heart-broken mr-1"></i> 0
                    </a>
                </span>
                <span>
                    <a href="#" v-bind:class="{ 'text-dark': true }">
                        <i class="fas fa-heart mr-1"></i> 0
                    </a>
                </span>
            </div>
            <span class="float-right">
                <a href="#" v-bind:class="this.ddlColor">
                    <div v-if="this.finished_at">
                        <i class="fas fa-check mr-1"></i>
                        <span><s>{{ due_time }} ({{ due_time_human }})</s></span>
                    </div>
                    <div v-else>
                        <i class="fas fa-times mr-1"></i>
                        <span>{{ due_time }} ({{ due_time_human }})</span>
                    </div>
                </a>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AssignmentComponent",
        props: ['type', 'api', 'name', 'content', 'due_time', 'due_time_human', 'finished_at'],
        computed: {
            ddlColor() {
                if (this.finished_at) {
                    return 'text-success';
                } else {
                    let now = new Date();
                    let due = new Date(this.due_time);
                    let nr_day = Math.floor((due - now) / (24 * 3600 * 1000));
                    if (nr_day > 5) {
                        return "text-dark";
                    } else if (nr_day > 3) {
                        return "text-info";
                    } else if (nr_day > 1) {
                        return "text-warning";
                    } else {
                        return "text-dark";
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>
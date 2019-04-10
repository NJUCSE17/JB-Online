<template>
    <div id="assignments">
        <div id="assignments-control">

        </div>
        <div id="assignments-content">
            <assignment-component
                    v-for="assignment in assignments"
                    v-bind="assignment"
                    :key="assignment.id"
                    @update="update"
                    @destroy="destroy"
                    @finish="finish"
                    @reset="reset"
            ></assignment-component>
        </div>
    </div>
</template>

<script>
    import AssignmentComponent from "./AssignmentComponent";
    export default {
        name: "AssignmentsCollectionComponent",
        components: {AssignmentComponent},
        props: ['assignments'],
        methods: {
            update() {
                this.mute = true;
            },
            destroy() {

            },
            finish() {

            },
            reset() {

            }
        }
    }
</script>

<style scoped>

</style>
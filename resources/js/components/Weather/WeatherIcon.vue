<template>
    <i v-if="code === '100'" class="fas mr-1 fa-sun"></i>
    <i v-else-if="code === '101'" class="fas mr-1 fa-clouds"></i>
    <i v-else-if="code === '102'" class="fas mr-1 fa-cloud"></i>
    <i v-else-if="code === '103'" class="fas mr-1 fa-cloud-sun"></i>
    <i v-else-if="code === '104'" class="fas mr-1 fa-clouds-sun"></i>
    <i v-else-if="code === '200'" class="fas mr-1 fa-wind"></i>
    <i v-else-if="code === '205'" class="fas mr-1 fa-windsock"></i>
    <i v-else-if="code === '300'" class="fas mr-1 fa-cloud-showers"></i>
    <i v-else-if="code === '301'" class="fas mr-1 fa-cloud-showers-heavy"></i>
    <i v-else-if="code === '302'" class="fas mr-1 fa-thunderstorm"></i>
    <i v-else-if="code === '303'" class="fas mr-1 fa-thunderstorm"></i>
    <i v-else-if="code === '305'" class="fas mr-1 fa-cloud-drizzle"></i>
    <i v-else-if="code === '306'" class="fas mr-1 fa-cloud-showers"></i>
    <i v-else-if="code === '307'" class="fas mr-1 fa-cloud-showers-heavy"></i>
    <i v-else-if="code === '308'" class="fas mr-1 fa-cloud-showers-heavy"></i>
    <i v-else-if="code === '309'" class="fas mr-1 fa-cloud-drizzle"></i>
    <i v-else-if="code === '310'" class="fas mr-1 fa-cloud-showers-heavy"></i>
    <i v-else-if="code === '399'" class="fas mr-1 fa-cloud-rain"></i>
    <i v-else-if="code === '400'" class="fas mr-1 fa-snowflake"></i>
    <i v-else-if="code === '401'" class="fas mr-1 fa-snowflake"></i>
    <i v-else-if="code === '402'" class="fas mr-1 fa-snowflake"></i>
    <i v-else-if="code === '403'" class="fas mr-1 fa-snowflake"></i>
    <i v-else-if="code === '404'" class="fas mr-1 fa-cloud-snow"></i>
    <i v-else-if="code === '405'" class="fas mr-1 fa-cloud-snow"></i>
    <i v-else-if="code === '406'" class="fas mr-1 fa-cloud-snow"></i>
    <i v-else-if="code === '499'" class="fas mr-1 fa-snowflake"></i>
    <i v-else class="fas mr-1 fa-question-square"></i>
</template>

<script>
    export default {
        name: "WeatherIcon",
        props: ['code'],
    }
</script>

<style scoped>

</style>

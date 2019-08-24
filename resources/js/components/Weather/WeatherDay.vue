<template>
    <div class="row text-center">
        <div class="col col-2">
            {{ weather_data.date.substr(8, 2) }}
        </div>
        <div class="col">
            <WeatherIcon
                :code="weather_data.cond_code_d"
            ></WeatherIcon>
            {{ weather_data.cond_txt_d }}
        </div>
        <div class="col">
            {{ weather_data.tmp_min }} - {{ weather_data.tmp_max }} ℃
        </div>
        <div class="col">
            <i class="fas mr-1 fa-raindrops"></i>
            {{ weather_data.pop }}%
        </div>
    </div>
</template>

<script>
    import WeatherIcon from "./WeatherIcon";
    export default {
        name: "WeatherDay",
        components: {WeatherIcon},
        props: ['weather_data'],
    }
</script>

<style scoped>

</style>

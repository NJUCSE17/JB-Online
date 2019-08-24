<template>
    <div id="WeatherVueMain">
        <div id="Weather">
            <div id="WeatherControl">
                <p class="h3">天气预报</p>
            </div>
            <hr/>
            <div v-if="isOK">
                <weather-day
                    v-for="forecast in forecasts"
                    :weather_data="forecast"
                ></weather-day>
                <div class="row mt-2">
                    <div class="col">
                        <p class="text-right text-muted">
                            <small>{{ basic.location }} - {{ updated.loc }}</small>
                        </p>
                    </div>
                </div>
            </div>
            <div v-else>
                <p>天气暂时不可用：{{ weather_data.status }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import WeatherDay from "./WeatherDay";
    export default {
        name: 'WeatherMain',
        components: {WeatherDay},
        props: ['weather_data'],
        computed: {
            isOK() {
                console.log(this.weather_data);
                return this.weather_data.status === 'ok';
            },
            basic() {
                if (!this.isOK) {
                    return null;
                } else {
                    return this.weather_data.basic;
                }
            },
            updated() {
                if (!this.isOK) {
                    return null;
                } else {
                    return this.weather_data.update;
                }
            },
            forecasts() {
                if (!this.isOK) {
                    return null;
                } else {
                    return this.weather_data.daily_forecast;
                }
            }
        },
        mounted() {
        }
    }
</script>

<style scoped>

</style>

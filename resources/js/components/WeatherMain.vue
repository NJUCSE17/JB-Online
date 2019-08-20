<template>
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
    <div v-else>
        <div>
            <img height="36px" width="36px"
                v-bind:alt="weather.cond_txt"
                v-bind:src="'https://cdn.heweather.com/cond_icon/' + weather.cond_code + '.png'">
            {{ basic.location }}：
            {{ weather.cond_txt }}
            {{ weather.tmp }}摄氏度
        </div>
    </div>
</template>

<script>
    export default {
        name: "WeatherMain",
        props: ['api_username', 'api_key', 'ip', 'location'],
        data() {
            return {
                initializing: true,
                init_status: '',
                instance: null,
                basic: null,
                weather: null,
            }
        },
        created() {
            this.init_status = '正在获取天气信息...';

            // We need to use a new axios instance to avoid XSRF-Preflight checking.
            this.instance = window.axios.create();
            this.instance.defaults.headers.common = {};
            this.instance.get('https://free-api.heweather.net/s6/weather/now', {
                params: {
                    lang: 'zh',
                    location: '45.77.19.2',
                    key: this.api_key,
                }
            }).then(res => {
                this.initializing = false;
                console.debug(res);
                this.basic = res.data.HeWeather6[0].basic;
                this.weather = res.data.HeWeather6[0].now;
            }).catch(err => {
                this.init_status = '哦哟，出错了';
                console.error(err);
            })
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>

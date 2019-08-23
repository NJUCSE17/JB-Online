<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class HeWeather
{
    protected const apiBase = "https://free-api.heweather.net/s6/weather/";

    /**
     * Get weather data from HeWeather, for valid types,
     * visit https://dev.heweather.com/docs/api/weather
     *
     * @param $type
     * @param $location
     * @return |null
     */
    public static function getWeather($type, $location)
    {
        $client = new Client([
            'base_uri' => self::apiBase,
        ]);
        $res = $client->get($type, [
            'query' => [
                'lang'     => 'zh',
                'location' => $location,
                'key'      => env('HEWEATHER_API_KEY', ''),
            ],
        ]);
        if ($res->getStatusCode() === 200) {
            $body = json_decode($res->getBody());
            return $body->HeWeather6[0];
        } else {
            return null;
        }
    }
}

<?php

namespace AndPhone\Weather\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class WeatherIndex extends Template
{
    private const WEATHER_API_URL = 'https://api.openweathermap.org/data/2.5/weather';
    private const API_KEY = '8a9098666dd5b49925ade9cd4154536f';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function getWeatherInfoIn(string $cityName): array
    {
        $curl = curl_init();

        try {
            $url = sprintf('%s?q=%s&appid=%s', self::WEATHER_API_URL, urlencode($cityName), self::API_KEY);

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
            ]);

            $result = curl_exec($curl);

            if ($result === false) {
                throw new \Exception('Curl error: ' . curl_error($curl));
            }

            $data = json_decode($result, true);

            if (!is_array($data)) {
                throw new \Exception('Error: Unable to decode API response.');
            }

            return [
                'name' => $data['name'] ?? 'Unknown',
                'main' => $data['weather'][0]['main'] ?? 'Unknown',
                'temp' => isset($data['main']['temp']) ? round($data['main']['temp'] - 273.15, 1) : 'N/A',
                'wind' => isset($data['wind']['speed']) ? round($data['wind']['speed'], 1) : 'N/A',
                'clouds' => $data['clouds']['all'] ?? 'N/A',
                'humidity' => $data['main']['humidity'] ?? 'N/A',
                'icon' => $data['weather'][0]['icon'] ?? 'N/A',
            ];
        } catch (\Exception $e) {
            return [
                'name' => 'Unknown',
                'main' => 'Unknown',
                'temp' => 'N/A',
                'wind' => 'N/A',
                'clouds' => 'N/A',
                'humidity' => 'N/A',
                'icon' => 'N/A',
            ];
        } finally {
            curl_close($curl);
        }
    }
}

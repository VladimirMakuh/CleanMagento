<?php

declare(strict_types=1);

namespace Elogic\Internship\Model;

use Elogic\Internship\Api\GeoCodeInterface;
use GuzzleHttp\Client;

class GeoCode implements GeoCodeInterface
{
    private ConfigProvider $configProvider;

    /**
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        ConfigProvider $configProvider
    ){
        $this->configProvider = $configProvider;
    }

    /**
     * @param string $address
     * @return array|string
     * @throws \JsonException
     */
    public function getCoordinates(string $address)
    {
        $apiKey = $this->configProvider->getGoogleMapsApiKey();

        $client = new Client();
        $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json?address=' .
            urlencode($address) . '&key=' . $apiKey);
        $geo = json_decode((string)$response->getBody(), false, 512, JSON_THROW_ON_ERROR);

        if (strpos($geo->status, 'error_message')) {
            $coordinates = 'ErrorApi';
        }
        if (strpos($geo->status, 'ZERO') === 0) {
            $coordinates[0] = '0';
            $coordinates[1] = '0';
        }
        else if (isset($geo->status) && ($geo->status === 'OK')) {
            $coordinates[0] = $geo->results[0]->geometry->location->lat;
            $coordinates[1] = $geo->results[0]->geometry->location->lng;
        }
        return $coordinates;
    }
}

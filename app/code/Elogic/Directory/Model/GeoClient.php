<?php
declare(strict_types=1);

namespace Elogic\Directory\Model;

use GuzzleHttp\Client;

class GeoClient implements \Elogic\Directory\Api\ClientInterface
{

    /**
     * Test connection to GeoDB
     * @param string $apiKey
     * @param string $apiHost
     * @return bool
     */
    public function testConnection(string $apiKey, string $apiHost): bool
    {
        $client = new Client([
            'base_uri' => 'https://wft-geo-db.p.rapidapi.com/v1/',
            'headers' => [
                'x-rapidapi-key' =>  $apiKey,
                'x-rapidapi-host' => $apiHost
            ]
        ]);

        $response = $client->get('geo/cities');

        return $response->getStatusCode() === 200;
    }
}

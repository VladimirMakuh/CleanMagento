<?php
declare(strict_types=1);

namespace Elogic\Directory\Api;

interface ClientInterface
{
    /**
     * Perform a request to API
     *
     * @param string $apiKey
     * @param string $apiHost
     * @return bool
     */
    public function testConnection(string $apiKey, string $apiHost): bool;
}

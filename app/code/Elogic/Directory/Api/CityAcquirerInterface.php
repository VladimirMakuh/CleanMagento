<?php
declare(strict_types=1);

namespace Elogic\Directory\Api;

/**
 * City acquirer interface
 */
interface CityAcquirerInterface
{
    /**
     * Get cities, by country code.
     * @param string $countryCode
     * @return array
     */
    public function getCitiesByCountryCode(string $countryCode): ?array;

    /**
     * Check if city unique
     * @param string $city
     * @return bool
     */
    public function checkUniqueCity(string $city): bool;
}

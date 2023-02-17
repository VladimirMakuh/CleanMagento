<?php
declare(strict_types=1);

namespace Elogic\Directory\Api;

use Elogic\Directory\Api\Data\CityInterface;

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
}

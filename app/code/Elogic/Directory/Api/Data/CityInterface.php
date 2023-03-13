<?php

declare(strict_types=1);

namespace Elogic\Directory\Api\Data;

interface CityInterface
{
    /**
     * Constants defined for keys of the data array.
     */
    public const CITY_ID        = "city_id";
    public const COUNTRY        = "country";
    public const CITY           = "city";
    public const ISO2_CODE      = "iso2_code";
    public const ISO3_CODE      = "iso3_code";

    /**
     * @return int|null
     */
    public function getCityId(): ?int;

    /**
     * @param int $cityId
     * @return void
     */
    public function setCityId(int $cityId): void;

    /**
     * @return string|null
     */
    public function getCountry(): ?string;

    /**
     * @param string $country
     * @return void
     */
    public function setCountry(string $country): void;

    /**
     * @return string|null
     */
    public function getCity(): ?string;

    /**
     * @param string $name
     * @return void
     */
    public function setCity(string $name): void;

    /**
     * @return string|null
     */
    public function getIso2Code(): ?string;

    /**
     * @param string $iso2Code
     * @return void
     */
    public function setIso2Code(string $iso2Code): void;

    /**
     * @return string|null
     */
    public function getIso3Code(): ?string;

    /**
     * @param string $iso3Code
     * @return void
     */
    public function setIso3Code(string $iso3Code): void;
}

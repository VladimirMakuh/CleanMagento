<?php
declare(strict_types=1);

namespace Elogic\Directory\Model;

use Elogic\Directory\Api\Data\CityInterface;
use Elogic\Directory\Model\ResourceModel\CityResource as ResorceModel;
use Magento\Framework\Model\AbstractModel;

class City extends AbstractModel implements CityInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResorceModel::class);
    }

    /**
     * @return int|null
     */
    public function getCityId(): ?int
    {
        return $this->getData(self::CITY_ID) === null ? null
            : (int)$this->getData(self::CITY_ID);
    }

    /**
     * @param int $cityId
     * @return void
     */
    public function setCityId(int $cityId): void
    {
        $this->setData(self::CITY_ID, $cityId);
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * @param string $country
     * @return void
     */
    public function setCountry(string $country): void
    {
        $this->setData(self::COUNTRY, $country);
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->getData(self::CITY);
    }

    /**
     * @param string $name
     * @return void
     */
    public function setCity(string $name): void
    {
        $this->setData(self::CITY, $name);
    }

    /**
     * @return string|null
     */
    public function getIso2Code(): ?string
    {
        return $this->getData(self::ISO2_CODE);
    }

    /**
     * @param string $iso2Code
     * @return void
     */
    public function setIso2Code(string $iso2Code): void
    {
        $this->setData(self::ISO2_CODE, $iso2Code);
    }

    /**
     * @return string|null
     */
    public function getIso3Code(): ?string
    {
        return $this->getData(self::ISO3_CODE);
    }

    /**
     * @param string $iso3Code
     * @return void
     */
    public function setIso3Code(string $iso3Code): void
    {
        $this->setData(self::ISO2_CODE, $iso3Code);
    }
}

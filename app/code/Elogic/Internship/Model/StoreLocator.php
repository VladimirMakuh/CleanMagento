<?php

declare(strict_types=1);

namespace Elogic\Internship\Model;

use Elogic\Internship\Api\Data\StoreLocatorInterface;
use Elogic\Internship\Model\ResourceModel\StoreLocator as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class StoreLocator extends AbstractModel implements StoreLocatorInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @param int $store_entity_id
     * @return StoreLocatorInterface
     */
    public function setId($store_entity_id): StoreLocatorInterface
    {
        $this->setData(self::STORE_ID, $store_entity_id);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::STORE_NAME);
    }

    /**
     * @param string $store_name
     * @return StoreLocatorInterface
     */
    public function setName(string $store_name): StoreLocatorInterface
    {
        $this->setData(self::STORE_NAME, $store_name);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->getData(self::STORE_IMAGE);
    }

    /**
     * @param string|array $store_image
     * @return StoreLocatorInterface
     */
    public function setImage($store_image): StoreLocatorInterface
    {
        $this->setData(self::STORE_IMAGE, $store_image);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSchedule(): ?string
    {
        return $this->getData(self::STORE_SCHEDULE);
    }

    /**
     * @param string $store_schedule
     * @return StoreLocatorInterface
     */
    public function setSchedule(string $store_schedule): StoreLocatorInterface
    {
        $this->setData(self::STORE_SCHEDULE, $store_schedule);
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->getData(self::STORE_ADDRESS);
    }

    /**
     * @param string $store_address
     * @return StoreLocatorInterface
     */
    public function setAddress(string $store_address): StoreLocatorInterface
    {
        $this->setData(self::STORE_ADDRESS, $store_address);
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData(self::STORE_DESCRIPTION);
    }

    /**
     * @param string $store_description
     * @return StoreLocatorInterface
     */
    public function setDescription(string $store_description): StoreLocatorInterface
    {
        $this->setData(self::STORE_DESCRIPTION, $store_description);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->getData(self::STORE_LATITUDE);
    }

    /**
     * @param string $store_latitude
     * @return StoreLocatorInterface
     */
    public function setLatitude(string $store_latitude): StoreLocatorInterface
    {
        $this->setData(self::STORE_LATITUDE, $store_latitude);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->getData(self::STORE_LONGITUDE);
    }

    /**
     * @param string $store_longitude
     * @return StoreLocatorInterface
     */
    public function setLongitude(string $store_longitude): StoreLocatorInterface
    {
        $this->setData(self::STORE_LONGITUDE, $store_longitude);
        return $this;
    }

    /**
     * @param string $store_url_key
     * @return StoreLocatorInterface
     */
    public function setUrl(string $store_url_key): StoreLocatorInterface
    {
       $this->setData(self::STORE_URL_KEY, $store_url_key);
       return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->getData(self::STORE_URL_KEY);
    }

}


/**
 * Test commit
 */

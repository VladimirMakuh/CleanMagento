<?php

declare(strict_types=1);

namespace Elogic\Internship\Api\Data;

interface  StoreLocatorInterface
{
    /**
     * Constants defined for keys of the data array.
     */
    public const STORE_ID                          = 'store_entity_id';
    public const STORE_NAME                        = 'name';
    public const STORE_DESCRIPTION                 = 'description';
    public const STORE_IMAGE                       = 'image';
    public const STORE_ADDRESS                     = 'address';
    public const STORE_SCHEDULE                    = 'schedule';
    public const STORE_LONGITUDE                   = 'longitude';
    public const STORE_LATITUDE                    = 'latitude';
    public const STORE_URL_KEY                     = 'store_url_key';

    /**
     * @return int|string
     */
    public function getId();

    /**
     * @param int $store_id
     * @return StoreLocatorInterface
     */
    public function setId(int $store_id): StoreLocatorInterface;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $store_name
     * @return StoreLocatorInterface
     */
    public function setName(string $store_name): StoreLocatorInterface;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string $store_description
     * @return StoreLocatorInterface
     */
    public function setDescription(string $store_description): StoreLocatorInterface;

    /**
     * @return string|array|null
     */
    public function getImage(): ?string;

    /**
     * @param string|array $store_image
     * @return StoreLocatorInterface
     */
    public function setImage($store_image): StoreLocatorInterface;

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @param string $store_address
     * @return StoreLocatorInterface
     */
    public function setAddress(string $store_address): StoreLocatorInterface;

    /**
     * @return string|null
     */
    public function getSchedule(): ?string;

    /**
     * @param string $store_schedule
     * @return StoreLocatorInterface
     */
    public function setSchedule(string $store_schedule): StoreLocatorInterface;

    /**
     * @return string|null
     */
    public function getLongitude(): ?string;

    /**
     * @param string $store_longitude
     * @return StoreLocatorInterface
     */
    public function setLongitude(string $store_longitude): StoreLocatorInterface;

    /**
     * @return string|null
     */
    public function getLatitude(): ?string;

    /**
     * @param string $store_latitude
     * @return StoreLocatorInterface
     */
    public function setLatitude(string $store_latitude): StoreLocatorInterface;

    /**
     * @param string $store_url_key
     * @return StoreLocatorInterface
     */
    public function setUrl(string $store_url_key): StoreLocatorInterface;

    /**
     * @return string|null
     */
    public function getUrl() :?string;
}

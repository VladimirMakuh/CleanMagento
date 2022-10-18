<?php

declare(strict_types=1);

namespace Elogic\Internship\Observer;

use Elogic\Internship\Api\GeoCodeInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveCoordinates implements ObserverInterface
{

    /**
     * @var GeoCodeInterface
     */
    private GeoCodeInterface $geoCode;

    /**
     * @param GeoCodeInterface $geoCode
     */
    public function __construct(
        GeoCodeInterface $geoCode
    ){
        $this->geoCode = $geoCode;
    }


    /**
     * @param Observer $observer
     * @return array|mixed|void|null
     * @throws \JsonException
     */
    public function execute(Observer $observer)
    {
        $store = $observer->getData('store');
        $data = $store->getData();

        if (!empty($data['longitude']) && !empty($data['latitude'])) {
            return $store;
        }
        $coordinates = $this->geoCode->getCoordinates($store->getAddress());
        $store->setLatitude((string)$coordinates[1]);
        $store->setLongitude((string)$coordinates[0]);
        return $store;
    }
}

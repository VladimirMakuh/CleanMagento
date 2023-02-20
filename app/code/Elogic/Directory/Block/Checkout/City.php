<?php
declare(strict_types=1);

namespace Elogic\Directory\Block\Checkout;

use Elogic\Directory\Api\Data\CityInterface;
use Elogic\Directory\Model\ResourceModel\City\Collection;
use Elogic\Directory\Model\Config\CityConfigProvider;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Serialize\SerializerInterface;

class City extends Template
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var Collection
     */
    private Collection $collection;
    /**
     * @var CityConfigProvider
     */
    private CityConfigProvider $config;

    /**
     * @param Context $context
     * @param SerializerInterface $serialize
     * @param Collection $collection
     * @param CityConfigProvider $configProvider
     * @param array $data
     */
    public function __construct(
        Template\Context         $context,
        SerializerInterface      $serialize,
        Collection               $collection,
        CityConfigProvider       $configProvider,
        array                    $data = []
    ){
        $this->serializer = $serialize;
        $this->collection = $collection;
        $this->config = $configProvider;
        parent::__construct($context, $data);
    }

    /**
     * Get cities for customer address form
     * @return bool|string
     */
    public function getCities()
    {
        if(!$this->config->isEnableDropdown())
        {
            $return [] = ['enable' => 0];
            return $this->serializer->serialize($return);
        }

        $items = $this->collection->getItems();
        $return = [];

        /** @var CityInterface $item */
        foreach ($items as $item) {
            $return[] = ['country_id' => $item->getIso2Code(), 'city_name' => $item->getCity()];
        }
        asort($return);

        return $this->serializer->serialize($return);
    }
}

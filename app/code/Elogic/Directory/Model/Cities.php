<?php
declare(strict_types=1);

namespace Elogic\Directory\Model;

use Elogic\Directory\Api\Data\CityInterface;
use Elogic\Directory\Model\Config\CityConfigProvider;
use Elogic\Directory\Model\ResourceModel\City\Collection;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Cities implements ConfigProviderInterface
{
    /**
     * @var Collection
     */
    private Collection $collection;
    /**
     * @var CityConfigProvider
     */
    private CityConfigProvider $config;

    /**
     * @param Collection $collection
     * @param SerializerInterface $serializer
     * @param CityConfigProvider $configProvider
     */
    public function __construct(
        Collection              $collection,
        SerializerInterface     $serializer,
        CityConfigProvider      $configProvider
    ){
        $this->collection = $collection;
        $this->serializer = $serializer;
        $this->config =     $configProvider;
    }

    /**
     * @return bool[]|string[]
     */
    public function getConfig(): array
    {
        return  [
            'cities' => $this->getCities()
        ];
    }

    /**
     * Get cities for checkout city dropdown
     * @return bool|string
     */
    private function getCities()
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
            $return[$item->getIso2Code()][] = $item->getCity();
        }

        return $this->serializer->serialize($return);
    }
}

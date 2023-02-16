<?php
declare(strict_types=1);

namespace Elogic\Directory\Mapper;

use Elogic\Directory\Api\Data\CityInterface;
use Elogic\Directory\Api\Data\CityInterfaceFactory;
use Elogic\Directory\Model\City;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of City entities to an array of data transfer objects.
 */
class CityDataMapper
{
    /**
     * @var CityInterfaceFactory
     */
    private CityInterfaceFactory $entityDtoFactory;

    /**
     * @param CityInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        CityInterfaceFactory $entityDtoFactory
    ){
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|CityInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var City $item */
        foreach ($collection->getItems() as $item) {
            /** @var CityInterfaceFactory|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }
        return $results;
    }
}

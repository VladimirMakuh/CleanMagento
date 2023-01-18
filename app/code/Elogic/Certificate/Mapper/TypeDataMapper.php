<?php

namespace Elogic\Certificate\Mapper;

use Elogic\Certificate\Api\Data\TypeInterface;
use Elogic\Certificate\Api\Data\TypeInterfaceFactory;
use Elogic\Certificate\Model\Type;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of Type entities to an array of data transfer objects.
 */
class TypeDataMapper
{
    /**
     * @var TypeInterfaceFactory
     */
    private TypeInterfaceFactory $entityDtoFactory;

    /**
     * @param TypeInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        TypeInterfaceFactory $entityDtoFactory
    ){
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|TypeInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var Type $item */
        foreach ($collection->getItems() as $item) {
            /** @var TypeInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }
        return $results;
    }
}

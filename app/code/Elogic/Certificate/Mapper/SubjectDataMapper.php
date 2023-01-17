<?php

namespace Elogic\Certificate\Mapper;

use Elogic\Certificate\Api\Data\SubjectInterface;
use Elogic\Certificate\Api\Data\SubjectInterfaceFactory;
use Elogic\Certificate\Model\Subject;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of Subject entities to an array of data transfer objects.
 */
class SubjectDataMapper
{
    /**
     * @var SubjectInterfaceFactory
     */
    private SubjectInterfaceFactory $entityDtoFactory;

    /**
     * @param SubjectInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        SubjectInterfaceFactory $entityDtoFactory
    ){
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|SubjectInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var Subject $item */
        foreach ($collection->getItems() as $item) {
            /** @var SubjectInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}

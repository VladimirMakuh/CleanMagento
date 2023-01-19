<?php
declare(strict_types=1);

namespace Elogic\Certificate\Mapper;

use Elogic\Certificate\Api\Data\CertificateInterface;
use Elogic\Certificate\Api\Data\CertificateInterfaceFactory;
use Elogic\Certificate\Model\Certificate;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of Certificate entities to an array of data transfer objects.
 */
class CertificateDataMapper
{
    /**
     * @var CertificateInterfaceFactory
     */
    private CertificateInterfaceFactory $entityDtoFactory;

    /**
     * @param CertificateInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        CertificateInterfaceFactory $entityDtoFactory
    ){
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|CertificateInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var Certificate $item */
        foreach ($collection->getItems() as $item) {
            /** @var CertificateInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }
        return $results;
    }
}

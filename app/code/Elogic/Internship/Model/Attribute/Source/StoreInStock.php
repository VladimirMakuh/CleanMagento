<?php
declare(strict_types=1);

namespace Elogic\Internship\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Elogic\Internship\Model\ResourceModel\StoreLocator\CollectionFactory;

class StoreInStock extends AbstractSource
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions(): array
    {
        $collection = $this->collectionFactory->create();

        foreach ($collection->getItems() as $store) {
            $this->_options [] = [
                'value' => $store->getId(), 'label' => __($store->getName())
            ];
        }
        return $this->_options;
    }
}

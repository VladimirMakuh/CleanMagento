<?php

declare(strict_types=1);

namespace Elogic\Internship\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Elogic\Internship\Api\StoreLocatorRepositoryInterface;

class ProductStoreStockViewModel implements ArgumentInterface
{
    /**
     * @var StoreLocatorRepositoryInterface
     */
    private StoreLocatorRepositoryInterface $storeLocatorRepository;

    /**
     * @param StoreLocatorRepositoryInterface $storeLocatorRepository
     */
    public function __construct(
        StoreLocatorRepositoryInterface $storeLocatorRepository
    ) {
        $this->storeLocatorRepository = $storeLocatorRepository;
    }

    /**
     * @param $storeId
     * @return string|null
     */
    public function getStoreNameById($storeId)
    {
        return $this->storeLocatorRepository->getById($storeId)->getName();
    }
}

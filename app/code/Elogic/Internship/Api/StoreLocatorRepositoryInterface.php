<?php

declare(strict_types=1);

namespace Elogic\Internship\Api;

use Elogic\Internship\Api\Data\StoreLocatorInterface;
use Elogic\Internship\Api\Data\StoreLocatorSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface StoreLocatorRepositoryInterface
{
    /**
     * @param StoreLocatorInterface $store
     * @return StoreLocatorInterface
     */
    public function save(StoreLocatorInterface $store): StoreLocatorInterface;

    /**
     * @param StoreLocatorInterface $store
     * @return void
     */
    public function delete(StoreLocatorInterface $store): void;

    /**
     * @param int $store_id
     * @return void
     */
    public function deleteById(int $store_id): void;

    /**
     * @param int $store_id
     * @return StoreLocatorInterface
     */
    public function getById(int $store_id): StoreLocatorInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreLocatorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): StoreLocatorSearchResultInterface;
}

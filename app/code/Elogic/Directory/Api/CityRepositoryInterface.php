<?php
declare(strict_types=1);

namespace Elogic\Directory\Api;

use Elogic\Directory\Api\Data\CityInterface;
use Elogic\Directory\Api\Data\CitySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CityRepositoryInterface
{
    /**
     * @param CityInterface $city
     * @return CityInterface
     */
    public function save(CityInterface $city): CityInterface;

    /**
     * @param CityInterface $city
     * @return void
     */
    public function delete(CityInterface $city): void;

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void;

    /**
     * @param int $id
     * @return CityInterface
     */
    public function getById(int $id): CityInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CitySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CitySearchResultsInterface;
}

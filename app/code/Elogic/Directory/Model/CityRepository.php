<?php
declare(strict_types=1);

namespace Elogic\Directory\Model;

use Elogic\Directory\Api\CityRepositoryInterface;
use Elogic\Directory\Api\Data\CityInterface;
use Elogic\Directory\Api\Data\CityInterfaceFactory;
use Elogic\Directory\Api\Data\CitySearchResultsInterface;
use Elogic\Directory\Api\Data\CitySearchResultsInterfaceFactory;
use Elogic\Directory\Model\ResourceModel\City\CollectionFactory;
use Elogic\Directory\Model\ResourceModel\CityResource as Resource;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class CityRepository implements CityRepositoryInterface
{
    /**
     * @var CityInterfaceFactory
     */
    private CityInterfaceFactory $cityFactory;
    /**
     * @var Resource
     */
    private Resource $cityResource;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;
    /**
     * @var CitySearchResultsInterfaceFactory
     */
    private CitySearchResultsInterfaceFactory $searchResultFactory;

    public function __construct(
        CityInterfaceFactory            $cityFactory,
        Resource                        $resource,
        CollectionFactory               $collection,
        CollectionProcessorInterface    $collectionProcessor,
        CitySearchResultsInterfaceFactory      $citySearchResults
    ){
        $this->cityFactory = $cityFactory;
        $this->cityResource = $resource;
        $this->collectionFactory = $collection;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $citySearchResults;
    }

    /**
     * @inheritDoc
     */
    public function save(CityInterface $city): CityInterface
    {
        $this->cityResource->save($city);
        return $city;
    }

    /**
     * @inheritDoc
     */
    public function delete(CityInterface $city): void
    {
        $this->cityResource->delete($city);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteById(int $id): void
    {
       $city = $this->getById($id);
       $this->cityResource->delete($city);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): CityInterface
    {
        $city = $this->cityFactory->create();
        $this->cityResource->load($city, $id);
        return $city;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CitySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CitySearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}

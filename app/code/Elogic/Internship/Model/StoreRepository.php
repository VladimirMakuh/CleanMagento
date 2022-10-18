<?php

declare(strict_types=1);

namespace Elogic\Internship\Model;

use Elogic\Internship\Api\Data\StoreLocatorInterface;
use Elogic\Internship\Api\Data\StoreLocatorInterfaceFactory;
use Elogic\Internship\Api\Data\StoreLocatorSearchResultInterface;
use Elogic\Internship\Api\Data\StoreLocatorSearchResultInterfaceFactory;
use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Elogic\Internship\Model\ResourceModel\StoreLocator as Resource;
use Elogic\Internship\Model\ResourceModel\StoreLocator\CollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\AlreadyExistsException;

class StoreRepository implements StoreLocatorRepositoryInterface
{
    /**
     * @var StoreLocatorInterfaceFactory
     */
    private StoreLocatorInterfaceFactory $storeFactory;
    /**
     * @var Resource
     */
    private Resource $storeResource;

    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var StoreLocatorSearchResultInterfaceFactory
     */
    private StoreLocatorSearchResultInterfaceFactory $searchResultFactory;

    /**
     * @param StoreLocatorInterfaceFactory $storeFactory
     * @param Resource $storeResource
     * @param EventManager $eventManager
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param StoreLocatorSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        StoreLocatorInterfaceFactory             $storeFactory,
        Resource                                 $storeResource,
        EventManager                             $eventManager,
        CollectionFactory                        $collectionFactory,
        CollectionProcessorInterface             $collectionProcessor,
        StoreLocatorSearchResultInterfaceFactory $searchResultFactory
    ){
        $this->eventManager = $eventManager;
        $this->storeFactory = $storeFactory;
        $this->storeResource = $storeResource;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @param StoreLocatorInterface $store
     * @return StoreLocatorInterface
     * @throws AlreadyExistsException
     */
    public function save(StoreLocatorInterface $store): StoreLocatorInterface
    {
        $this->eventManager->dispatch('internship_storelocator_save', ['store' => $store]);
        $this->storeResource->save($store);
        return $store;
    }

    /**
     * @param int $store_id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $store_id): void
    {
        $store = $this->getById($store_id);
        $this->delete($store);
    }

    /**
     * @param int $store_id
     * @return string|StoreLocatorInterface $store
     */
    public function getById(int $store_id): StoreLocatorInterface
    {
        $store = $this->storeFactory->create();
        $this->storeResource->load($store, $store_id);
        return $store;
    }

    /**
     * @param StoreLocatorInterface $store
     * @return void
     * @throws Exception
     */
    public function delete(StoreLocatorInterface $store): void
    {
        $this->storeResource->delete($store);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreLocatorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): StoreLocatorSearchResultInterface
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

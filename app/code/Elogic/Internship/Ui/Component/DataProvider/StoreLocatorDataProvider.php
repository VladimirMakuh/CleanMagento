<?php

declare(strict_types=1);

namespace Elogic\Internship\Ui\Component\DataProvider;

use Elogic\Internship\Model\ResourceModel\StoreLocator\Collection;
use Elogic\Internship\Model\ResourceModel\StoreLocator\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class StoreLocatorDataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * @var Collection
     */
    protected Collection $collection;
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var array
     */
    private array $loadedData = [];
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ){
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(): array
    {
        $collection = $this->collectionFactory->create();
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        foreach ($collection->getItems() as $store) {
            if ($store->getImage()) {
                $store->setImage([
                    [
                        'name' => $store->getImage(),
                        'url' => $mediaUrl . 'elogic/base_path/' . $store->getImage()
                    ]
                ]);
            }
            $this->loadedData[$store->getId()] = $store->getData();
        }
        return $this->loadedData;
    }
}

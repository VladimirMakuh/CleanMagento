<?php

declare(strict_types=1);

namespace Elogic\Internship\Ui\Component;

use Elogic\Internship\Model\ResourceModel\StoreLocator\Collection;
use Elogic\Internship\Model\ResourceModel\StoreLocator\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\Serialize\Serializer\Json;

class StoreLocatorFormDataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private array $loadedData = [];

    private StoreManagerInterface $storeManager;
    private RequestInterface $request;
    private Json $json;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param RequestInterface $request
     * @param Json $json
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        RequestInterface $request,
        Json $json,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->json= $json;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
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
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $storeId = $this->request->getParam('store_entity_id', 0);
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        foreach ($this->collection->getItems() as $store) {
            if ($store->getImage()) {
                $store->setImage([
                    [
                        'name' => $store->getImage(),
                        'url' => $mediaUrl . 'elogic/base_path/' . $store->getImage()
                    ]
                ]);
            }
            $this->loadedData[$storeId] = $store->getData();
            if ($this->loadedData[$storeId]['schedule'] !== "") {
                $this->loadedData[$storeId]['schedule'] = $this->json->unserialize($this->loadedData[$storeId]['schedule']);
            } else {
                return $this->loadedData;
            }
        }
        return $this->loadedData;
    }
}

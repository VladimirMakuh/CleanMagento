<?php

declare(strict_types=1);

namespace Elogic\Internship\Block;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class Store extends Template
{
    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @param Context $context
     * @param Json $json
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context               $context,
        Json                  $json,
        StoreManagerInterface $storeManager
    ){
        $this->storeManager = $storeManager;
        $this->json = $json;
        parent::__construct($context);
    }

    /**
     * @return mixed|null
     */
    public function getStore()
    {
        $store = $this->getRequest()->getParams();
        if (is_null($store)) {
            return null;
        }
        return $store['store'];
    }

    /**
     * @param $store
     * @return array|bool|float|int|mixed|string|null
     */
    public function unserializeSchedule($store)
    {
        return $this->json->unserialize($store->getSchedule());
    }

    /**
     * @param $path
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl($path): string
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $path;
    }
}
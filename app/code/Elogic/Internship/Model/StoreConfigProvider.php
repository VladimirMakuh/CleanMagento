<?php

declare(strict_types=1);

namespace Elogic\Internship\Model;

use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session\Proxy;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class StoreConfigProvider implements ConfigProviderInterface
{
    /**
     * @var ProductRepository
     */
    protected ProductRepository $_productRepository;
    /**
     * @var Proxy
     */
    private Proxy $cartSession;
    /**
     * @var StoreLocatorRepositoryInterface
     */
    private StoreLocatorRepositoryInterface $storeRepository;

    /**
     * @param Proxy $cartSession
     * @param ProductRepository $productRepository
     * @param StoreLocatorRepositoryInterface $storeRepository
     */
    public function __construct(
        Proxy                           $cartSession,
        ProductRepository               $productRepository,
        StoreLocatorRepositoryInterface $storeRepository
    ) {
        $this->cartSession = $cartSession;
        $this->_productRepository = $productRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getConfig(): array
    {
        $config = [];
        $storeList = [];

        // get product from cart
        $cartItems = $this->cartSession->getQuote()->getItems();

        foreach ($cartItems as $cartItem) {
            //get all data about product
            $product = $this->_productRepository->getById($cartItem->getProductId());
            //get attribute data
            if ($product->getData('store_in_stock') !== null) {
                $store = $product->getData('store_in_stock');
                $storeList = explode(",", $store);

                $config [] =
                    [
                        'productName' => $product->getName(),
                        'productId' => $product->getId(),
                        'values' => $this->getValueFromStoreList($storeList, $this)
                    ];
            }
        }

        if (empty($config)) {
            return [
                'storeStock' => ""
            ];
        }


        return [
            'storeStock' =>
                $config
        ];
    }

    /**
     * @param $storeList
     * @param $object
     * @return array|string[]
     */
    public function getValueFromStoreList($storeList, $object): array
    {
        if (!$storeList) {
            return [""];
        }

        $value = [];

        foreach ($storeList as $store) {
            $value [] = [
                    'storeId' => $object->storeRepository->getById((int)$store)->getId(),
                    'storeName' => $object->storeRepository->getById((int)$store)->getName()
            ];
        }
        return $value;
    }
}

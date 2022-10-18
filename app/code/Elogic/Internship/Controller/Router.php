<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller;

use Elogic\Internship\Api\Data\StoreLocatorInterfaceFactory;
use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Elogic\Internship\Model\ResourceModel\StoreLocator;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private ActionFactory $actionFactory;
    /**
     * @var StoreLocatorInterfaceFactory
     */
    private StoreLocatorInterfaceFactory $storeLocatorInterfaceFactory;
    /**
     * @var StoreLocatorRepositoryInterface
     */
    private StoreLocatorRepositoryInterface $storeRepository;
    /**
     * @var StoreLocator
     */
    private StoreLocator $storeResource;

    /**
     * @param ActionFactory $actionFactory
     * @param StoreLocatorInterfaceFactory $storeLocatorInterfaceFactory
     * @param StoreLocatorRepositoryInterface $storeRepository
     * @param StoreLocator $storeResource
     */
    public function __construct(
        ActionFactory                   $actionFactory,
        StoreLocatorInterfaceFactory    $storeLocatorInterfaceFactory,
        StoreLocatorRepositoryInterface $storeRepository,
        StoreLocator                    $storeResource
    ){
        $this->actionFactory = $actionFactory;
        $this->storeLocatorInterfaceFactory = $storeLocatorInterfaceFactory;
        $this->storeRepository = $storeRepository;
        $this->storeResource = $storeResource;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request): ActionInterface
    {
        $urlKey = trim($request->getPathInfo(), '/');
        $url = explode('/', $urlKey);

        if (strpos($urlKey, 'storess') !== false) {
            $request->setModuleName('storess');
            $request->setControllerName('index');
            $request->setActionName('index');

            if (isset($url[1])) {
                $store = $this->storeLocatorInterfaceFactory->create();
                $storeId = $this->storeResource->checkUrlKeys($url[1]);
                if (!is_null($storeId)) {
                    $store = $this->storeRepository->getById((int)$storeId);
                }
                $request->setParams([
                    'store' => $store,
                ]);
            } else {
                return $this->actionFactory->create(Forward::class);
            }
        }
        return $this->actionFactory->create(Forward::class, ['request' => $request]);
    }
}
<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\Action\Forward;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private ActionFactory $actionFactory;

    /**
     * @param ActionFactory $actionFactory
     */
    public function __construct(
        ActionFactory $actionFactory
    ){
        $this->actionFactory = $actionFactory;
    }

    /**
     * @inheritDoc
     */
    public function match(RequestInterface $request)
    {
        $result = null;

        if ($request->getModuleName() != 'certificate' && $this->validateRoute($request)) {
            $request->setModuleName('certificate')
                ->setControllerName('certificate')
                ->setActionName('index')
                ->setParam('param', 3);
            $result = $this->actionFactory->create(Forward::class);
        }
        return $result;
    }

    private function validateRoute(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        return strpos($identifier, 'certificate') !== false;
    }
}

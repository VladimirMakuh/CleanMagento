<?php
declare(strict_types=1);

namespace Elogic\NovaPoshta\Controller\Checkout;

use Elogic\NovaPoshta\Model\WriteConfig;
use Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Elogic\NovaPoshta\Helper\ConfigCache;

class SetShippingPrice extends Action
{
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonResultFactory;
    /**
     * @var WriteConfig
     */
    private WriteConfig $writeConfig;
    /**
     * @var ConfigCache
     */
    private ConfigCache $configCache;

    /**
     * @param JsonFactory $jsonFactory
     * @param Context $context
     * @param WriteConfig $writeConfig
     * @param ConfigCache $configCache
     */
    public function __construct(
        JsonFactory $jsonFactory,
        Context $context,
        WriteConfig $writeConfig,
        ConfigCache $configCache
    ){
        parent::__construct($context);

        $this->configCache = $configCache;
        $this->jsonResultFactory = $jsonFactory;
        $this->writeConfig = $writeConfig;
    }

    public function execute()
    {
        $result = $this->jsonResultFactory->create();
        $params = $this->getRequest()->getParams();

        $price = $params['price'];

        $this->writeConfig->setPrice('carriers/novaposhta/price',$price);
        $this->configCache->flushCache();

        $output = ['price' => $price];

        return $result->setData($output);
    }
}

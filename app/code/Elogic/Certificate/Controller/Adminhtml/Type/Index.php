<?php

namespace Elogic\Certificate\Controller\Adminhtml\Type;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends Action
{
    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage =  $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu("Elogic_Certificate::certificate");
        $resultPage->getConfig()->getTitle()->set("Type");
        return $resultPage;
    }
}

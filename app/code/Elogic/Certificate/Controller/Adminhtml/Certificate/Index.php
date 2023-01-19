<?php

namespace Elogic\Certificate\Controller\Adminhtml\Certificate;

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
        $resultPage->setActiveMenu("Elogic_Certificate::certificates");
        $resultPage->getConfig()->getTitle()->set("Certificate");
        return $resultPage;
    }
}

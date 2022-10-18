<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller\Adminhtml\StoreLocator;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action;

class Index extends Action
{
    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Elogic_Internship::storelocator');
        $resultPage->getConfig()->getTitle()->prepend(__('Stores'));
        return $resultPage;
    }
}

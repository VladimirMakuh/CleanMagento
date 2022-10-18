<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller\Adminhtml\StoreLocator;

use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

class NewStore extends Action implements HttpGetActionInterface
{
    /**
     * @var ForwardFactory $forwardFactory
     */
    private ForwardFactory $forwardFactory;

    /**
     * @param ForwardFactory $forwardFactory
     * @param Context $context
     */
    public function __construct(
        ForwardFactory $forwardFactory,
        Context               $context
    ){
        $this->forwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    /**
     * Create new store action
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        return $this->forwardFactory->create()->forward('edit');
    }
}

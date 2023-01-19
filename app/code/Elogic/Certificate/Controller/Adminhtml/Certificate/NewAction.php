<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller\Adminhtml\Certificate;

use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * New action Certificate controller.
 */
class NewAction extends Action implements HttpGetActionInterface
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
     * Create new Certificate redirect action.
     *
     * @return ResultInterface
     */
    public function execute()
    {
        return $this->forwardFactory->create()->forward('edit');
    }
}

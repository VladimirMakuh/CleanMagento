<?php

namespace Elogic\Certificate\Controller\Adminhtml\Type;

use Elogic\Certificate\Api\Data\TypeInterfaceFactory;
use Elogic\Certificate\Api\TypeRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit Type entity backend controller.
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;
    /**
     * @var TypeInterfaceFactory
     */
    protected TypeInterfaceFactory $typeFactory;
    /**
     * @var TypeRepositoryInterface
     */
    protected TypeRepositoryInterface $typeRepository;

    /**
     * @param Context $context
     * @param TypeInterfaceFactory $typeFactory
     * @param TypeRepositoryInterface $typeRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                     $context,
        TypeInterfaceFactory        $typeFactory,
        TypeRepositoryInterface     $typeRepository,
        PageFactory                 $resultPageFactory
    ){
        $this->typeRepository = $typeRepository;
        $this->typeFactory = $typeFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $typeId = (int)$this->getRequest()->getParam('type_id');

        $typeTitle = "Type";
        if ($typeId) {
            $typeTitle = $this->typeFactory->create()->getName();
            $type = $this->typeRepository->getById($typeId);
            if (!$type->getId()) {
                $this->messageManager->addErrorMessage(__('No type with that id'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("Elogic_Certificate::certificate");
        $resultPage->getConfig()->getTitle()->prepend(__($typeTitle));
        $resultPage->addHandle('type' . $typeId);
        return $resultPage;

    }
}

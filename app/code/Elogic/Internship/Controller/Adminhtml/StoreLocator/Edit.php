<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller\Adminhtml\StoreLocator;

use Elogic\Internship\Api\Data\StoreLocatorInterfaceFactory;
use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;
    /**
     * @var StoreLocatorInterfaceFactory
     */
    protected StoreLocatorInterfaceFactory $storeFactory;
    /**
     * @var StoreLocatorRepositoryInterface
     */
    protected StoreLocatorRepositoryInterface $storeRepository;

    /**
     * @param Context $context
     * @param StoreLocatorInterfaceFactory $storeInterfaceFactory
     * @param StoreLocatorRepositoryInterface $storeRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                         $context,
        StoreLocatorInterfaceFactory    $storeInterfaceFactory,
        StoreLocatorRepositoryInterface $storeRepository,
        PageFactory                     $resultPageFactory
    ){
        parent::__construct($context);
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeInterfaceFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $storeId = (int)$this->getRequest()->getParam('store_entity_id');

        $storeTitle = "Store";
            if ($storeId) {
            $storeTitle = $this->storeFactory->create()->getName();
            $store = $this->storeRepository->getById($storeId);
            if (!$store->getId()) {
                $this->messageManager->addErrorMessage(__('No store with that id'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Elogic_Internship::storelocator');
        $resultPage->getConfig()->getTitle()->prepend(__($storeTitle));
        $resultPage->addHandle('store_locator' . $storeId);
        return $resultPage;
    }
}

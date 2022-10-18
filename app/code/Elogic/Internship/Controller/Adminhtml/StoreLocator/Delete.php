<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller\Adminhtml\StoreLocator;

use Elogic\Internship\Api\Data\StoreLocatorInterfaceFactory;
use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;

class Delete extends Action
{
    protected $resultFactory;
    protected $resultRedirectFactory;
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
     * @param StoreLocatorInterfaceFactory $storeFactory
     * @param StoreLocatorRepositoryInterface $storeRepository
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context                         $context,
        StoreLocatorInterfaceFactory    $storeFactory,
        StoreLocatorRepositoryInterface $storeRepository,
        RedirectFactory                 $resultRedirectFactory
    ){
        $this->resultFactory = $resultRedirectFactory;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('store_entity_id');

        $this->storeRepository->deleteById($id);
        $this->messageManager->addSuccessMessage(__('Record have been deleted.'));
        $result = $this->resultRedirectFactory->create();
        $result->setPath('internship/storelocator/index');

        return $result;
    }
}

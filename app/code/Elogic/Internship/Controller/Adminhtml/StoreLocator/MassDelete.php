<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller\Adminhtml\StoreLocator;

use Elogic\Internship\Api\StoreLocatorRepositoryInterface;
use Elogic\Internship\Model\ResourceModel\StoreLocator\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /**
     * @var Filter
     */
    private Filter $filter;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var StoreLocatorRepositoryInterface
     */
    private StoreLocatorRepositoryInterface $storeRepository;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param StoreLocatorRepositoryInterface $storeRepository
     */
    public function __construct(
        Context                         $context,
        Filter                          $filter,
        CollectionFactory               $collectionFactory,
        StoreLocatorRepositoryInterface $storeRepository
    ){
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $store) {
            $this->storeRepository->delete($store);
        }
        $this->messageManager->addSuccessMessage(__('Record(s) have been deleted.'));
        $this->_redirect("*/*/index");
    }
}

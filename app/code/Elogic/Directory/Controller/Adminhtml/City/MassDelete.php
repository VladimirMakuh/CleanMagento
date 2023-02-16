<?php
declare(strict_types=1);

namespace Elogic\Directory\Controller\Adminhtml\City;

use Elogic\Directory\Api\CityRepositoryInterface;
use Elogic\Directory\Model\ResourceModel\City\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /**
     * @var Filter
     */
    protected Filter $filter;
    /**
     * @var CityRepositoryInterface
     */
    private CityRepositoryInterface $cityRepository;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $cityCollection;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(
        Context                     $context,
        Filter                      $filter,
        CollectionFactory           $collectionFactory,
        CityRepositoryInterface     $cityRepository
    ){
        parent::__construct($context);

        $this->filter = $filter;
        $this->cityCollection = $collectionFactory;
        $this->cityRepository = $cityRepository;
    }

    /**
     * @return void
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->cityCollection->create());

            foreach ($collection as $city) {
                $this->cityRepository->delete($city);
            }

            $this->messageManager->addSuccessMessage(__('Record(s) have been deleted.'));

            $this->_redirect("*/*/index");
        }catch(\Exception $e)
        {
            $this->messageManager->addErrorMessage(__($e->getMessage()));

            $this->_redirect("*/*/index");
        }
    }
}

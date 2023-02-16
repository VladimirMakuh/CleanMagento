<?php

declare(strict_types=1);

namespace Elogic\Directory\Controller\Adminhtml\City;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Elogic\Directory\Model\ResourceModel\CityResource;

class Index implements HttpGetActionInterface
{
    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    public function __construct(
        ResultFactory       $resultFactory,
        CityResource        $cityResource
    ){
        $this->resultFactory = $resultFactory;
        $this->resource = $cityResource;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->setActiveMenu('Elogic_Directory::elogic');
        $page->getConfig()->getTitle()->prepend(__('City List'));

        $uaCities = $this->resource->getCitiesByCountryCode("0000");
        return $page;
    }
}

<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller\Certificate;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Elogic\Certificate\Model\ResourceModel\Certificate\CertificateCollectionFactory;
use Elogic\Certificate\Api\Data\CertificateInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Validate implements HttpPostActionInterface,HttpGetActionInterface
{
    /**
     * @var CertificateCollectionFactory
     */
    private CertificateCollectionFactory $collectionFactory;
    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var TimezoneInterface
     */
    private TimezoneInterface $timezone;

    public function __construct(
        CertificateCollectionFactory    $collectionFactory,
        ResultFactory                   $resultFactory,
        RequestInterface                $request,
        TimezoneInterface               $timezone
    ){
        $this->collectionFactory = $collectionFactory;
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->timezone = $timezone;
    }


    public function execute()
    {
        $certNumber = $this->request->getParam('cert_num');

        if(!$certNumber)
        {
            return null;
        }

        $collection = $this->collectionFactory->create();

        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $currentDate = $this->timezone->date()->format('Y-m-d');
        $data = null;

        foreach ($collection as $item)
        {
            if($item[CertificateInterface::CERT_NUMBER] === $certNumber)
            {
                $data = $item;
            }
        }
        if(!$data)
        {
            return $result->setData($data);
        }

        if($currentDate <= $data[CertificateInterface::DATE_VALID])
        {
            $data['available'] = true;
        }
        else
        {
            $data['available'] = false;
        }

        return $result->setData($data);
    }
}

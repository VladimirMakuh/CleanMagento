<?php

namespace Elogic\Certificate\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Controller\ResultFactory;
use Elogic\Certificate\Model\ResourceModel\Certificate\CertificateCollectionFactory;
use Elogic\Certificate\Api\Data\CertificateInterface;

class ValidateCertificate implements ArgumentInterface
{
    /**
     * @var CertificateCollectionFactory
     */
    private CertificateCollectionFactory $collectionFactory;
    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    public function __construct(
        CertificateCollectionFactory $collectionFactory,
        ResultFactory                $resultFactory
    ){
        $this->collectionFactory = $collectionFactory;
        $this->resultFactory = $resultFactory;
    }

    public function validate($certNumber){
        if (!$certNumber)
        {
            return null;
        }

        $collection = $this->collectionFactory->create();

        foreach ($collection as $item)
        {
            if($item[CertificateInterface::CERTIFICATE_ID] === $certNumber)
            {
                return $item[CertificateInterface::DATE_VALID];
            }
            else
            {
                return null;
            }
        }
    }
}

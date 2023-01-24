<?php
declare(strict_types=1);

namespace Elogic\Certificate\Helper;

use Elogic\Certificate\Model\ResourceModel\Certificate\CertificateCollectionFactory;
use Exception;

class CertNumber
{
    /**
     * @var CertificateCollectionFactory
     */
    private CertificateCollectionFactory $collectionFactory;

    public function __construct(
        CertificateCollectionFactory $collectionFactory
    ){
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @throws Exception
     */
    public function getCertificatedNumber()
    {
        $number = random_int(100000,10000000);

        while (!$this->isUniqueNumber($number))
        {
            $number = random_int(100000,10000000);
            if($this->isUniqueNumber($number))
            {
                break;
            }
        }
        return $number;
    }

    /**
     * Check is Certificate number is unique
     * @param $certNumber
     * @return bool
     */
    public function isUniqueNumber($certNumber){
        $collection = $this->collectionFactory->create();

        $count = 0;

        foreach ($collection as $item) {
            if($item['cert_number'] === $certNumber)
            {
                $count++;
            }
        }
        return $count <= 0;
    }
}

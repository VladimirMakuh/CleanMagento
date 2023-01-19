<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model\ResourceModel\Certificate;

use Elogic\Certificate\Model\ResourceModel\CertificateResource;
use Elogic\Certificate\Model\Certificate;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class CertificateCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'elogic_certificate_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Certificate::class, CertificateResource::class);
    }
}

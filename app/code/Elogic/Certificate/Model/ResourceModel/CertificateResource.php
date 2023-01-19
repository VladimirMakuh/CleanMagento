<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model\ResourceModel;

use Elogic\Certificate\Api\Data\CertificateInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CertificateResource extends AbstractDb
{
    protected const ENTITY_TABLE_NAME = 'elogic_certificate';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(self::ENTITY_TABLE_NAME, CertificateInterface::CERTIFICATE_ID);
    }
}

<?php

namespace Elogic\Certificate\Model\ResourceModel;

use Elogic\Certificate\Api\Data\SubjectInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SubjectResource extends AbstractDb
{
    protected const ENTITY_TABLE_NAME = 'elogic_subject';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(self::ENTITY_TABLE_NAME, SubjectInterface::SUBJECT_ID);
    }
}

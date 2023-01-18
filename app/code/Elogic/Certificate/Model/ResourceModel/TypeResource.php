<?php

namespace Elogic\Certificate\Model\ResourceModel;

use Elogic\Certificate\Api\Data\TypeInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TypeResource extends AbstractDb
{
    protected const ENTITY_TABLE_NAME = 'elogic_type';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(self::ENTITY_TABLE_NAME, TypeInterface::TYPE_ID);
    }
}

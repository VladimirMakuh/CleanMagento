<?php

namespace Elogic\Certificate\Model\ResourceModel\Type;

use Elogic\Certificate\Model\ResourceModel\TypeResource;
use Elogic\Certificate\Model\Type;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class TypeCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'elogic_type_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Type::class, TypeResource::class);
    }
}

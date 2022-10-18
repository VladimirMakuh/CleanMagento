<?php

declare(strict_types=1);

namespace Elogic\Internship\Model\ResourceModel\StoreLocator;

use Elogic\Internship\Model\ResourceModel\StoreLocator as ResourceModel;
use Elogic\Internship\Model\StoreLocator;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            StoreLocator::class,
            ResourceModel::class
        );
    }
}

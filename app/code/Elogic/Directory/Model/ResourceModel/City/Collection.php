<?php
declare(strict_types=1);

namespace Elogic\Directory\Model\ResourceModel\City;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Elogic\Directory\Model\City;
use Elogic\Directory\Model\ResourceModel\CityResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'elogic_directory_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(City::class,CityResource::class);
    }
}

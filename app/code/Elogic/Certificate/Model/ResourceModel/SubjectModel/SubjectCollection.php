<?php

namespace Elogic\Certificate\Model\ResourceModel\SubjectModel;

use Elogic\Certificate\Model\ResourceModel\SubjectResource;
use Elogic\Certificate\Model\Subject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class SubjectCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'elogic_subject_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Subject::class, SubjectResource::class);
    }
}

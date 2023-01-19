<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model\Subject\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Elogic\Certificate\Model\ResourceModel\SubjectModel\SubjectCollectionFactory;

class Options implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected array $options;
    /**
     * @var SubjectCollectionFactory
     */
    private SubjectCollectionFactory $subjectCollection;


    public function __construct(
        SubjectCollectionFactory      $subjectCollection
    ){
        $this->subjectCollection = $subjectCollection;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $collection = $this->subjectCollection->create();

        $options = [];

        foreach ($collection->getData() as $type) {
            $options[] = [
                'label' => $type['subject'],
                'value' => $type['subject_id'],
            ];
        }
        $this->options = $options;

        return $options;
    }
}

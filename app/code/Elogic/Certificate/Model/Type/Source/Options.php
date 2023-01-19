<?php
declare(strict_types=1);

namespace Elogic\Certificate\Model\Type\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Elogic\Certificate\Model\ResourceModel\Type\TypeCollectionFactory;

class Options implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected array $options;
    /**
     * @var TypeCollectionFactory
     */
    private TypeCollectionFactory $typeCollection;


    public function __construct(
        TypeCollectionFactory      $typeCollection
    ){
        $this->typeCollection = $typeCollection;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $collection = $this->typeCollection->create();

        $options = [];

        foreach ($collection->getData() as $type) {
            $options[] = [
                'label' => $type['type'],
                'value' => $type['type_id'],
            ];
        }
        $this->options = $options;

        return $options;
    }
}

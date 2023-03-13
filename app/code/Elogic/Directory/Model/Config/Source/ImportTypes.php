<?php
declare(strict_types=1);

namespace Elogic\Directory\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ImportTypes implements OptionSourceInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [['label' => __('Get Cities'), 'value' => 'cities']];
    }
}

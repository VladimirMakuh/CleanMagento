<?php

declare(strict_types=1);

namespace Elogic\Certificate\Ui\Component\Subject\Form\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save implements ButtonProviderInterface
{
    /**
     * Get button configuration
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage_init' => [
                    'button' => [
                        'event' => 'save'
                    ],
                ],
                'form-role' => 'save'
            ],
            'aclResource' => 'Elogic_Certificate::write',
            'sort_order' => 10
        ];
    }
}

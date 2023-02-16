<?php
declare(strict_types=1);

namespace Elogic\Directory\Block\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;

class Button extends Field
{
    /**
     * @var string
     */
    protected $_template = "Elogic_Directory::system/config/button.phtml";

    private string $_url = 'elogic/city/import';

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    public function getCustomUrl(): string
    {
        return $this->getUrl($this->_url);
    }

    /**
     * @throws LocalizedException
     */
    public function getButtonHtml(): string
    {
        $button = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')->setData(['id' => 'btn_id', 'label' => __('Import cities'),]);
        return $button->toHtml();
    }
}

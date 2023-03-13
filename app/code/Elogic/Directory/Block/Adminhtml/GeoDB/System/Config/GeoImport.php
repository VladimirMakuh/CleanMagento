<?php
declare(strict_types=1);

namespace Elogic\Directory\Block\Adminhtml\GeoDB\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class GeoImport extends Field
{
    /**
     * @return $this
     */
    public function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('system/config/import.phtml');
        return $this;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    public function getSendUrl(): string
    {
        return $this->getUrl('directory/geodb_system_config/import');
    }
}

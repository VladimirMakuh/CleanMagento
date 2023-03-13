<?php
declare(strict_types=1);

namespace Elogic\Directory\Block\Adminhtml\GeoDB\System\Config;

use Elogic\Directory\Api\ClientInterface;
use Elogic\Directory\Model\Config\CityConfigProvider;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class TestConnection extends Field
{
    protected $_template = "Elogic_Directory::system/config/validate.phtml";

    private const TEST_CONNNECTION_PATH = 'directory/geodb_system_config/connection';
    /**
     * @var CityConfigProvider
     */
    private CityConfigProvider $config;
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @param Context $context
     * @param CityConfigProvider $config
     * @param ClientInterface $client
     * @param array $data
     */
    public function __construct(
        Context             $context,
        CityConfigProvider  $config,
        ClientInterface     $client,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * Get the button and scripts contents
     *
     * @param AbstractElement $element
     * @return string
     */
    public function _getElementHtml(AbstractElement $element): string
    {
        $this->addData(
            [
                'button_label' => __($element->getOriginalData()['button_label']),
            ]
        );

        return $this->_toHtml();
    }

    /**
     * Check connection for the current api key saved value.
     *
     * @return bool
     */
    public function isConnectionSuccessful(): bool
    {
       if($this->config->getApiKey())
       {
           return $this->client->testConnection($this->config->getApiKey(), $this->config->getApiHost());
       }
       return true;
    }

    /**
     * Get connection url
     *
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->_urlBuilder->getUrl(
            self::TEST_CONNNECTION_PATH,
            [
                'form_key' => $this->getFormKey(),
            ]
        );
    }

    /**
     * Remove element scope and render form element as HTML
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element): string
    {
        $element->setData('scope', null);
        return parent::render($element);
    }
}

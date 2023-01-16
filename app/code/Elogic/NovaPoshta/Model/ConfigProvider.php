<?php
declare(strict_types=1);

namespace Elogic\NovaPoshta\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const XML_PATH_ENABLE = 'novaposhta/novaposhta/enable';
    public const XML_PATH_NOVAPOSHTA_API_KEY = 'novaposhta/novaposhta/novaposhta_api_key';
    public const XML_PATH_NOVAPOSHTA_ENABLE_CUSTOM_PRICE= 'novaposhta/novaposhta/enable_custom_price';
    public const XML_PATH_NOVAPOSHTA_DEPARTMENT_PRICE= 'novaposhta/novaposhta/novaposhta_delivery_department_cost';
    public const XML_PATH_NOVAPOSHTA_POSTBOX_PRICE= 'novaposhta/novaposhta/novaposhta_delivery_postbox_cost';
    public const XML_PATH_NOVAPOSHTA_COURIER_PRICE= 'novaposhta/novaposhta/novaposhta_delivery_courier_cost';

    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function IsModuleEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getNovaPoshtaApiKey(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_NOVAPOSHTA_API_KEY,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isEnableCustomPrice(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_NOVAPOSHTA_ENABLE_CUSTOM_PRICE,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getDepartmentPrice(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_NOVAPOSHTA_DEPARTMENT_PRICE,
            ScopeInterface::SCOPE_STORE);
    }
    /**
     * @return string
     */
    public function getPostBoxPrice(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_NOVAPOSHTA_POSTBOX_PRICE,
            ScopeInterface::SCOPE_STORE);
    }
    /**
     * @return string
     */
    public function getCourierPrice(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_NOVAPOSHTA_COURIER_PRICE,
            ScopeInterface::SCOPE_STORE);
    }
}

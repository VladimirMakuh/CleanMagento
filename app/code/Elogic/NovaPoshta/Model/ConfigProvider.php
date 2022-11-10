<?php
declare(strict_types=1);

namespace Elogic\NovaPoshta\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const XML_PATH_ENABLE = 'novaposhta/novaposhta/enable';
    public const XML_PATH_NOVAPOSHTA_API_KEY = 'novaposhta/novaposhta/novaposhta_api_key';

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
}

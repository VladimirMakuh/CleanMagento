<?php

declare(strict_types=1);

namespace Elogic\Internship\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const XML_PATH_ENABLE = 'internship/storelocator/enable';
    public const XML_PATH_GOOGLE_API_KEY = 'internship/storelocator/google_api_key';

    private ScopeConfigInterface $scopeConfig;


    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ){
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
    public function getGoogleMapsApiKey(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_GOOGLE_API_KEY,
            ScopeInterface::SCOPE_STORE);
    }
}

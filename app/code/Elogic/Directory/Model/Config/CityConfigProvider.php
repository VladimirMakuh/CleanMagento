<?php
declare(strict_types=1);

namespace Elogic\Directory\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class CityConfigProvider
{
    private const XML_PATH_DIRECTORY_DROPDOWN_ENABLE = "directory/general/enable";
    private const XML_PATH_DIRECTORY_IMPORT_TYPE = "directory/geo_db/geo_import_type";
    private const XML_PATH_DIRECTORY_API_KEY = "directory/geo_db/geo_db_key";
    private const XML_PATH_DIRECTORY_API_HOST = "directory/geo_db/geo_db_host";

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $config;

    /**
     * @param ScopeConfigInterface $config
     */
    public function __construct(
        ScopeConfigInterface    $config
    ){
        $this->config = $config;
    }

    /**
     *
     * @return bool
     */
    public function isEnableDropdown(): bool
    {
        return (bool)$this->config->getValue(
            self::XML_PATH_DIRECTORY_DROPDOWN_ENABLE,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getImportType():string
    {
        return (string)$this->config->getValue(
            self::XML_PATH_DIRECTORY_IMPORT_TYPE,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return (string)$this->config->getValue(
            self::XML_PATH_DIRECTORY_API_KEY,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Host
     *
     * @return string
     */
    public function getApiHost(): string
    {
        return (string)$this->config->getValue(
            self::XML_PATH_DIRECTORY_API_HOST,
            ScopeInterface::SCOPE_STORE);
    }
}

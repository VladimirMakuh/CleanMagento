<?php
declare(strict_types=1);

namespace Elogic\Directory\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class CityConfigProvider
{
    private const XML_PATH_DIRECTORY_DROPDOWN_ENABLE = "directory/general/enable";

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
}

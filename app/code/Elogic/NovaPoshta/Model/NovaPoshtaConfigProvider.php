<?php
declare(strict_types=1);

namespace Elogic\NovaPoshta\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Elogic\NovaPoshta\Model\ConfigProvider;

class NovaPoshtaConfigProvider implements ConfigProviderInterface
{
    /**
     * @var ConfigProvider
     */
    private ConfigProvider $configProvider;

    public function __construct(
        ConfigProvider $configProvider
    ){
        $this->configProvider = $configProvider;
    }

    public function getConfig(): array
    {
       return [
           'novaposhta'=>
           [ "enable" => $this->configProvider->IsModuleEnabled(),
               "api_key" =>$this->configProvider->getNovaPoshtaApiKey(),
               "enableCustomPrice" => $this->configProvider->isEnableCustomPrice(),
               "departmentPrice" => $this->configProvider->getDepartmentPrice(),
               "postBoxPrice" => $this->configProvider->getPostBoxPrice(),
               "courierPrice" => $this->configProvider->getCourierPrice()
           ]
       ];
    }
}

<?php
declare(strict_types=1);

namespace Elogic\NovaPoshta\Model;

use \Magento\Framework\App\Config\Storage\WriterInterface;
use \Magento\Store\Model\StoreManagerInterface;

class WriteConfig
{
    /**
     * @var WriterInterface
     */
    protected WriterInterface $_configWriter;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $_storeManager;

    /**
     * @param WriterInterface $configWriter
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        WriterInterface $configWriter,
        StoreManagerInterface $storeManager
    ){
        $this->_configWriter = $configWriter;
        $this->_storeManager = $storeManager;
    }

    public function setPrice($path, $value)
    {
        // stores/default/carriers/novaposhta/price
        //for all websites
        $websites = $this->_storeManager->getWebsites();
        $scope = "default";

        $this->_configWriter->save($path, $value, $scope);

        return $this;
    }
}

<?php

namespace Elogic\NovaPoshta\Helper;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class ConfigCache
{
    /**
     * @var TypeListInterface
     */
    protected TypeListInterface $cacheTypeList;
    /**
     * @var Pool
     */
    protected Pool $cacheFrontendPool;

    /**
     * @param TypeListInterface $cacheTypeList
     * @param Pool $cacheFrontendPool
     */
    public function __construct(
        TypeListInterface $cacheTypeList,
        Pool              $cacheFrontendPool
    ){
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
    }

    /**
     * @return void
     */
    public function flushCache(): void
    {
        $_types = [
            'config',
        ];

        foreach ($_types as $type) {
            $this->cacheTypeList->cleanType($type);
        }
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}

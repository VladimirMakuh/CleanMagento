<?php

declare(strict_types=1);

namespace Elogic\Internship\Model\ResourceModel;

use Elogic\Internship\Api\Data\StoreLocatorInterface;
use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StoreLocator extends AbstractDb
{
    protected const ENTITY_TABLE_NAME = 'store_locator';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::ENTITY_TABLE_NAME, StoreLocatorInterface::STORE_ID);
    }

    /**
     * @param string $url
     * @return string
     */
    public function checkUrlKeys(string $url): string
    {
        $select = $this->loadByUrlKey($url);

        $select->reset(Select::COLUMNS)
            ->columns(StoreLocatorInterface::STORE_ID)
            ->limit(1);

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * @param string $url
     * @return Select
     */
    public function loadByUrlKey(string $url): Select
    {
        return $this->getConnection()->select()
            ->from([self::ENTITY_TABLE_NAME])
            ->where(StoreLocatorInterface::STORE_URL_KEY . "= ?", $url);
    }

    /**
     * @param $url
     * @return bool
     */
    public function checkUniqueUrl($url): bool
    {
        $select = $this->getConnection()->select()
            ->from(self::ENTITY_TABLE_NAME)
            ->where(StoreLocatorInterface::STORE_URL_KEY . '= ?', $url);
        if (!$this->getConnection()->fetchOne($select)) {
            return true;
        }
        return false;
    }
}

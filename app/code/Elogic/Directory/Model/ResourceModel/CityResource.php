<?php
declare(strict_types=1);

namespace Elogic\Directory\Model\ResourceModel;

use Elogic\Directory\Api\Data\CityInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CityResource extends AbstractDb
{
    protected const ENTITY_TABLE_NAME = 'elogic_city';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(self::ENTITY_TABLE_NAME,CityInterface::CITY_ID);
    }

    /**
     * Return an array of cities by country code
     * @param string $countryCode
     * @return array|null
     */
    public function getCitiesByCountryCode(string $countryCode): ?array
    {
        if (!$countryCode) {
            return null;
        }
        $select = $this->getConnection()->select()
            ->from(self::ENTITY_TABLE_NAME)
            ->where(CityInterface::ISO2_CODE . '= ?', $countryCode);

        if($city = $this->getConnection()->fetchAll($select)){
            return $city;
        }
        return null;
    }
}

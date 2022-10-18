<?php
declare(strict_types=1);

namespace Elogic\Internship\Plugin;

use Elogic\Internship\Api\Data\StoreLocatorInterface;
use Elogic\Internship\Model\StoreRepository;
use Elogic\Internship\Model\ResourceModel\StoreLocator;

class SaveUrl
{
    /**
     * @var StoreLocator
     */
    private StoreLocator $storeResource;

    /**
     * @param StoreLocator $storeResource
     */
    public function __construct(
        StoreLocator $storeResource
    ){
        $this->storeResource = $storeResource;
    }

    /**
     * @param StoreRepository $subject
     * @param StoreLocatorInterface $store
     * @return array
     * @throws \Exception
     */
    public function beforeSave(StoreRepository $subject, StoreLocatorInterface $store): array
    {
        if ($store->getName() === null) {
            return [$store];
        }

        $name = str_replace(' ', '-', strtolower($store['name']));
        try {
            if (!empty($store['store_url_key'])) {
                if ($this->storeResource->checkUniqueUrl($store['store_url_key'])) {
                    return [$store];
                } else {
                    $store->setUrl($name . '-' . 'store' . random_int(0, 100));
                }
            } else {
                throw new \RuntimeException();
            }
        } catch (\Exception $exception) {
            if ($this->storeResource->checkUniqueUrl($name)) {
                $store->setUrl($name);
            } else {
                $store->setUrl($name . '-' . 'store' . random_int(0, 100));
            }
        }
        return [$store];
    }
}

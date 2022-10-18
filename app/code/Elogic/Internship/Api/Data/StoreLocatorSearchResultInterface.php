<?php

declare(strict_types=1);

namespace Elogic\Internship\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface StoreLocatorSearchResultInterface extends SearchResultsInterface
{

    /**
     * @return \Elogic\Internship\Api\Data\StoreLocatorInterface[]
     */
    public function getItems();

    /**
     * @param \Elogic\Internship\Api\Data\StoreLocatorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

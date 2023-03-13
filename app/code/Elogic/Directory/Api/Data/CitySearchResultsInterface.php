<?php
declare(strict_types=1);

namespace Elogic\Directory\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CitySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return CityInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param CityInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

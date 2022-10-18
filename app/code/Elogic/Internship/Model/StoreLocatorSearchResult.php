<?php

declare(strict_types=1);

namespace Elogic\Internship\Model;

use Elogic\Internship\Api\Data\StoreLocatorSearchResultInterface;
use Magento\Framework\Api\SearchResults;

class StoreLocatorSearchResult extends SearchResults implements StoreLocatorSearchResultInterface
{
}
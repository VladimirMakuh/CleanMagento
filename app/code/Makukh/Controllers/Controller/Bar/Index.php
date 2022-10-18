<?php
declare(strict_types=1);

namespace Makukh\Controllers\Controller\Bar;

use Magento\Framework\App\Action\HttpGetActionInterface;

class Index implements HttpGetActionInterface
{

    public function execute()
    {
        echo "Hi World";
        exit;
    }
}

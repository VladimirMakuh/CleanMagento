<?php

declare(strict_types=1);

namespace Elogic\Internship\Observer;

use Magento\Framework\DataObject\Copy;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

class SaveOrderBeforeSalesModelQuote implements ObserverInterface
{
    /**
     * @var Copy
     */
    protected Copy $objectCopyService;

    /**
     * @param Copy $objectCopyService
     *
     */
    public function __construct(
        Copy $objectCopyService
    ) {
        $this->objectCopyService = $objectCopyService;
    }

    /**
     * @param Observer $observer
     * @return SaveOrderBeforeSalesModelQuote
     */
    public function execute(Observer $observer)
    {
        /* @var Order $order */
        $order = $observer->getEvent()->getData('order');
        /* @var Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        $this->objectCopyService->copyFieldsetToTarget('sales_convert_quote', 'to_order', $quote, $order);
        return $this;
    }
}

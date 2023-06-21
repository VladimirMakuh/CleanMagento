<?php
declare(strict_types=1);

namespace Elogic\Internship\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class Attributes extends Template
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @param Context $context
     * @param array $data
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        Template\Context $context,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ){
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    public function getOrder(): OrderInterface
    {
        $orderId = $this->getRequest()->getParam('order_id');
        return $this->orderRepository->get($orderId);
    }
}

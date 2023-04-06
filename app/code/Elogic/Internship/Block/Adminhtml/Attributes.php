<?php
declare(strict_types=1);

namespace Elogic\Internship\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;

class Attributes extends Template
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        Template\Context $context,
        array $data = [],
        OrderRepositoryInterface $orderRepository
    ){
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    public function getOrder()
    {
        try {
            $orderId = $this->getRequest()->getParam('order_id');
            return $this->orderRepository->get($orderId);
        } catch (NoSuchEntityException $e)
        {
            return false;
        }
    }
}

<?php

declare(strict_types=1);

namespace Elogic\NovaPoshta\Block\Adminhtml;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Api\OrderRepositoryInterface;

class Attributes extends Template
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @param Template\Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        OrderRepositoryInterface $orderRepository,
        array $data = [])
    {
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    public function getOrder(){
        try {
            $order_id = $this->getRequest()->getParam('order_id');
            return $this->orderRepository->get($order_id);
        }catch (NoSuchEntityException $e){
            return false;
        }
    }
}

<?php

declare(strict_types=1);

namespace Elogic\NovaPoshta\Block\Adminhtml;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class NovaPoshtaDetails extends Template
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

    /**
     * @return false|OrderInterface
     */
    public function getOrder()
    {
        try {
            $order_id = $this->getRequest()->getParam('order_id');
            return $this->orderRepository->get($order_id);
        }catch (NoSuchEntityException $e){
            return false;
        }
    }

    /**
     * @param $type
     * @return string
     */
    public function showType($type): string
    {
        switch ($type){
            case 'postbox': return "Post Box";
            case 'department': return "Department";
            case 'courier': return "Courier";
            default: return "Undefined type";
        }
    }
}

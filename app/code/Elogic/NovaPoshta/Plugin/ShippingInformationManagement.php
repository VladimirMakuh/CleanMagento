<?php
declare(strict_types=1);

namespace Elogic\NovaPoshta\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;

class ShippingInformationManagement
{
    /**
     * @var CartRepositoryInterface
     */
    private CartRepositoryInterface $cartRepository;

    /**
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository
    ){
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param $subject
     * @param $cartId
     * @param $addressInformation
     * @return array
     * @throws NoSuchEntityException
     */
    public function beforeSaveAddressInformation(
        $subject, $cartId, $addressInformation)
    {
        $quote = $this->cartRepository->getActive($cartId);
        $deliveryNovaposhta = $addressInformation->getExtensionAttributes()->getDeliveryNovaposhta();
        $quote->setDeliveryNovaposhta($deliveryNovaposhta);
        $this->cartRepository->save($quote);
        return [$cartId, $addressInformation];
    }
}

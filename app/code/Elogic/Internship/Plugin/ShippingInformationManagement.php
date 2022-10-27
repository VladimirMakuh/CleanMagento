<?php
declare(strict_types=1);

namespace Elogic\Internship\Plugin;

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

    public function beforeSaveAddressInformation($subject, $cartId, $addressInformation)
    {
        $quote = $this->cartRepository->getActive($cartId);
        $pickUpStore = $addressInformation->getExtensionAttributes()->getPickUpStore();
        $quote->setPickUpStore($pickUpStore);
        $this->cartRepository->save($quote);
        return [$cartId, $addressInformation];
    }
}

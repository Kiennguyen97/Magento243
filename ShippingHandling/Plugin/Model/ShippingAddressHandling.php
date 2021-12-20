<?php
namespace Gssi\ShippingHandling\Plugin\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote;

class ShippingAddressHandling
{
    protected $quoteRepository;

    protected $helperData;

    public function __construct
    (
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Gssi\ShippingHandling\Helper\Data $helperData
    )
    {
        $this->quoteRepository = $quoteRepository;
        $this->helperData = $helperData;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    )
    {
        try {
            $address = $addressInformation->getShippingAddress();

            $extensionAttr = $addressInformation->getExtensionAttributes();

            if($extensionAttr->getShippingHandling()) {
                $shippingHandling = $this->helperData->encryptHandling($extensionAttr->getShippingHandling());
                $address->setShippingHandling($shippingHandling);
            }

        } catch (NoSuchEntityException $e) {
        }

    }
}

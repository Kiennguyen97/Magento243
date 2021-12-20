<?php

namespace Gssi\ShippingHandling\Plugin\Quote\Address;


class ToOrderAddress
{
    /**
     * @param \Magento\Quote\Model\Quote\Address\ToOrderAddress $subject
     * @param \Magento\Sales\Api\Data\OrderAddressInterface $orderAddress
     * @param \Magento\Quote\Model\Quote\Address $object
     * @return \Magento\Sales\Api\Data\OrderAddressInterface
     */
    public function afterConvert(
        \Magento\Quote\Model\Quote\Address\ToOrderAddress $subject,
        \Magento\Sales\Api\Data\OrderAddressInterface $orderAddress,
        \Magento\Quote\Model\Quote\Address $object
    ) {
        if ($object->getShippingHandling()){
            $orderAddress->setShippingHandling($object->getShippingHandling());
        }
        return $orderAddress;
    }
}

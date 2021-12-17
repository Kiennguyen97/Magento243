<?php

namespace VBA\CompanyInvoiceDetails\Observer;

class SaveUnitNumberInOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        if ($quote->getBillingAddress()) {
            $order->getBillingAddress()->setUnitNumber($quote->getBillingAddress()->getExtensionAttributes()->getUnitNumber());
        }
        if (!$quote->isVirtual()) {
            $order->getShippingAddress()->setUnitNumber($quote->getShippingAddress()->getUnitNumber());
        }
        return $this;
    }
}

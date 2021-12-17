<?php

namespace VBA\CompanyInvoiceDetails\Observer;

class SaveCompanyAddress implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        if ($quote->getBillingAddress()) {
            $order->getBillingAddress()->setCompanyLegalName($quote->getBillingAddress()->getExtensionAttributes()->getCompanyLegalName());
            $order->getBillingAddress()->setCompanyAddress($quote->getBillingAddress()->getExtensionAttributes()->getCompanyAddress());
            $order->getBillingAddress()->setVatTax($quote->getBillingAddress()->getExtensionAttributes()->getVatTax());
            $order->getBillingAddress()->setCompanyRepresentative($quote->getBillingAddress()->getExtensionAttributes()->getCompanyRepresentative());
            $order->getBillingAddress()->setCompanyEmail($quote->getBillingAddress()->getExtensionAttributes()->getCompanyEmail());
        }
        if (!$quote->isVirtual()) {
            $order->getShippingAddress()->setCompanyLegalName($quote->getShippingAddress()->getCompanyLegalName());
            $order->getShippingAddress()->setCompanyAddress($quote->getShippingAddress()->getCompanyAddress());
            $order->getShippingAddress()->setVatTax($quote->getShippingAddress()->getVatTax());
            $order->getShippingAddress()->setCompanyRepresentative($quote->getShippingAddress()->getCompanyRepresentative());
            $order->getShippingAddress()->setCompanyEmail($quote->getShippingAddress()->getCompanyEmail());
        }
        return $this;
    }
}

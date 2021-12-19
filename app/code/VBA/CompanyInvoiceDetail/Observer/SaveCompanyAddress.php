<?php

namespace VBA\CompanyInvoiceDetail\Observer;

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
        return $this;
    }
}

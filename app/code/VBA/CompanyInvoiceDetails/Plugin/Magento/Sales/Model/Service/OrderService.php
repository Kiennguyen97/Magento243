<?php

namespace VBA\CompanyInvoiceDetails\Plugin\Magento\Sales\Model\Service;

use Magento\Sales\Api\Data\OrderInterface;
use Psr\Log\LoggerInterface;
use Magento\Quote\Api\CartRepositoryInterface;

class OrderService
{
    /**
     * @var CartRepositoryInterface
     */
    private $quoteRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        CartRepositoryInterface $quoteRepository,
        LoggerInterface         $logger
    )
    {
        $this->quoteRepository = $quoteRepository;
        $this->logger = $logger;
    }

    public function beforePlace(
        \Magento\Sales\Model\Service\OrderService $subject,
        OrderInterface                            $order
    )
    {
        try {
            $quote = $this->quoteRepository->get($order->getQuoteId());
            if ($quote->getBillingAddress()) {
                $order->getBillingAddress()->setCompanyName($quote->getBillingAddress()->getExtensionAttributes()->getCompanyName());
                $order->getBillingAddress()->setCompanyLegalName($quote->getBillingAddress()->getExtensionAttributes()->getCompanyLegalName());
                $order->getBillingAddress()->setCompanyAddress($quote->getBillingAddress()->getExtensionAttributes()->getCompanyAddress());
                $order->getBillingAddress()->setVatTax($quote->getBillingAddress()->getExtensionAttributes()->getVatTax());
                $order->getBillingAddress()->setCompanyRepresentative($quote->getBillingAddress()->getExtensionAttributes()->getCompanyRepresentative());
                $order->getBillingAddress()->setCompanyEmail($quote->getBillingAddress()->getExtensionAttributes()->getCompanyEmail());
            }

            if (!$quote->isVirtual()) {
                $order->getShippingAddress()->setCompanyName($quote->getShippingAddress()->getCompanyName());
                $order->getShippingAddress()->setCompanyLegalName($quote->getShippingAddress()->getCompanyLegalName());
                $order->getShippingAddress()->setCompanyAddress($quote->getShippingAddress()->getCompanyAddress());
                $order->getShippingAddress()->setVatTax($quote->getShippingAddress()->getVatTax());
                $order->getShippingAddress()->setCompanyRepresentative($quote->getShippingAddress()->getCompanyRepresentative());
                $order->getShippingAddress()->setCompanyEmail($quote->getShippingAddress()->getCompanyEmail());
            }
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
    }
}

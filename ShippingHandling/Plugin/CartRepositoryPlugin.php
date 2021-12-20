<?php
namespace Gssi\ShippingHandling\Plugin;

use Magento\Quote\Api\Data\CartExtensionFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartSearchResultInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;

class CartRepositoryPlugin
{
    protected $extensionFactory;

    public function __construct(CartExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }
    public function afterGet(CartRepositoryInterface $subject, CartInterface $quote)
    {
        $customattribute = $quote->getData('shipping_handling');
        $customattribute = $customattribute != null ? $customattribute : '';
        $extensionAttributes = $quote->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setData('shipping_handling',$customattribute);

        $quote->setExtensionAttributes($extensionAttributes);
        return $quote;
    }
}

<?php

namespace Gssi\ShippingHandling\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;

class ShippingHandling extends \Magento\Framework\View\Element\Template
{
    protected $helperData;

    public function __construct
    (
        \Magento\Framework\View\Element\Template\Context $context,
        \Gssi\ShippingHandling\Helper\Data $helperData
    )
    {
        parent::__construct($context);
        $this->helperData = $helperData;
    }

    public function toHtml()
    {
        if(!$this->helperData->isDisplay()){
            return '';
        } else {
            return parent::toHtml();
        }
    }

    public function getHandlingUrl()
    {
        return $this->helperData->getHandlingUrl();
    }

}

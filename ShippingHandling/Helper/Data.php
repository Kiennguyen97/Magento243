<?php

namespace Gssi\ShippingHandling\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use Magento\Framework\Exception\NoSuchEntityException;

class Data extends AbstractHelper
{

    protected $storeManager;

    protected $encryptor;

    public function __construct
    (
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Encryptor $encryptor
    )
    {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->encryptor = $encryptor;
    }

    public function getHandlingUrl()
    {
        $baseUrl = '';
        try {
            $storeId = $this->storeManager->getStore()->getId();
            $baseUrl = $this->storeManager->getStore($storeId)->getBaseUrl();
        } catch (NoSuchEntityException $e) {

        }

        return $baseUrl.'shipping-handling';
    }

    public function encryptHandling($handling)
    {
        return $this->encryptor->encrypt($handling);
    }

    public function decryptHandling($handling)
    {
        return $this->encryptor->decrypt($handling);
    }

    public function isDisplay(){
        $storeCode = $this->storeManager->getStore()->getCode();
        return $storeCode == 'usa_bezdan_storeview';
    }
}

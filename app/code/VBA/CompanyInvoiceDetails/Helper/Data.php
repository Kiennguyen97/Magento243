<?php

namespace VBA\CompanyInvoiceDetails\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    const XML_PATH_COMPANY = 'company/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getInvoiceConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_COMPANY .'invoice/'. $code, $storeId);
    }

    public function getInvoiceStatus($code, $storeId = null)
    {

        return $this->getInvoiceConfig('enable',$storeId);
    }

}

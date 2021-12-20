<?php

namespace Gssi\ShippingHandling\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

/**
 * Class HandlingConfigProvider for provide settings
 */
class HandlingConfigProvider implements ConfigProviderInterface
{
    protected $helperData;
    protected $cmsblock;

    public function __construct
    (
        \Gssi\ShippingHandling\Helper\Data $helperData,
        \Magento\Cms\Block\Block $cmsblock
    )
    {
        $this->helperData = $helperData;
        $this->cmsblock = $cmsblock;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'handling' => [
                'handlingUrl' => $this->helperData->getHandlingUrl(),
                'handlingCMSContent' => $this->cmsblock->setBlockId('shipping-handling-content-checkout')->toHtml()
            ]
        ];
    }

}

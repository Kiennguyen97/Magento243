<?php
/**
 * Create new field on check out billing address
 */

namespace VBA\CompanyInvoiceDetails\Plugin\Checkout;

class LayoutProcessor
{

    private $jsLayout;

    /**
     * Generate new field
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */


    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor  $subject, $jsLayout)
    {
        $this->jsLayout = $jsLayout;

        if (isset($this->jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children']))
        {
            $configuration = $jsLayout['components']['checkout']['children']['steps']['children']
            ['billing-step']['children']['payment']['children']['payments-list']['children'];

            foreach ($configuration as $paymentGroup => $groupConfig)
            {
                $paymentCode = 'billingAddress'.str_replace('-form','',$paymentGroup);
                $this->getBillingAddressGen('company_legal_name','Company Legal Name',$paymentGroup,$paymentCode,'300');
            }

        }

        if(isset($this->jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset'])
        ){
            $this->getShippingAddressGen('company_legal_name','Company Legal Name','300');
        }

        return $this->jsLayout;
    }

    public function getBillingAddressGen($code,$label,$key,$paymentCode,$sortOrder){
        $this->jsLayout['components']['checkout']['children']['steps']
        ['children']['billing-step']['children']['payment']['children']
        ['payments-list']['children'][$key]['children']['form-fields']
        ['children'][$code] = $this->getUnitNumberAttributeForAddress($code,$label,$paymentCode,$sortOrder);
    }

    public function getShippingAddressGen($code,$label,$sortOrder){
        $this->jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']
        [$code] = $this->getUnitNumberAttributeForAddress($code,$label,'shippingAddress',$sortOrder);

        return $this;
    }

    public function getUnitNumberAttributeForAddress($code,$label,$addressType,$sortOrder)
    {
        return $customField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => $addressType.'.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => $addressType.'.custom_attributes' . '.' . $code,
            'label' => $label,
            'provider' => 'checkoutProvider',
            'sortOrder' => $sortOrder,
            'validation' => [
                'required-entry' => false
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];
    }

}


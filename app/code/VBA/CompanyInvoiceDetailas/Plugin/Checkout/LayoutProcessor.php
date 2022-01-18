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
                $this->getBillingAddressGen('title','Title',$paymentGroup,$paymentCode,'280',$type = 'title');
                $this->getBillingAddressGen('company','Company',$paymentGroup,$paymentCode,'290');
                $this->getBillingAddressGen('company_legal_name','Company Legal Name',$paymentGroup,$paymentCode,'300');
                $this->getBillingAddressGen('company_address','Company Address',$paymentGroup,$paymentCode,'310');
                $this->getBillingAddressGen('vat_tax', 'VAT/TAX ID',$paymentGroup,$paymentCode,'320');
                $this->getBillingAddressGen('company_representative', 'Company Representative',$paymentGroup,$paymentCode,'330');
                $this->getBillingAddressGen('company_email', 'Company Email',$paymentGroup,$paymentCode,'340');
            }

        }

//        if(isset($this->jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset'])
//       ){
//          $this->getShippingAddressGen('title','Title','280', $type = 'title');
//          $this->getShippingAddressGen('company','Company','290');
//            $this->getShippingAddressGen('company_legal_name','Company Legal Name','300');
//           $this->getShippingAddressGen('company_address','Company Address','310');
//          $this->getShippingAddressGen('vat_tax', 'VAT/TAX ID','320');
//           $this->getShippingAddressGen('company_representative', 'Company Representative','330');
//          $this->getShippingAddressGen('company_email', 'Company Email','340');
//       }

        return $this->jsLayout;
    }

    public function getBillingAddressGen($code,$label,$key,$paymentCode,$sortOrder,$type = 'field'){
        $this->jsLayout['components']['checkout']['children']['steps']
        ['children']['billing-step']['children']['payment']['children']
        ['payments-list']['children'][$key]['children']['form-fields']
        ['children'][$code] = $this->getAttributeForAddress($code,$label,$paymentCode,$sortOrder,$type);
    }

    public function getShippingAddressGen($code,$label,$sortOrder,$type = 'field'){
        $this->jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']
        [$code] = $this->getAttributeForAddress($code,$label,'shippingAddress',$sortOrder,$type);
        return $this;
    }

    public function getAttributeForAddress($code,$label,$addressType,$sortOrder,$type)
    {
        if($type == 'title'){
            return $customField = [
                'component' => 'VBA_CompanyInvoiceDetails/js/title',
                'config' => [
                    'template' => 'VBA_CompanyInvoiceDetails/title',
                ],
                'sortOrder' => $sortOrder
            ];
        }

        return $customField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => $code != 'company' ? $addressType.'.custom_attributes' : '',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => $code != 'company' ? $addressType.'.custom_attributes' . '.' . $code : $addressType.'.'.$code,
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


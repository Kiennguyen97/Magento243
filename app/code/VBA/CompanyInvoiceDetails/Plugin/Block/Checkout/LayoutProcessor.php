<?php

namespace VBA\CompanyInvoiceDetails\Plugin\Block\Checkout;

class LayoutProcessor
{
    /**
     * @var array
     */
    private $customAttributes = [
        'company_name',
        'company_legal_name',
        'company_address',
        'vat_tax',
        'company_representative',
        'company_email'
    ];

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
                                                         $jsLayout
    )
    {
        $sortOrder = 300;
        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children'])) {
            foreach ($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'] as $key => $payment) {
                $paymentCode = 'billingAddress' . str_replace('-form', '', $key);
                foreach ($this->customAttributes as $customAttributeCode) {
                    $sortOrder += 10;
                    $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$key]['children']['form-fields']['children'][$customAttributeCode] = $this->getCustomAttributeForAddress($paymentCode, $customAttributeCode, $sortOrder);
                    if (isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset'])
                    ) {
                        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode] = $this->getCustomAttributeForAddress('shippingAddress', $customAttributeCode, $sortOrder);
                    }
                }
            }

        }

        return $jsLayout;
    }

    protected function getCustomAttributeForAddress($addressType, $attributeCode, $sortOrder)
    {
        $label = $attributeCode == 'vat_tax' ? 'VAT / TAX ID' : ucwords(str_replace('_', ' ', $attributeCode));
        $data = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => $addressType . '.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => $addressType . '.custom_attributes' . '.' . $attributeCode,
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

        if ($attributeCode == 'company_email') {
            $data['validation']['validate-email'] = true;
        }

        return $data;
    }
}

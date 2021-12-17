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
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        $this->jsLayout = $jsLayout;

        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children']))
        {
            $configuration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'];
            foreach ($configuration as $paymentGroup => $groupConfig) {
                if (isset($groupConfig['component']) AND $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {
                    $this->generateFieldPayment('company_invoice_details', 'Company invoice details', $paymentGroup, $groupConfig, 280);
                    $this->generateFieldPayment('company', 'Company', $paymentGroup, $groupConfig, 290);
                    $this->generateFieldPayment('company_legal_name', 'Company Legal Name', $paymentGroup, $groupConfig, 300);
                    $this->generateFieldPayment('company_address', 'Company Address', $paymentGroup, $groupConfig, 310);
                    $this->generateFieldPayment('vat_tax', 'VAT/TAX ID', $paymentGroup, $groupConfig, 320);
                    $this->generateFieldPayment('company_representative', 'Company Representative', $paymentGroup, $groupConfig, 330);
                    $this->generateFieldPayment('company_email', 'Company Email', $paymentGroup, $groupConfig, 340);
                }
            }
        }

        if(isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset'])
        ){
            $this->generateFieldShipping('company_invoice_details','Company invoice details', 280);
            $this->generateFieldShipping('company', 'Company', 290);
            $this->generateFieldShipping('company_legal_name', 'Company Legal Name', 300);
            $this->generateFieldShipping('company_address', 'Company Address',310);
            $this->generateFieldShipping('vat_tax', 'VAT/TAX ID',  320);
            $this->generateFieldShipping('company_representative', 'Company Representative',  330);
            $this->generateFieldShipping('company_email', 'Company Email', 340);
        }

        return $this->jsLayout;
    }

    /** Declare Specific Payment
     * @return void
     */

    public function generateFieldPayment($code, $label, $paymentGroup, $groupConfig, $sortOrder){
        $this->jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children'][$code] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'id' => $code,
            ],
            'dataScope' => $groupConfig['dataScopePrefix'] . '.'.$code,
            'label' => __($label),
            'provider' => 'checkoutProvider',
            'additionalClasses' => $code,
            'visible' => true,
            'sortOrder' => $sortOrder,
            'id' => $code
        ];

        return $this->jsLayout;
    }

    /**
     * @param $code
     * @param $label
     * @param $sortOrder
     * @return mixed
     */
    public function generateFieldShipping($code, $label, $sortOrder){
        $this->jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$code] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $code,
            'label' => $label,
            'provider' => 'checkoutProvider',
            'sortOrder' => $sortOrder,
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];

        return $this->jsLayout;
    }


}


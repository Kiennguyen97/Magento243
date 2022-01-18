<?php

namespace VBA\CompanyInvoiceDetails\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config;

class CustomerAddressAttributes implements DataPatchInterface
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
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var Config
     */
    private $eavConfig;

    public function __construct(
        Config                   $eavConfig,
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory
    )
    {

        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $sortOrder = 100;
        foreach ($this->customAttributes as $customAttributeCode) {
            $sortOrder += 10;
            $data = [
                'type' => 'varchar',
                'input' => 'text',
                'label' => ucwords(str_replace('_', ' ', $customAttributeCode)),
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'system' => false,
                'group' => 'General',
                'sort_order' => $sortOrder,
                'global' => true,
                'visible_on_front' => true,
            ];

            if ($customAttributeCode == 'company_email') {
                $data['frontend_class'] = 'validate-email';
            }

            $eavSetup->addAttribute('customer_address', $customAttributeCode, $data);

            $customAttribute = $this->eavConfig->getAttribute('customer_address', $customAttributeCode);
            $customAttribute->setData(
                'used_in_forms',
                ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
            );

            $customAttribute->save();
        }
    }
}

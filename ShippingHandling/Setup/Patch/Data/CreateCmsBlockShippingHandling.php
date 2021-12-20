<?php


namespace Gssi\ShippingHandling\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class CreateCmsBlockShippingHandling implements DataPatchInterface, PatchVersionInterface
{
    private $blockFactory;
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * CreateCmsBlockShippingHandling constructor.
     * @param PageFactory $pageFactory
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        PageFactory $pageFactory,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $blockFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {

        $blockData = [
            'title' => 'Shipping Handling Product',
            'identifier' => 'shipping-handling-content-product',
            'stores' => [0],
            'is_active' => 1,
            'content' => '<h4 class="extra-fees-title">EIN/SSN information required.</h4>
<div class="extra-fees-description">This information is required by US Customs and Border Protection (CPB) for goods moving across the border. <a href="{{store direct_url="shipping-handling"}}" target="_blank">Learn more</a></div>',
        ];

        $this->blockFactory->create()->setData($blockData)->save();
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
    public static function getVersion()
    {
        return '2.2.1';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

}

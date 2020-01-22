<?php

namespace DTN\Ingredient\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}
	
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'ingredient',
            [
                'type' => 'varchar',
                'label' => 'Ingredients',
                'input' => 'multiselect',
                'required' => false,
                'source' => 'DTN\Ingredient\Model\Config\Source\Option',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'sort_order' => 20,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible_in_advanced_search'  => false,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => true,
                'visible' => true,
                'user_defined' => false,
                'searchable' => false,
                'filterable' => false,
            ]
        );
    }
}
<?php

namespace DTN\Ingredient\Block\Product\View;

use DTN\Ingredient\Model\IngredientFactory;

class Ingredient extends \Magento\Framework\View\Element\Template
{
    protected $_registry;
    protected $_ingredientFactory;
        
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        IngredientFactory $ingredientFactory,      
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {      
        $this->_ingredientFactory = $ingredientFactory;  
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }
    
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    public function getCurrentProduct()
    {        
        return $this->_registry->registry('current_product');
    }

    public function getCurrentattribute()
    {        
        $data =  $this->getCurrentProduct();
        $ingredient_id = (explode(",", $data->getIngredient()));
        return $ingredient_id;
    }
    
    public function getIngredientById()
    {
        $ingredient = $this->_ingredientFactory->create()->getCollection()
        ->addFieldToFilter('ingredient_id', array('in' => array($this->getCurrentattribute())))
        ->getData();
        return $ingredient;
    }  
}
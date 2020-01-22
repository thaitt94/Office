<?php

namespace DTN\Ingredient\Controller\Adminhtml\Ingredient;

class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = "DTN_Ingredient::ingredient";
    protected $_pageFactory;
    private $_registry;
    private $_ingredientFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \DTN\Ingredient\Model\IngredientFactory $ingredientFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Registry $registry  
    ) 
    {
        $this->_ingredientFactory = $ingredientFactory;  
        $this->_pageFactory = $pageFactory;
        $this->_registry = $registry;        
        parent::__construct($context);
    }

    public function execute() 
    {
        $ingredient= $this->_ingredientFactory->create();
         
        $id = $this->getRequest()->getParam('ingredient_id');
        if($id){
            $data = $ingredient->load($id);
            if(!$ingredient->getId()){
               return $this->_redirect('dtn/ingredient/index');
            }
        }
        $this->_registry->register('ingredient',$ingredient);
        $resultPage =$this->_pageFactory->create();
        $resultPage->getConfig()->setKeywords(__('Edit Page'));
        $resultPage->setActiveMenu('DTN_Ingredient::main_menu');
        $resultPage->getConfig()->getTitle()->prepend('Ingredient');
        if($ingredient->getId()) {
            $pageTitle = __('Edit',$data);
        } else {
            $pageTitle = __('New Ingredient');
        }
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;
    }
}
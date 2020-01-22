<?php

namespace DTN\Office\Controller\Adminhtml\Department;

class Edit extends \Magento\Backend\App\Action
{
  protected $_pageFactory;
  private $_registry;
  private $_departmentFactory;
  const ADMIN_RESOURCE = "DTN_Office::department";

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \DTN\Office\Model\DepartmentFactory $departmentFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Registry $registry  
    ) {
        $this->_departmentFactory = $departmentFactory;  
        $this->_pageFactory = $pageFactory;
        $this->_registry = $registry;        
        parent::__construct($context);
    }

    public function execute() {
        
        /**
         * init Model using Model Factory
         */
        $department= $this->_departmentFactory->create();
        /**
         * for  update a row data, we need  primary  field value
         * which URL param "example_id" = Database example table "id" field
         */ 
        $id = $this->getRequest()->getParam('entity_id');
        if($id){
            /**
             * Load a record data from data using model
             */
            $department->load($id);
            /**
             * Redirect to listing page if a record does not exit at database 
             * with request parameter
             */
            if(!$department->getId()){
               
               return $this->_redirect('dtn/department/index');
            }
            
        }
        /**
         * Save Model Data to a registry variable for future purpose
         * Variable name is user defined
         */
        $this->_registry->register('departmentFactory',$department);
        
        $resultPage =$this->_pageFactory->create();
        $resultPage->getConfig()->setKeywords(__('Edit Page'));
        /**
         * Left menu Select
         */
        $resultPage->setActiveMenu('DTN_Office::main_menu');
        $resultPage->getConfig()->getTitle()->prepend('Department Module');
        if($department->getId()) {
            $pageTitle = __('Edit',$department->getId());
        } else {
            $pageTitle = __('New Department');
        }
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;
        
    }
}
<?php

namespace DTN\Office\Controller\Adminhtml\Employee;

class Edit extends \Magento\Backend\App\Action
{
  protected $_pageFactory;
  private $_registry;
  private $_employeeFactory;
  const ADMIN_RESOURCE = "DTN_Office::employee";

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \DTN\Office\Model\EmployeeFactory $employeeFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Registry $registry  
    ) {
        $this->_employeeFactory = $employeeFactory;  
        $this->_pageFactory = $pageFactory;
        $this->_registry = $registry;        
        parent::__construct($context);
    }

    public function execute() {
        
        /**
         * init Model using Model Factory
         */
        $employee= $this->_employeeFactory->create();
        /**
         * for  update a row data, we need  primary  field value
         * which URL param "example_id" = Database example table "id" field
         */ 
        $id = $this->getRequest()->getParam('employee_id');
        if($id){
            $employee->load($id);
            
            if(!$employee->getId()){
               
               return $this->_redirect('dtn/employee/index');
            }
            
        }
        $this->_registry->register('employee',$employee);
        
        $resultPage =$this->_pageFactory->create();
        $resultPage->getConfig()->setKeywords(__('Edit Page'));
        
        $resultPage->setActiveMenu('DTN_Office::main_menu');
        $resultPage->getConfig()->getTitle()->prepend('employee Module');
        if($employee->getId()) {
            $pageTitle = __('Edit',$employee->getId());
        } else {
            $pageTitle = __('New employee');
        }
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;
        
    }
}
<?php


namespace DTN\Office\Controller\Adminhtml\Department;


class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE ="DTN_Office::main_menu"; 
    private $_departmentFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \DTN\Office\Model\DepartmentFactory $departmentFactory   
    ) {
        $this->_departmentFactory = $departmentFactory; 
       parent::__construct($context);

    }
    
    public function execute() 
    {
        
      $resultRedirect = $this->resultRedirectFactory->create();   
        // Get Record id from Url parameters  
        $id = $this->getRequest()->getParam('entity_id');
        if($id){
            $department = $this->_departmentFactory->create()->load($id);
            if($department->getId()){
                try{
                    $department->delete();
                    $this->messageManager->addSuccessMessage(__('The department has been delete successfully'));                    
                } catch (\Exception $ex) {
                    $this->messageManager->addErrorMessage(__('Something went wrong while delete'));
                }

                // after delete Record ,return to Listing page
                return $resultRedirect->setPath('*/*/');
            }

        }
        $this->messageManager->addErrorMessage(__('The Record does not exits'));
        //  Return to Listing page
        return $resultRedirect->setPath('*/*/');       
    }

}

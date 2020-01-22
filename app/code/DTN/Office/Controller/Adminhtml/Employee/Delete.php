<?php

namespace DTN\Office\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use DTN\Office\Model\EmployeeFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Model\View\Result\Redirect;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    
    private $_employeeFactory;    
    private $resultRedirect;
    
    public function __construct(
        Context $context,
        EmployeeFactory $employeeFactory
    )
    {
        $this->_employeeFactory = $employeeFactory;        
        parent::__construct($context);
    }

    public function execute()
    {
      $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('employee_id');
        $employee = $this->_employeeFactory->create()->load($id);
        if ($employee->getId()) {
            
            try {
                $employee->delete();
                $this->messageManager->addSuccess(__('Employee was deleted successfully'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['_current' => true]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}

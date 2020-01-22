<?php

namespace DTN\Office\Controller\Employee;

use Magento\Framework\View\Element\Messages;
 
class Delete extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_request;
	protected $_employeeFactory;
 
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\App\Request\Http $request,
		\DTN\Office\Model\EmployeeFactory $employeeFactory
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->_request = $request;
		$this->_employeeFactory = $employeeFactory;
		return parent::__construct($context);	
	}
 
	public function execute()
	{	
		$id = $this->_request->getParam('id');
		// echo $id; 
		$employee = $this->_employeeFactory->create()->load($id);
		
		if($employee->delete()) {
			$this->messageManager->addSuccessMessage(__($employee['fisrtname'].' '.$employee['lastname'].' delete success.'));
		} else {
			$this->messageManager->addSuccessMessage(__($employee['fisrtname'].' '.$employee['lastname'].' delete failed.'));
		}
		return $this->_redirect('office/employee/index');		
	}
	
}

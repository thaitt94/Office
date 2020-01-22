<?php 

namespace DTN\Office\Controller\Employee;

use DTN\Office\Model\EmployeeFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Element\Messages;

class Update extends Action
{

	/**
	 * @var PageFactory
	 */

	protected $pageFactory;

	/**
	 * @var employeeFactory
	 */

	protected $_employeeFactory;

	public function __construct(
		Context $context,
		PageFactory $pageFactory,
		EmployeeFactory $employeeFactory
	)
	{
		parent::__construct($context);
		$this->pageFactory = $pageFactory;
		$this->_employeeFactory = $employeeFactory;
	}

	/** 
	 *	@return \Magento\Framework\View\Result\Page
	 */
	public function execute()
	{
		// get data from form entry form
		$params = $this->getRequest()->getParams();
		$id = $params['employee_id'];
		// echo $id;
		// load data where condition = $id
		$employee = $this->_employeeFactory->create()->load($id);

		// // save data status
		if($employee->getId()){

			if ($employee->setData($params)->save()) {

		  		$this->messageManager->addSuccessMessage(__($employee['firstname'].' updated data success.'));

			} else {

			  	$this->messageManager->addErrorMessage(__($employee['firstname'].' updated data failed, please try again.'));
			}
		
		return $this->_redirect('office/employee/index');
		}
		
	}

}
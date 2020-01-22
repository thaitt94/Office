<?php 

namespace DTN\Office\Controller\Employee;

use DTN\Office\Model\EmployeeFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Element\Messages;

class Insert extends Action
{    
	/**
	 * @var PageFactory
	 */
	protected $pageFactory;

	/**
	 *	@var DepartmentFactory
	 */
	protected $_employeeFactory;

	/**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param DepartmentFactory $departmentFactory
     * @param EmployeeFactory $employeeFactory
     */

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
	* Index Action
	*
	* @return \Magento\Framework\View\Result\Page
	*/

	public function execute()
	{
		$data = $this->getRequest()->getParams();
		// print_r($data);

		if (empty($data)) {
			return $this->_redirect('office/employee/index');
		} else {

			$employee = $this->_employeeFactory->create();
			$result = $employee->setData($data)->save();

			if($result){

			  $this->messageManager->addSuccessMessage(__($employee['firstname']. ' '.$employee['lastname'].' added success.'));

			} else {

			  $this->messageManager->addErrorMessage(__($employee['firstname']. ' '.$employee['lastname'].' added failed.'));
			}
			return $this->_redirect('office/employee/index');
		}
	}
}

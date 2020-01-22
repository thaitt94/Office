<?php 

namespace DTN\Office\Controller\Department;

use DTN\Office\Model\DepartmentFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Element\Messages;

class Insert extends Action
{    
	/**
	 * @var PageFactory
	 */
	protected $_pageFactory;

	/**
	 *	@var DepartmentFactory
	 */
	protected $_departmentFactory;

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
		DepartmentFactory $departmentFactory
	)
	{
		parent::__construct($context);
		$this->_pageFactory = $pageFactory;
		$this->_departmentFactory = $departmentFactory;
	}

	/**
	* Index Action
	*
	* @return \Magento\Framework\View\Result\Page
	*/

	public function execute()
	{
		$data = $this->getRequest()->getParams();

		if (!empty($data)) {
			$department = $this->_departmentFactory->create();
			$savedepartment= $department->setData($data)->save();

			if($savedepartment){

			$this->messageManager->addSuccessMessage(__($data['name'].' added success.'));

			} else {

			  $this->messageManager->addErrorMessage(__($data['name'].' added failed.'));
			}
			return $this->_redirect('office/department/index');
		}
		return $this->messageManager->addErrorMessage(__($data['name'].' added failed.'));
	}
}
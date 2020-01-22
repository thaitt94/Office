<?php 

namespace DTN\Office\Controller\Department;

use DTN\Office\Model\DepartmentFactory;
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
	 * @var DepartmentFactory
	 */

	protected $_departmentFactory;

	/**
	  * Edit constructor
	  * @param Context $context
	  * @param PageFactory $pageFactory
	  * @param DepartmentFactory
	  $departmentFactory
	  */

	public function __construct(
		Context $context,
		PageFactory $pageFactory,
		DepartmentFactory $departmentFactory
	)
	{
		parent::__construct($context);
		$this->pageFactory = $pageFactory;
		$this->_departmentFactory = $departmentFactory;
	}

	/** 
	 *	@return \Magento\Framework\View\Result\Page
	 */
	public function execute()
	{
		// get data from form entry
		$params = $this->getRequest()->getParams();
		$id= $params['entity_id'];
		// load data where $param
		$department = $this->_departmentFactory->create()->load($id);
		if($department->getId()){
			// save data 
		$department->setData($params)->save();
		}
		return $this->_redirect('office/department/index');
	}

}
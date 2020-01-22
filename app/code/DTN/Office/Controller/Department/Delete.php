<?php

namespace DTN\Office\Controller\Department;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\Messages;
 
class Delete extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_request;
	protected $_departmentFactory;
 
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\App\Request\Http $request,
		\DTN\Office\Model\DepartmentFactory $departmentFactory,
		ResourceConnection $resourceConnection
		)
	{
		$this->resourceConnection = $resourceConnection;
		$this->_pageFactory = $pageFactory;
		$this->_request = $request;
		$this->_departmentFactory = $departmentFactory;
		return parent::__construct($context);	
	}
 
	public function execute()
	{	
		$id = $this->_request->getParam('id');
		// echo $id;    
		$department = $this->_departmentFactory->create()->load($id)->delete();
		if($department) {
			$this->messageManager->addSuccessMessage(__('Delete successfully.'));
		} else {
			$this->messageManager->addSuccessMessage(__('Delete failed.'));
		}
		return $this->_redirect('office/department/index');		
	}
	
}
<?php

namespace DTN\Office\Block;

use DTN\Office\Model\DepartmentFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;



class Department extends \Magento\Framework\View\Element\Template
{
    protected $_coreRegistry;
    protected $_departmentFactory;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Element\Template\Context $context,
        \DTN\Office\Model\DepartmentFactory $departmentFactory
    )
    {
        $this->_departmentFactory = $departmentFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);

    }

    public function _prepareLayout()
    {
        if ($this->getDepartment()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'dtn.office.pager'
            )
            ->setAvailableLimit(array(5=>5,10=>10,15=>15))
            ->setShowPerPage(true)->setCollection(
                $this->getDepartment()
            );
            $this->setChild('pager', $pager);
            $this->getDepartment()->load();
        }
        return parent::_prepareLayout();
    }

    public function getDepartment()
    {
        // if user click on the number of page so on url will show on domain/router_name/controller_name/action_name/$page, if not will show like domain/router_name/controller_name/action_name/1
        $page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        // limit record from query
        $pageSize = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 5;
        $department = $this->_departmentFactory->create()->getCollection();

        if($this->getRequest()->getParam('_department') === 'equal'){
            $department->addFieldToFilter('entity_id',['eq' => 26]);
        } else {
            if($this->getRequest()->getParam('_department') === 'I') {
                $department->addFieldToFilter('name',['like' => 'i%']);
            } else {
                return $department;
            }
        }
        
        $department->setOrder('entity_id','DESC');
        $department->setPageSize($pageSize);
        $department->setCurPage($page);

        return $department;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getEditRecord()
    {
        $id = $this->_coreRegistry->registry('editRecordId');       
        $department = $this->_departmentFactory->create();
        $result = $department->load($id)->getData();       
        return $result;
    }

    public function SaveEditRecord()
    {
        return '/office/department/update';
    }

    public function addNew()
    {   
        return '/office/department/insert';
    }

}
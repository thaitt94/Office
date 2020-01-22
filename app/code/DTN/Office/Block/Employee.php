<?php

namespace DTN\Office\Block;

use DTN\Office\Model\EmployeeFactory;
use DTN\Office\Model\DepartmentFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;

class Employee extends \Magento\Framework\View\Element\Template
{
    const DEPARTMENTTABLE = "dtn_office_department";
    const EMPLOYEETABLE = "dtn_office_employee_entity";

    protected $_coreRegistry;
    protected $_employeeFactory;
    protected $_departmentFactory;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Element\Template\Context $context,
        \DTN\Office\Model\EmployeeFactory $employeeFactory,
        \DTN\Office\Model\DepartmentFactory $departmentFactory
    )
    {
        $this->_departmentFactory = $departmentFactory;
        $this->_employeeFactory = $employeeFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);

    }

    public function getDepartment()
    {
        return $this->_departmentFactory->create()->getCollection();
    }

    public function _prepareLayout()
    {
        if ($this->getEmployee()) :
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'dtn.office.pager'
            )
            ->setAvailableLimit(array(5=>5,10=>10,15=>15))
            ->setShowPerPage(true)->setCollection(
                $this->getEmployee()
            );
            $this->setChild('pager', $pager);
            $this->getEmployee()->load();
        endif;
        return parent::_prepareLayout();
    }

    public function getEmployee()
    {
        $page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 5;
        $employee = $this->_employeeFactory->create()->getCollection();
        if($this->getRequest()->getParam('e_salary') === 'salary') {
            $employee->addFieldToFilter('salary', ['gteq' => 10]);
        } else {
            if ($this->getRequest()->getParam('e_salary') === 'less') {
                $employee->addFieldToFilter('salary', ['lt' => 10]);
            } else {
                if($this->getRequest()->getParam('e_salary') === 'It') {
                    $employee->addFieldToFilter('department_id', ['lt' => 22]);
                } else {
                    if($this->getRequest()->getParam('e_salary') === 'w_y') {
                        // one years before variable
                        $condition = date('Y-m-d', strtotime('-1 year'));
                        $employee->addFieldToFilter('workingdate', ['lteq' => $condition]);
                    } else {
                        if($this->getRequest()->getParam('e_salary') === 'between') {
                            $begin_of_month = date("Y-m-d", strtotime("first day of this month"));
                            $end_of_month = date("Y-m-d", strtotime("last day of this month"));
                            $employee->addFieldToFilter('workingdate', ['gteq' => $begin_of_month]);
                            $employee->addFieldToFilter('workingdate', ['lteq' => $end_of_month]);
                        } else {
                            if($this->getRequest()->getParam('e_salary') === 'dob_1') {
                                $condition = date('Y-01-d');
                                $employee->addFieldToFilter('dob', ['like' => '%'.$condition.'%']);
                            } else {
                                return $employee;
                            }
                        }
                    }
                }
            }
        }
        $employee->setOrder('employee_id','DESC'); 
        $employee->setPageSize($pageSize);
        $employee->setCurPage($page);
        return $employee;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    // join 2 table of employee and department.
    public function join()
    {  
        $collection = $this->_employeeFactory->create()->getCollection();
         
        $collection->getSelect()->join(
            array('department' => self::DEPARTMENTTABLE),
            'main_table.department_id = department.entity_id');

        return $collection->getData();
    }

    public function addEmployee()
    {   
        return '/office/employee/insert';
    }

    public function delete()
    {   
        return '/office/employee/delete';
    }

    public function editRecord()
    {
        $id = $this->_coreRegistry->registry('editRecordId');      
        $employee = $this->_employeeFactory->create();
        return $employee->load($id)->getData();
        // return $id;
    }

    public function edit()
    {   
        return '/office/employee/edit';
    }

    public function update()
    {   
        return '/office/employee/update';
    }

}

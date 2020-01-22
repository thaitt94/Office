<?php 

namespace DTN\Office\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use DTN\Office\Model\EmployeeFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    private $_employeeFactory;
    private $_resultRedirect;
    private $_dataPersistor;
    /**
     * @param Action\Context $context
     * @param \Doan\Office\Model\employeeFactoryl $employeeFactory
     */
    public function __construct(
        Context $context,
        EmployeeFactory $employeeFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->_employeeFactory = $employeeFactory;
        $this->_dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

     public function execute()
    {
        $data = $this->getRequest()->getParams();
        $data['image'] = $this->_avatar($data);
        if(empty($data['employee_id'])){
            $employee = $this->_employeeFactory->create();
        } else {
            $id  = $data['employee_id'];
            $employee = $this->_employeeFactory->create()->load($id);
            if($employee->getId()){
                $employee = $this->_employeeFactory->create()->load($id);
            }
        }
        // echo "<pre>";
        // print_r($data);
        $employee->setDepartment_id($data['department_id']);
        $employee->setEmail($data['email']);
        $employee->setFirstname($data['firstname']);
        $employee->setLastname($data['lastname']);
        $employee->setDob($data['dob']);
        $employee->setWorkingdate($data['workingdate']);
        $employee->setSalary($data['salary']);
        $employee->setImage($data['image']);
        $employee->save();
        $this->messageManager->addSuccessMessage(__('You have been saved employee successfully.'));
        if ($this->getRequest()->getParam('back')) {
            return $this->_redirect('*/*/edit', ['employee_id' => $employee->getId(), '_current' => true]);
        }
            
        return $this->_redirect('*/*/');
    }

    public function _avatar(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = 'avatar.jpg';
        }
        return $data['image'];
    }
}
<?php 

namespace DTN\Office\Controller\Adminhtml\Department;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use DTN\Office\Model\DepartmentFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    private $_dataPersistor;
    private $_departmentFactory;
    private $_resultRedirect;
  
    public function __construct(
        Context $context,
        DepartmentFactory $departmentFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->_departmentFactory = $departmentFactory;
        $this->_dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

     public function execute()
    {
       $data = $this->getRequest()->getPostValue();
       $data['images'] = $this->_avatar($data);
        if(empty($data['entity_id'])){
            $department = $this->_departmentFactory->create();
        } else {
            $id  = $data['entity_id'];
            $department = $this->_departmentFactory->create()->load($id);
            if($department->getId()){
                $department = $this->_departmentFactory->create()->load($id);
            }
        }
        $department->setData($data)->save();
        try {
            $this->messageManager->addSuccessMessage(__('You have been saved department successed.'));
            if ($this->getRequest()->getParam('back')) {
                return $this->_redirect('*/*/edit', ['entity_id' => $department->getId(), '_current' => true]);
            }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        return $this->_redirect('*/*/');
    }

    public function _avatar(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['images'][0]['name'])) {
            $data['images'] = $data['images'][0]['name'];
        } else {
            $data['images'] = 'avatar.jpg';
        }
        return $data['images'];
    }
}
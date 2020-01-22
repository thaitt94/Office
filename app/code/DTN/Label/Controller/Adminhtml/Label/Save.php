<?php 

namespace DTN\Label\Controller\Adminhtml\Label;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use DTN\Label\Model\LabelFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = "DTN_Label::label";
    private $_labelFactory;
    private $_resultRedirect;
    private $_dataPersistor;
    
    public function __construct(
        Context $context,
        LabelFactory $labelFactory,
        DataPersistorInterface $dataPersistor
    ) 
    {
        $this->_labelFactory = $labelFactory;
        $this->_dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $data['image'] = $this->_avatar($data);

        if(empty($this->getRequest()->getParam('label_id'))) {
            $label = $this->_labelFactory->create();
        } else {
            $id  = $this->getRequest()->getParam('label_id');
            $label = $this->_labelFactory->create()->load($id);
            if(!$label->getId()){
                $this->messageManager->addSuccessMessage(__('Label dose not exits.'));
            }
        }
        // echo "<pre>";
        // print_r($this->getRequest()->getParams('data'));
        $label->setName($data['name']);
        $label->setImage($data['image']);
        // $label->setLabel_type($data['label_type']);
        $label->setLabel_text_size($data['label_text_size']);
        $label->setAdvance_setting($data['advance_setting']);
        $label->save();
        $this->messageManager->addSuccessMessage(__('Label saved successfully.'));
        return $this->_redirect('*/*/');
    }

    public function _avatar(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        }
        return $data['image'];
    }
}
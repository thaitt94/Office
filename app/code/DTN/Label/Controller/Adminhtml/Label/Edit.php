<?php

namespace DTN\Label\Controller\Adminhtml\Label;

class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = "DTN_Label::label";
    protected $_pageFactory;
    private $_registry;
    private $_labelFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \DTN\Label\Model\LabelFactory $labelFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Registry $registry  
    ) 
    {
        $this->_labelFactory = $labelFactory;  
        $this->_pageFactory = $pageFactory;
        $this->_registry = $registry;        
        parent::__construct($context);
    }

    public function execute() 
    {
        $label= $this->_labelFactory->create();
        $id = $this->getRequest()->getParam('label_id');
        if($id){
            $data = $label->load($id);
            if(!$label->getId()){
               return $this->_redirect('dtn/label/index');
            }
        }
        $this->_registry->register('label',$label);
        $resultPage =$this->_pageFactory->create();
        $resultPage->getConfig()->setKeywords(__('Edit Page'));
        $resultPage->setActiveMenu('DTN_Label::main_menu');
        $resultPage->getConfig()->getTitle()->prepend('Label');
        if($label->getId()) {
            $pageTitle = __('Edit',$data);
        } else {
            $pageTitle = __('New Label');
        }
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;
    }
}
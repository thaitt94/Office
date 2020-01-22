<?php

namespace DTN\Ingredient\Controller\Adminhtml\Ingredient;

class NewAction extends \Magento\Backend\App\Action
{

    private $resultForwardFactory;

    const ADMIN_RESOURCE ="DTN_Ingredient::ingredient";
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory    
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);

    }
    public function execute() 
    {
        $resultForward = $this->resultForwardFactory->create();
        /**
         * Forward to edit page;
         */
        return $resultForward->forward('edit');
    }

}
<?php

namespace DTN\Office\Controller\Adminhtml\Department;

class InlineEdit extends \Magento\Backend\App\Action
{

    protected $jsonFactory;
    protected $_departmentFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \DTN\Office\Model\Department $departmentFactory
    )
    {
        $this->jsonFactory = $jsonFactory;
        $this->_departmentFactory = $departmentFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $id) {
                    /** @var \Magento\Cms\Model\Block $block */
                    $department = $this->_departmentFactory->create()->load($id);
                    try {
                        $department->setData(array_merge($department->getData(), $postItems[$id]));
                        $department->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Mytesting ID: {$id}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
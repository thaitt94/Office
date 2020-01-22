<?php

namespace DTN\Office\Controller\Adminhtml\Employee;

class InlineEdit extends \Magento\Backend\App\Action
{

    protected $jsonFactory;
    protected $_employeeeFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \DTN\Office\Model\Employee $employeeFactory
    )
    {
        $this->jsonFactory = $jsonFactory;
        $this->_employeeeFactory = $employeeeFactory;
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
                    $employee = $this->_employeeeFactory->create()->load($id);
                    try {
                        $employee->setData(array_merge($employee->getData(), $postItems[$id]));
                        $employee->save();
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
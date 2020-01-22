<?php

namespace DTN\Office\Ui\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
/**
 * Class BlockActions
 */
class EmployeeActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'dtn/employee/edit';
    const URL_PATH_DELETE = 'dtn/employee/delete';

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    
    public function prepareDataSource(array $dataSource)
    {

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['employee_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->_urlBuilder->getUrl(
                                self::URL_PATH_EDIT,
                                [
                                    'employee_id' => $item['employee_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->_urlBuilder->getUrl(
                                self::URL_PATH_DELETE,
                                [
                                    'employee_id' => $item['employee_id']
                                ]
                            ),
                            'post' => true,
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.name }"'),
                                'message' => __('Are you sure you want to delete a "${ $.$data.name }" record?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }

}

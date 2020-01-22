<?php

namespace DTN\Office\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    const EMPAGE = 'office/employee/index';
    const DPPAGE = 'office/department/index';
    const BASEURL = 'http://magento233.local/';

    /**
     * @var NodeFactory
     */
    protected $_nodeFactory;

    public function __construct(
        NodeFactory $nodeFactory
    ) {
        $this->_nodeFactory = $nodeFactory;
    }

    /**
     *
     * Inject node into menu.
     **/
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    )
    {

        $department = $this->_nodeFactory->create(
            [
                'data' => $this->getNodeAsArray()[1],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );

        $employee = $this->_nodeFactory->create(
            [
                'data' => $this->getNodeAsArray()[2],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );

        $dtn = $this->_nodeFactory->create(
            [
                'data' => $this->getNodeAsArray()[0],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        )->addChild($department)
         ->addChild($employee);
        $subject->getMenu()->addChild($dtn);
    }

    /**
     *
     * Build node
     **/
    protected function getNodeAsArray()
    {
        return [
            [
                'name' => __('DTN'),
                'id' => 'dtn',
                'url' => self::BASEURL.self::EMPAGE,
                'has_active' => false,
                'is_active' => false
            ],
            [
                'name' => __('Department'),
                'id' => 'dtn_department',
                'url' => self::BASEURL.self::DPPAGE,
                'has_active' => true,
                'is_active' => false
            ],
            [
                'name' => __('Employee'),
                'id' => 'dtn_employee',
                'url' => self::BASEURL.self::EMPAGE,
                'has_active' => true,
                'is_active' => false
            ]
            
        ];
    }
}
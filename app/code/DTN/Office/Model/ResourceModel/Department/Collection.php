<?php

namespace DTN\Office\Model\ResourceModel\Department;

/*
 * Class tạo ra một collection cho module
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\DTN\Office\Model\Department::class, 
            \DTN\Office\Model\ResourceModel\Department::class);
    }

}
<?php

namespace DTN\Office\Model\ResourceModel\Employee;

/*
 * Class tạo ra một collection cho module
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'employee_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\DTN\Office\Model\Employee::class, 
            \DTN\Office\Model\ResourceModel\Employee::class);
    }

}
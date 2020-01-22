<?php

namespace DTN\Office\Model;

/*
 * Class có nhiệm vụ tương tác với db thông qua resource model
 */
class Employee extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\DTN\Office\Model\ResourceModel\Employee::class);
    }
}
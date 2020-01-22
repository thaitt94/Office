<?php

namespace DTN\Office\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Employee extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dtn_office_employee_entity', 'employee_id');
    }

}
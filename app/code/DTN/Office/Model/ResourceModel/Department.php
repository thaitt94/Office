<?php

namespace DTN\Office\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Department extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dtn_office_department', 'entity_id');
    }

}
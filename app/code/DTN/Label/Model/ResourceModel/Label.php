<?php

namespace DTN\Label\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Label extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('product_label', 'label_id');
    }
}
<?php

namespace DTN\Label\Model\ResourceModel\Label;

/*
 * Class tạo ra một collection cho module
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'label_id';

    protected function _construct()
    {
        $this->_init(\DTN\Label\Model\Label::class, 
            \DTN\Label\Model\ResourceModel\Label::class);
    }

}
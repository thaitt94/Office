<?php

namespace DTN\Label\Model;

class Label extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\DTN\Label\Model\ResourceModel\Label::class);
    }
}
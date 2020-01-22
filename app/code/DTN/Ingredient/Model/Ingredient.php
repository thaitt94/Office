<?php

namespace DTN\Ingredient\Model;

class Ingredient extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\DTN\Ingredient\Model\ResourceModel\Ingredient::class);
    }
}
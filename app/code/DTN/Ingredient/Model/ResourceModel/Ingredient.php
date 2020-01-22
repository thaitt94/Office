<?php

namespace DTN\Ingredient\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Ingredient extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('ingredient_product', 'ingredient_id');
    }
}
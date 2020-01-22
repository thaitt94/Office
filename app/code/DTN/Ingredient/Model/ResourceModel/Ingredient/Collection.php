<?php

namespace DTN\Ingredient\Model\ResourceModel\Ingredient;

/*
 * Class tạo ra một collection cho module
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'ingredient_id';

    protected function _construct()
    {
        $this->_init(\DTN\Ingredient\Model\Ingredient::class, 
            \DTN\Ingredient\Model\ResourceModel\Ingredient::class);
    }

}
<?php

namespace DTN\Label\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use DTN\Label\Model\LabelFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;

class CustomLabel extends Template
{
    protected $_labelFactory;
    protected $_date;
    protected $storeManager;
    protected $_dateFactory;
    protected $cartModel;

    public function __construct(
        Context $context,
        LabelFactory $labelFactory,
        TimezoneInterface $date,
        StoreManagerInterface $storeManager,
        DateTimeFactory $dateFactory,
        \Magento\Checkout\Model\Cart $cartModel,
        array $data = []
    )
    {
        $this->cartModel = $cartModel;
        $this->_dateFactory = $dateFactory;
        $this->storeManager =  $storeManager;
        $this->_date =  $date;
        $this->_labelFactory = $labelFactory;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    public function getLabel()
    {
        $result = [];
        $pathImg = 'pub/media/dtn/tmp/label/';
        $label = $this->_labelFactory->create()->getCollection()
        ->load()->getData();
        foreach($label as $value) {
            if($value['name'] === 'FreeShipping'){
                $result['FreeShipping'] = '<img src = "'.$this->getBaseUrl().$pathImg.$value['image'].'" width="30" height="30">';
            } else {
                if($value['name'] === 'New'){
                    $result['New'] = '<div class="new_label"><img src = "'.$this->getBaseUrl().$pathImg.$value['image'].'" width="60px" height="60px"></div>';
                } else {
                    if($value['name'] === 'Sale'){
                        $result['Sale'] = '<img src = "'.$this->getBaseUrl().$pathImg.$value['image'].'" width="60px" height="60px">';
                    }
                }
            }
        }
        return $result;
    }

    public function getcurrentStoreTime()
    {
        return $this->_date->date()->format('Y-m-d H:i:s');
    }

    // public function timeZone()
    // {
    //     return $this->storeManager->getStore()->getConfig('general/locale/timezone');
    // }
    // //get timestamp save in datase 
    // public function test()
    // {
    //     return $this->_dateFactory->create()->gmtDate();
    // }
    // Get total weight of cart products
    // public function getWeightUnit()
    // {
    //     $items = $this->cartModel->getQuote()->getAllItems();
    //     $weight = 0;
    //     foreach($items as $item) {
    //         $weight += ($item->getWeight() * $item->getQty()) ;        
    //     }
    //     return $weight;
    // }

}

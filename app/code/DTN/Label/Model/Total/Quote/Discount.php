<?php

namespace DTN\Label\Model\Total\Quote;

class Discount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    protected $_priceCurrency;

    public function __construct(\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency)
    {
        $this->_priceCurrency = $priceCurrency;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote, 
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment, 
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        $baseDiscount = 5;
        $discount = $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('discount', -$discount);
        $total->addBaseTotalAmount('discount', -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
        $quote->setCustomDiscount(-$discount);
        return $this;
    }
}
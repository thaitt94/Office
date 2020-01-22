<?php

namespace DTN\Label\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class LabelType implements OptionSourceInterface
{
  public function toOptionArray()
  {
    return [
      ['label' => __('Choose'), 'value' => ''],
      ['label' => __('FreeShipping'), 'value' => 'FreeShipping'],
      ['label' => __('New'), 'value' => 'New'],
      ['label' => __('Sale'), 'value' => 'Sale'],
      ['label' => __('Discount Percentage'), 'value' => 'Discount Percentage']
    ];
  }
}
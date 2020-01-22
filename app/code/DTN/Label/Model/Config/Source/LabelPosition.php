<?php

namespace DTN\Label\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class LabelPosition implements OptionSourceInterface
{
  public function toOptionArray()
  {
    return [
      ['label' => __('Choose'), 'value' => ''],
      ['label' => __('Bottom Right'), 'value' => 'bottom_right'],
      ['label' => __('Bottom Left'), 'value' => 'bottom_left'],
      ['label' => __('Top Right'), 'value' => 'top_right'],
      ['label' => __('Top Left'), 'value' => 'top_left'],
      ['label' => __('Center Right'), 'value' => 'center_right'],
      ['label' => __('Center Left'), 'value' => 'center_left']
    ];
  }
}
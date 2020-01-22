<?php

namespace DTN\Office\Model\Config\Source;

class Department implements \Magento\Framework\Option\ArrayInterface
{
  protected $_departmentCollection;

    public function __construct(
    \DTN\Office\Model\DepartmentFactory $departmentCollection
  ) {
    $this->_departmentCollection = $departmentCollection;
  }

  public function toOptionArray()
  {

    // Load the employees as options
    $department = $this->_departmentCollection->create()->getCollection();
    $options = [];

    /* @todo: add query to load selected options */

    foreach ($department as $departments){
      $options[] = [
        "value" => $departments->getId(),
        "label" => $departments->getName()
      ];
    }

    return $options;
  }
}
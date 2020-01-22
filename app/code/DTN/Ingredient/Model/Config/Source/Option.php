<?php

namespace DTN\Ingredient\Model\Config\Source;

class Option extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
  protected $optionFactory;
  protected $_ingredientCollection;

  public function __construct(
    \DTN\Ingredient\Model\IngredientFactory $ingredientCollection
  ) 
  {
    $this->_ingredientCollection = $ingredientCollection;
  }

  public function getAllOptions()
  {
    $ingredient = $this->_ingredientCollection->create()->getCollection();
    $options = [];
    foreach ($ingredient as $ingredients){
      $options[] = [
        "value" => $ingredients->getId(),
        "label" => $ingredients->getName()
      ];
    }
    return $options;
  }
}
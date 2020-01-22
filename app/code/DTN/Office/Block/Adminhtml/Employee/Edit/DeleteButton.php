<?php

namespace DTN\Office\Block\Adminhtml\Department\Edit;

use DTN\Office\Ui\Listing\Columns\DepartmentActions;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
   //put your code here
   public function getButtonData(): array 
   {
       $data = [];
       /**
        * If Record exits on database then show delete button 
        */
       if($this->getId()){
            $params = ['entity_id' => $this->getId()];
                $data = [
                'label' => __('Delete Department'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                   'Are you sure you want to do this?'
                ) . '\', \'' . $this->getUrlBuilder()->getUrl(DepartmentActions::URL_PATH_DELETE, $params) . '\', {data: {}})',
               'sort_order' => 20,
           ];         
       }
       return $data;
   }

}
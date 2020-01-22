<?php 

namespace DTN\Ingredient\Controller\Adminhtml\Ingredient;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use DTN\Ingredient\Model\IngredientFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = "DTN_Ingredient::ingredient";
    private $_ingredientFactory;
    private $_resultRedirect;
    private $_dataPersistor;
    
    public function __construct(
        Context $context,
        IngredientFactory $ingredientFactory,
        DataPersistorInterface $dataPersistor
    ) 
    {
        $this->_ingredientFactory = $ingredientFactory;
        $this->_dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $data['image'] = $this->_avatar($data);

        if(empty($this->getRequest()->getParam('ingredient_id'))) {
            $ingredient = $this->_ingredientFactory->create();
        } else {
            $id  = $this->getRequest()->getParam('ingredient_id');
            $ingredient = $this->_ingredientFactory->create()->load($id);
            if(!$ingredient->getId()){
                $this->messageManager->addSuccessMessage(__('Ingredient dose not exits.'));
            }
        }
        // echo "<pre>";
        // print_r($data);
        $ingredient->setName($data['name']);
        $ingredient->setDescription($data['description']);
        $ingredient->setImage($data['image']);
        $ingredient->save();
        $this->messageManager->addSuccessMessage(__('Ingredient saved successfully.'));
        return $this->_redirect('*/*/');
    }

    public function _avatar(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        }
        return $data['image'];
    }
}
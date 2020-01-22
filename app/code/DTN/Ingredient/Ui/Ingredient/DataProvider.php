<?php 

namespace DTN\Ingredient\Ui\Ingredient;

use DTN\Ingredient\Model\ResourceModel\Ingredient\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    private $auth;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $ingredientCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?AuthorizationInterface $auth = null,
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
        $this->collection = $ingredientCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->auth = $auth ?? ObjectManager::getInstance()->get(AuthorizationInterface::class);
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $ingredient) {
            $this->loadedData[$ingredient->getId()] = $ingredient->getData();
            if ($ingredient->getImage()) {
                $m['image'][0]['name'] = $ingredient->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl().$ingredient->getImage();
                $fullData = $this->loadedData;
                $this->loadedData[$ingredient->getId()] = array_merge($fullData[$ingredient->getId()], $m);
            }
        }
        $data = $this->dataPersistor->get('dtn_ingredient_index');
        if (!empty($data)) {
            $ingredient = $this->collection->getNewEmptyItem();
            $ingredient->setData($data);
            $this->loadedData[$ingredient->getId()] = $ingredient->getData();
            $this->dataPersistor->clear('dtn_ingredient_index');
        }

        return $this->loadedData;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();

        if (!$this->auth->isAllowed('Dtn_Ingredient::save_design')) {
            $designMeta = [
                'design' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'disabled' => true
                            ]
                        ]
                    ]
                ],
                'custom_design_update' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'disabled' => true
                            ]
                        ]
                    ]
                ]
            ];
            $meta = array_merge_recursive($meta, $designMeta);
        }

        return $meta;
    }

    public function getMediaUrl()
    {
        return 'http://magento233.local/pub/media/dtn/tmp/ingredient/';
    }

}
<?php 

namespace DTN\Office\Ui\Department;

use DTN\Office\Model\ResourceModel\Department\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\AuthorizationInterface;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    const IMAGEPATH = 'http://magento233.local/pub/media/dtn/tmp/office/';
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    private $auth;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $departmentCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        AuthorizationInterface $auth = null,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
        $this->collection = $departmentCollectionFactory->create();
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
        /** @var $department \Dtn\Office\Model\Department */
        foreach ($items as $department) {
            $this->loadedData[$department->getId()] = $department->getData();
            if ($department->getImages()) {
                $m['images'][0]['name'] = $department->getImages();
                $m['images'][0]['url'] = $this->getMediaUrl().$department->getImages();
                $fullData = $this->loadedData;
                $this->loadedData[$department->getId()] = array_merge($fullData[$department->getId()], $m);
            }
        }

        $data = $this->dataPersistor->get('dtn_office_department');
        if (!empty($data)) {
            $department = $this->collection->getNewEmptyItem();
            $department->setData($data);
            $this->loadedData[$department->getId()] = $department->getData();
            $this->dataPersistor->clear('dtn_office_department');
        }

        return $this->loadedData;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();

        if (!$this->auth->isAllowed('Dtn_Office::save_design')) {
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
        // return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'dtn/tmp/office/';
        //  $mediaUrl;
        return self::IMAGEPATH;
    }

}
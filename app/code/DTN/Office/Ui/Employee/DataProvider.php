<?php 

namespace DTN\Office\Ui\Employee;

use DTN\Office\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \DTN\Office\Model\ResourceModel\employee\Collection
     */
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    private $auth;
    private $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $employeeCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?AuthorizationInterface $auth = null,
        StoreManagerInterface $storeManager
    ) {
        $this->collection = $employeeCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
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
        /** @var $employee \Dtn\Office\Model\employee */
        foreach ($items as $employee) {
            $this->loadedData[$employee->getId()] = $employee->getData();
            if ($employee->getImage()) {
                $m['image'][0]['name'] = $employee->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl().$employee->getImage();
                $fullData = $this->loadedData;
                $this->loadedData[$employee->getId()] = array_merge($fullData[$employee->getId()], $m);
            }
        }

        $data = $this->dataPersistor->get('dtn_office_employee');
        if (!empty($data)) {
            $employee = $this->collection->getNewEmptyItem();
            $employee->setData($data);
            $this->loadedData[$employee->getId()] = $employee->getData();
            $this->dataPersistor->clear('dtn_office_employee');
        }

        return $this->loadedData;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();

        if (!$this->auth->isAllowed('DTN_Office::save_design')) {
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
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'dtn/tmp/office/';
         $mediaUrl;
    }

}
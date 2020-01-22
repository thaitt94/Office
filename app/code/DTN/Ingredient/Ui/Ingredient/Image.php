<?php

namespace DTN\Ingredient\Ui\Ingredient;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    const IMAGEPATCH = 'http://magento233.local/pub/media/dtn/tmp/ingredient/';
    protected $storeManager;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) 
    {
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            // $path = $this->storeManager->getStore()->getBaseUrl(
            //             \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            //         );
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['image']) {
                    $item[$fieldName . '_src'] = self::IMAGEPATCH.$item['image'];
                    $item[$fieldName . '_orig_src'] = self::IMAGEPATCH.$item['image'];
                }
            }
        }
        return $dataSource;
    }
}
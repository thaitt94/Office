<?php

namespace DTN\Office\Ui\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

class ImageDepartment extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'images';
    const ALT_FIELD = 'name';
    const IMAGEPATCH = 'dtn/tmp/office/';
    protected $storeManager;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    );
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['images']) {
                    $item[$fieldName . '_src'] = $path.self::IMAGEPATCH.$item['images'];
                    $item[$fieldName . '_orig_src'] = $path.self::IMAGEPATCH.$item['images'];
                }else{
                    // please place your placeholder image at pub/media/dtn/office/placeholder/placeholder.jpg
                    $item[$fieldName . '_src'] = $path.self::IMAGEPATCH.'avatar.jpg';
                    $item[$fieldName . '_orig_src'] = $path.self::IMAGEPATCH.'avatar.jpg';
                }
            }
        }

        return $dataSource;
    }
}
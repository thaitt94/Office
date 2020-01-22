<?php

namespace DTN\Office\Block\Adminhtml\Employee\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    
    protected $context;
    protected $pageRepository;

    public function __construct(
        Context $context,
        PageRepositoryInterface $pageRepository
    )
    {
        $this->context = $context;
        $this->pageRepository = $pageRepository;
    }

    public function getEmployeeId()
    {
        try {
            return $this->pageRepository->getById(
                $this->context->getRequest()->getParam('employee_id')
            )->getId();
        } catch (NoSuchEntityException $e) {}

        return null;
    }
    
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

<?php

namespace DTN\Checkout\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Zend_Mail_Transport_Smtp;
use Zend_Mail;
use Magento\Framework\Encryption\EncryptorInterface;

class Data extends AbstractHelper
{

    const XML_PATH_SECTION = 'report/';
    const XML_PATH_GROUP = 'configurable_cron/';

	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	public function getConfig($code, $storeId = null)
	{
		return $this->getConfigValue(self::XML_PATH_SECTION .self::XML_PATH_GROUP. $code, $storeId);
	}

}
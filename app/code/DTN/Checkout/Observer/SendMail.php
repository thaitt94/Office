<?php

namespace DTN\Checkout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use DTN\Checkout\Helper\Data;
use Zend_Mail_Transport_Smtp;
use Zend_Mail;
use Magento\Framework\Encryption\EncryptorInterface;

class SendMail implements ObserverInterface
{
    protected $helperData;
    protected $encrypt;

    public function __construct(
        Data $helperData,
        EncryptorInterface $encrypt
    )
    {
        $this->helperData = $helperData;
        $this->encrypt = $encrypt;
    }

    public function execute(Observer $observer)
    {
//        get order confirmation
        $order = $observer->getOrder();
        $orderId = $order->getRealOrderId();
//        config smtp
        $prorocol = $this->helperData->getConfig('protocol');
        $smtpHost= $this->helperData->getConfig('smtphost');
        $smtpPost= $this->helperData->getConfig('smtppost');
        $auth = strtolower($this->helperData->getConfig('auth'));
        $username = $this->helperData->getConfig('username');
        $password = $this->helperData->getConfig('password');
        $password = $this->encrypt->decrypt($password);
        $rc = $this->helperData->getConfig('reciever_mail');
        $smtpConf = [
            'auth' => $auth,
            'ssl' => $prorocol,
            'port' => $smtpPost,
            'username' => $username,
            'password' => $password
        ];
        $transport = new Zend_Mail_Transport_Smtp($smtpHost, $smtpConf);
        $mail = new Zend_Mail('utf-8');
        $mail->setFrom($username, 'Admin');
        $mail->addTo($rc, '');
        if ($this->helperData->getConfig('cc_to') != null) {
            $cc = $this->helperData->getConfig('cc_to');
            $mail->addCc($cc, '');
        }
        $mail->setSubject('Confirm Order Information');
        $htmlBody = "<h3>Hello, Please check your order information below.</h3>";
        $mail->setBodyHtml($htmlBody);
        $result = $this->error();
        try {
            if (!$mail->send($transport) instanceof Zend_Mail) {
            }
        } catch (Exception $e) {
            $result =  $this->error(true, __($e->getMessage()));
        }
    }

    public function error($hasError = false, $msg = '')
    {
        return [
            'has_error' => (bool) $hasError,
            'msg' => (string) $msg
        ];
    }
}
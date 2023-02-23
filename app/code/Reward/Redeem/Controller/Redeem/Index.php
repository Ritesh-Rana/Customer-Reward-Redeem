<?php

namespace Reward\Redeem\Controller\Redeem;

use Magento\Framework\App\Action\Action;
use Magento\Quote\Model\Quote;

class Index extends Action
{

    public function execute()
    {

        //get form params
        $redeemPoints = $this->getRequest()->getParams();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/savesdff.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);

        $url = $this->resultRedirectFactory->create();
        $url->setUrl('/checkout#payment');
        $logger->info('redirected');
        return $url;
    }
}

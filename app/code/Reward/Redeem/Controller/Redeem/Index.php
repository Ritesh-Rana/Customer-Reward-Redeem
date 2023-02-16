<?php

namespace Reward\Redeem\Controller\Redeem;

use Magento\Framework\App\Action\Action;
use Magento\Quote\Model\Quote;

class Indesx extends Action
{

    public function execute()
    {

        //get form params
        $Allcomment = $this->getRequest()->getParams();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        //created quote object and get current quote id
        $quote = $objectManager->create('Magento\Checkout\Model\Cart')->getQuote();
        $quoteId = $quote->getId();

        $quoteObj = $objectManager->create(Quote::class);
        $quoteObj->loadByIdWithoutStore($quoteId);
        
        $quoteObj->setOrderComment("Comment for entire Order : " . $Allcomment['comment']);
        $quoteObj->save();

        $items = $objectManager->create('Magento\Checkout\Model\Cart')->getQuote()->getItemsCollection();

        $i = 1;
        //$items['sdf'=>'asd''sdf'=>'asd''sdf'=>'asd']
        foreach ($items as $key) {
                $key->setProductOrderComment("Comment for product " . $key->getName() . " : " . $Allcomment['comment' . $i]);
                $key->save();
            $i++;
        }


        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/savesdff.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        // $logger->info($quoteId);


        $url = $this->resultRedirectFactory->create();
        $url->setUrl('/checkout#payment');
        $logger->info('redirected');
        return $url;
    }
}

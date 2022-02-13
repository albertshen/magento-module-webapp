<?php

namespace AlbertMage\Webapp\Observer\Widget;

use Magento\Framework\Event\Observer;
use Magento\Framework\App\ObjectManager;

class LinkGenerateBefore implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $url = $observer->getEvent()->getUrl();
        $url->setUrl('/sss/xxx/ddd');
    }

}

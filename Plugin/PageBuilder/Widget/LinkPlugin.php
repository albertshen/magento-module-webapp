<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Webapp\Plugin\PageBuilder\Widget;

use Magento\Framework\Event\ManagerInterface;
use AlbertMage\PageBuilder\Model\Widget\Link;
use AlbertMage\Webapp\Model\Config\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use AlbertMage\Webapp\Model\Url;

class LinkPlugin
{

    /**
     * Application Event Dispatcher
     *
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Url generator
     *
     * @var Url
     */
    protected $url;

    /**
     * @param StoreManagerInterface
     * @param array
     */
    public function __construct(
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager,
        Url $url
    )
    {
        $this->eventManager = $eventManager;
        $this->storeManager = $storeManager;
        $this->url = $url;
    }

    /**
     * @param Link $link
     * @param $result
     */
    public function afterGetLinkData(Link $link, $result)
    {
        if ($this->storeManager->getStore()->getCode() === StoreInterface::STORE_CODE) {
            $result->setUrl($this->url->generate($link->getEntityId(), $link->getEntityType()));
            $this->eventManager->dispatch(
                'pagebuilder_widget_link_'.StoreInterface::STORE_CODE,
                ['link' => $link, 'link_data' => $result]
            );
        }
        return $result;
    }
}

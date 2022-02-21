<?php

namespace AlbertMage\Webapp\Plugin\PageBuilder;

use Magento\Store\Model\StoreManagerInterface;
use AlbertMage\Webapp\Model\Config\StoreInterface;
use AlbertMage\PageBuilder\Model\ResourceInterface;

class ResourcePlugin
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StoreManagerInterface
     * @param array
     */
    public function __construct(
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
    }

    public function afterGetResouceType(ResourceInterface $resource, $result)
    {
        if ($this->storeManager->getStore()->getCode() === StoreInterface::STORE_CODE) {
            return ResourceInterface::RESPONSIVE;
        }
        return $result;
    }

}
<?php

namespace AlbertMage\Webapp\Plugin\Catalog;

use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use AlbertMage\Webapp\Model\Config\StoreInterface;
use AlbertMage\Catalog\Model\Search;
use Magento\Catalog\Model\Product;

class SearchPlugin
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
     * @param StoreManagerInterface
     * @param array
     */
    public function __construct(
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager
    )
    {
        $this->eventManager = $eventManager;
        $this->storeManager = $storeManager;
    }

    public function afterGetProductData(Search $search, $result, Product $product)
    {
        if ($this->storeManager->getStore()->getCode() === StoreInterface::STORE_CODE) {
            $product->setData('albert', 'ddddxxx333');
            $this->eventManager->dispatch(
                'catalog_search_product_'.StoreInterface::STORE_CODE,
                ['product' => $product, 'product_data' => $result]
            );
        }
        return $result;
    }

}

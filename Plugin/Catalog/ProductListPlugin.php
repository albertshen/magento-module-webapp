<?php

namespace AlbertMage\Webapp\Plugin\Catalog;

use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use AlbertMage\Webapp\Model\Config\StoreInterface;
use AlbertMage\Catalog\Model\ProductList;
use Magento\Catalog\Model\Product;

class ProductListPlugin
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

    public function afterGetProductData(ProductList $productList, $result, Product $product)
    {
        if ($this->storeManager->getStore()->getCode() === StoreInterface::STORE_CODE) {
            $product->setData('albert', 'dddd');
            $this->eventManager->dispatch(
                'catalog_product_list_product_'.StoreInterface::STORE_CODE,
                ['product' => $product, 'product_data' => $result]
            );
        }
        return $result;
    }

}

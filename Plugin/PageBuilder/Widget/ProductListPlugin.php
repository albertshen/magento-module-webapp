<?php

namespace AlbertMage\Webapp\Plugin\PageBuilder\Widget;

use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use AlbertMage\Webapp\Model\Config\StoreInterface;
use AlbertMage\PageBuilder\Model\Widget\ProductList;

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

    public function afterGetProductData(ProductList $productList, $result, $product)
    {
        if ($this->storeManager->getStore()->getCode() === StoreInterface::STORE_CODE) {
            $result->setId($product->getId());
            $this->eventManager->dispatch(
                'pagebuilder_widget_product_'.StoreInterface::STORE_CODE,
                ['product' => $product, 'product_data' => $result]
            );
        }
        return $result;
    }

}

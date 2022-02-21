<?php

namespace AlbertMage\Webapp\Plugin\Catalog;

use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use AlbertMage\Webapp\Model\Config\StoreInterface;
use AlbertMage\Catalog\Model\CategoryList;
use Magento\Catalog\Model\Category;

class CategoryListPlugin
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

    public function afterGetCategoryData(CategoryList $categoryList, $result, Category $category)
    {
        if ($this->storeManager->getStore()->getCode() === StoreInterface::STORE_CODE) {
            //
            $this->eventManager->dispatch(
                'catalog_category_item_'.StoreInterface::STORE_CODE,
                ['category' => $category, 'category_data' => $result]
            );
        }
        return $result;
    }

}

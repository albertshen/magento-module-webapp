<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Webapp\Model;

use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewrite\Model\UrlFinderInterface;

/**
 *
 */
class Url
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Url finder for category
     *
     * @var UrlFinderInterface
     */
    protected $urlFinder;

    /**
     * @param StoreManagerInterface
     * @param array
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        UrlFinderInterface $urlFinder
    )
    {
        $this->storeManager = $storeManager;
        $this->urlFinder = $urlFinder;
    }

    /**
     * Generate link or path for diferent store
     * @param $id
     * @param $entiyType
     * @return string
     */
    public function generate(int $id, string $entityType, array $params = [])
    {
        if ($path = $this->getPath($id, $entityType)) {
            
            $url = $this->storeManager->getStore()->getUrl('', array_merge(['_direct' => $path], $params));
            return $url;
            // if (isset($this->config['absolute']) && $this->config['absolute']) {
            //     return $url;
            // }
            // return str_replace($this->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB), '', $url);
        }
        return '';
    }

    /**
     * Prepare path using passed id path and return it
     *
     * @throws \RuntimeException
     * @return string|false if path was not found in url rewrites.
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getPath(int $id, string $entityType)
    {
        $entityType = $entityType === 'page' ? 'cms-page' : $entityType;
        $filterData = [
            UrlRewrite::ENTITY_ID => $id,
            UrlRewrite::ENTITY_TYPE => $entityType,
            UrlRewrite::STORE_ID => $this->storeManager->getStore()->getId(),
        ];

        $rewrite = $this->urlFinder->findOneByData($filterData);
        if ($rewrite) {
            return $rewrite->getRequestPath();
        }
        return '';
    }

}

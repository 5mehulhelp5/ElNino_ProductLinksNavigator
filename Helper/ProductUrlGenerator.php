<?php
/*
 * Copyright (c) 2024.
 * Released under the MIT License.
 *
 * This file is part of the El Niño BV open-source project (https://elnino.tech/).
 * Source code is available at https://github.com/elninotech.
 *
 * You may freely use, modify, and distribute this file in accordance with the terms of the MIT License.
 *
 */

namespace ElNino\ProductLinksNavigator\Helper;

use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class ProductUrlGenerator
{
    public function __construct(
        private StoreManagerInterface $storeManager,
        private UrlInterface $urlBuilder,
        private ProductRepositoryInterface $productRepository
    ) {
    }

    /**
     * Generate HTML for product links, including frontend and backend links.
     *
     * @param  int  $productId
     * @return string
     */
    public function getProductLinksHtml(int $productId): string
    {
        try {
            $frontendUrls = $this->getFrontendUrls($productId);
            $backendUrl = $this->getBackendUrl($productId);

            $html = sprintf(
                '<div class="product-links">
                    <a href="%1$s" onclick="window.open(\'%1$s\', \'_blank\'); return false;">%2$s</a>',
                $backendUrl,
                __('Edit')
            );

            if (!empty($frontendUrls)) {
                $html .= ' | <select onchange="if(this.value) window.open(this.value, \'_blank\');" class="frontend-links-dropdown">';
                $html .= '<option value="">'.__('View in Store').'</option>';
                foreach ($frontendUrls as $storeName => $url) {
                    $html .= sprintf(
                        '<option value="%1$s">%2$s</option>',
                        htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
                        htmlspecialchars($storeName, ENT_QUOTES, 'UTF-8')
                    );
                }
                $html .= '</select>';
            }

            $html .= '</div>';
            return $html;
        } catch (LocalizedException $e) {
            return __('Links not available');
        }
    }

    /**
     * Retrieve frontend URLs for all stores where the product is enabled and visible.
     *
     * @param  int  $productId
     * @return array [ 'Store Name' => 'Frontend URL', ... ]
     * @throws LocalizedException
     */
    public function getFrontendUrls(int $productId): array
    {
        $frontendUrls = [];

        try {
            $product = $this->productRepository->getById($productId);
            $storeNames = $this->getStoreNamesByIds($product);

            foreach ($storeNames as $storeId => $storeName) {
                try {
                    $product->setStoreId($storeId);

                    if ($this->isProductValidInStore($product)) {
                        $frontendUrls[$storeName] = $product->getProductUrl();
                    }
                } catch (NoSuchEntityException $e) {
                    continue;
                }
            }
        } catch (Exception $e) {
            throw new LocalizedException(__('Error generating frontend links for product.'));
        }

        return $frontendUrls;
    }

    /**
     * Retrieve store names mapped to their IDs for the stores a product is assigned to.
     *
     * @param  ProductInterface  $product
     * @return array
     * [
     *   storeId => storeName,
     *   ...
     * ]
     */
    private function getStoreNamesByIds(ProductInterface $product): array
    {
        $storeNames = [];
        $storeIds = $product->getStoreIds();

        foreach ($storeIds as $storeId) {
            try {
                $store = $this->storeManager->getStore($storeId);
                $storeNames[$storeId] = $store->getName();
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }

        return $storeNames;
    }


    /**
     * Check if a product is enabled and visible in the current store scope.
     *
     * @param  ProductInterface  $product
     * @return bool
     */
    private function isProductValidInStore(ProductInterface $product): bool
    {
        return $product->getStatus() && $product->isVisibleInSiteVisibility();
    }

    /**
     * Generate the backend URL for editing the product.
     *
     * @param  int  $productId
     * @return string
     */
    public function getBackendUrl(int $productId): string
    {
        return $this->urlBuilder->getUrl('catalog/product/edit', [
            'id' => $productId
        ]);
    }
}

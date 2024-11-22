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

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;

class ProductUrlGenerator
{
    /**
     * @var int|null
     */
    private ?int $storeId;

    public function __construct(
        private StoreManagerInterface $storeManager,
        private UrlInterface $urlBuilder,
        private ProductRepositoryInterface $productRepository,
        private RequestInterface $request,
        private RedirectInterface $redirect,
    ) {
        $this->storeId = $this->determineStoreId();
    }

    /**
     * Determine the store ID, falling back to referrer URL if necessary for modals
     *
     * @return int
     */
    private function determineStoreId(): int
    {
        $storeId = $this->request->getParam('store');

        if ($storeId) {
            return $storeId;
        }

        $referrerUrl = $this->redirect->getRefererUrl();

        if ($referrerUrl) {
            preg_match('/\/store\/(\d+)\//', $referrerUrl, $matches);
            return $matches[1] ?? $this->storeManager->getDefaultStoreView()->getId();
        }

        return $this->storeManager->getDefaultStoreView()->getId();
    }

    /**
     * Generate product links HTML, exclude frontend if "Not Visible Individually"
     * @param  int  $productId
     * @return string
     */
    public function getProductLinksHtml(int $productId): string
    {
        try {
            $frontendUrl = $this->getFrontendUrl($productId);
            $backendUrl = $this->getBackendUrl($productId);

            $html = sprintf(
                '<div class="product-links">
                <a href="%1$s" onclick="window.open(\'%1$s\', \'_blank\'); return false;">%2$s</a>',
                $backendUrl,
                __('Edit')
            );

            if ($frontendUrl !== null) {
                $html .= sprintf(
                    ' | <a href="%1$s" onclick="window.open(\'%1$s\', \'_blank\'); return false;">%2$s</a>',
                    $frontendUrl,
                    __('View in Store')
                );
            }

            $html .= '</div>';

            return $html;
        } catch (NotFoundException $e) {
            return __('Links not available');
        }
    }

    /**
     * Generate the frontend URL for a product on a given store ID
     *
     * @param  int  $productId
     * @return string|null
     * @throws NotFoundException
     */
    public function getFrontendUrl(int $productId): ?string
    {
        try {
            $product = $this->productRepository->getById($productId, false, $this->storeId);

            if ($product->isVisibleInSiteVisibility()) {
                return $product->getProductUrl();
            }
            return null;
        } catch (NoSuchEntityException $e) {
            throw new NotFoundException(__('Product or store not found.'));
        }
    }

    /**
     * Generate the backend URL for a product in the specified store scope
     *
     * @param  int  $productId
     * @return string
     */
    public function getBackendUrl(int $productId): string
    {
        return $this->urlBuilder->getUrl('catalog/product/edit', [
            'id' => $productId,
            'store' => $this->storeId
        ]);
    }
}

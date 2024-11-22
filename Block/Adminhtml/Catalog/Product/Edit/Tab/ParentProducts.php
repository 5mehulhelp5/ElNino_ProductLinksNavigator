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

namespace ElNino\ProductLinksNavigator\Block\Adminhtml\Catalog\Product\Edit\Tab;

use ElNino\ProductLinksNavigator\Helper\ParentProductHelper;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Registry;
use ElNino\ProductLinksNavigator\Helper\ProductUrlGenerator;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Product\Attribute\Source\Status as ProductStatus;

class ParentProducts extends Template
{
    protected $_template = 'ElNino_ProductLinksNavigator::product/edit/parent_products.phtml';

    public function __construct(
        Context $context,
        private Registry $registry,
        private ProductUrlGenerator $productUrlGenerator,
        private ProductStatus $productStatus,
        private ParentProductHelper $parentProductHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get current product
     *
     * @return ProductInterface|null
     */
    public function getProduct(): ?ProductInterface
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Retrieve all parent products for the current product
     *
     * @return ProductInterface[]
     */
    public function getParentProducts(): array
    {
        $product = $this->getProduct();
        if (!$product) {
            return [];
        }

        return $this->parentProductHelper->getParentProducts($product->getId());
    }

    /**
     * Generate frontend and backend links for the parent product
     *
     * @param ProductInterface $parentProduct
     * @return string
     */
    public function getProductLinksHtml(ProductInterface $parentProduct): string
    {
        return  $parentProduct->getName().$this->productUrlGenerator->getProductLinksHtml($parentProduct->getId());
    }

    /**
     * Get product status as text
     *
     * @param int $status
     * @return string
     */
    public function getStatusText($status)
    {
        return $this->productStatus->getOptionText($status);
    }
}

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

use Magento\Bundle\Model\ResourceModel\Selection as BundleSelection;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable as ConfigurableType;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\GroupedProduct\Model\ResourceModel\Product\Link as GroupedLink;

class ParentProductHelper
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ConfigurableType $configurableType,
        private GroupedLink $groupedLink,
        private BundleSelection $bundleSelection
    ) {
    }

    /**
     * Retrieve all parent products by type for a specific product ID
     *
     * @param  int  $productId
     * @return ProductInterface[]
     */
    public function getParentProducts(int $productId): array
    {
        $parentProducts = [];

        $configurableParents = $this->configurableType->getParentIdsByChild($productId);
        $parentProducts = array_merge($parentProducts, $this->loadProducts($configurableParents));

        $groupedParents = $this->groupedLink->getParentIdsByChild($productId, GroupedLink::LINK_TYPE_GROUPED);
        $parentProducts = array_merge($parentProducts, $this->loadProducts($groupedParents));

        $bundleParents = $this->bundleSelection->getParentIdsByChild($productId);
        $parentProducts = array_merge($parentProducts, $this->loadProducts($bundleParents));

        return $parentProducts;
    }

    /**
     * Load product entities by an array of IDs.
     *
     * @param  int[]  $productIds
     * @return ProductInterface[]
     */
    private function loadProducts(array $productIds): array
    {
        return array_filter(array_map(function ($id) {
            try {
                return $this->productRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                return null;
            }
        }, $productIds));
    }
}

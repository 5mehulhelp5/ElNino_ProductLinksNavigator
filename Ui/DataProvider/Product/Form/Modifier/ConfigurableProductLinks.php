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

namespace ElNino\ProductLinksNavigator\Ui\DataProvider\Product\Form\Modifier;

use ElNino\ProductLinksNavigator\Helper\ProductUrlGenerator;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

class ConfigurableProductLinks extends AbstractModifier
{
    public function __construct(
        private ProductUrlGenerator $productUrlGenerator,
        private LocatorInterface $locator
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        /** @var ProductInterface $model */
        $model = $this->locator->getProduct();
        $productId = $model->getId();

        if (isset($data[$productId]['configurable-matrix'])) {
            foreach ($data[$productId]['configurable-matrix'] as &$matrix) {
                if (isset($matrix['id'])) {
                    $linksHtml = $this->productUrlGenerator->getProductLinksHtml($matrix['id']);
                    $matrix['product_link'] = $matrix['name'] . $linksHtml;
                }
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}

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
use Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\BundlePanel;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

class BundleProductLinksComposite extends AbstractModifier
{
    const CODE_BUNDLE_SELECTIONS = 'bundle_selections';

    public function __construct(private ProductUrlGenerator $productUrlGenerator)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data): array
    {
        foreach ($data as &$productData) {
            if (isset($productData[BundlePanel::CODE_BUNDLE_OPTIONS][BundlePanel::CODE_BUNDLE_OPTIONS])) {
                foreach ($productData[BundlePanel::CODE_BUNDLE_OPTIONS][BundlePanel::CODE_BUNDLE_OPTIONS] as &$option) {
                    if (isset($option[self::CODE_BUNDLE_SELECTIONS])) {
                        foreach ($option[self::CODE_BUNDLE_SELECTIONS] as &$selection) {
                            $selection['name'] .= $this->productUrlGenerator->getProductLinksHtml($selection['product_id']);
                        }
                    }
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

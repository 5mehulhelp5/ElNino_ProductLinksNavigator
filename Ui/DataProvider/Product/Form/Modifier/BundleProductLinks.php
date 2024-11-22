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

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;

class BundleProductLinks extends AbstractModifier
{

    private const PRODUCT_LINKS_TEMPLATE = 'ElNino_ProductLinksNavigator/dynamic-rows/cells/html';

    public function __construct(private ArrayManager $arrayManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta): array
    {
        $path = 'bundle-items/children/bundle_options/children/record/children/product_bundle_container/children/bundle_selections/children/record/children/name/arguments/data/config';

        if ($this->arrayManager->exists($path, $meta)) {
            $meta = $this->arrayManager->set("$path/elementTmpl", $meta, self::PRODUCT_LINKS_TEMPLATE);
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data): array
    {
        return $data;
    }
}

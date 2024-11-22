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
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class RelatedProductLinks implements ModifierInterface
{
    private const PRODUCT_LINKS_TEMPLATE = 'ElNino_ProductLinksNavigator/dynamic-rows/cells/html';

    private array $dataScopeArray;

    public function __construct(
        private ProductUrlGenerator $productUrlGenerator,
        private ArrayManager $arrayManager,
        array $dataScopeArray = [Related::DATA_SCOPE_RELATED, Related::DATA_SCOPE_CROSSSELL, Related::DATA_SCOPE_UPSELL]
    ) {
        $this->dataScopeArray = $dataScopeArray;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta): array
    {
        foreach ($this->dataScopeArray as $dataScope) {
            $path = "related/children/$dataScope/children/$dataScope/children/record/children/name/arguments/data/config";
            if ($this->arrayManager->exists($path, $meta)) {
                $meta = $this->arrayManager->set($path.'/elementTmpl', $meta, self::PRODUCT_LINKS_TEMPLATE);
            }
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data): array
    {
        foreach ($data as $productId => &$productData) {
            foreach ($this->dataScopeArray as $dataScope) {
                if (!isset($productData['links'][$dataScope])) {
                    continue;
                }

                foreach ($productData['links'][$dataScope] as &$relatedProduct) {
                    $relatedProduct['name'] .= $this->productUrlGenerator->getProductLinksHtml($relatedProduct['id']);
                }
            }
        }

        return $data;
    }
}

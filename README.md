# ProductLinksNavigator

![Packagist Version](https://img.shields.io/packagist/v/elnino/product-links-navigator)
![Magento 2 Compatible](https://img.shields.io/badge/Magento-2.4%2B-blue)
![License](https://img.shields.io/github/license/elninotech/ElNino_ProductLinksNavigator)
![Downloads](https://img.shields.io/packagist/dt/elnino/product-links-navigator)
![Hyvä Compatible](https://img.shields.io/badge/Hyvä-Compatible-brightgreen)

**ProductLinksNavigator** is a Magento 2 extension for enhanced admin product navigation. It is especially useful for
merchants who want to simplify the process of navigating complex and custom product relationships.

## Installation

Install via Composer:

```bash
composer require elnino/product-links-navigator
bin/magento module:enable ElNino_ProductLinksNavigator
bin/magento setup:upgrade
bin/magento cache:clean
```

## Features

### Integrated Product Links
Adds "View in Store" (frontend) links dropdown that navigates to all frontend store views where product is enabled and visible. Adds "Edit" (admin) link.


<div style="text-align:center;">
    <img src=".github/screenshots/integrated_links.png" alt="Integrated Links Example" style="width:250px;"/>
</div>

#### Integrated
<details>
<summary><strong>Bundle Items Grid and Selection Modal</strong></summary>

#### Bundle Items Grid
<img src=".github/screenshots/bundle_selections_tab.png" alt="Bundle Items Grid" style="width:100%;"/>

#### Bundle Items Selection Modal
<img src=".github/screenshots/bundle_selections_modal.png" alt="Bundle Items Selection Modal" style="width:100%;"/>
</details>

<details>
<summary><strong>Configurable Items Grid and Selection Modal</strong></summary>

#### Configurable Items Grid
<img src=".github/screenshots/configurable_selections_tab.png" alt="Configurable Items Grid" style="width:100%;"/>

#### Configurable Items Selection Modal
<img src=".github/screenshots/configurable_selections_modal.png" alt="Configurable Items Selection Modal" style="width:100%;"/>

</details>
<details>
<summary><strong>Related, Cross-sell, and Up-sell Products</strong></summary>

#### Related Products Grid
<img src=".github/screenshots/related_grid.png" alt="Related Products Grid" style="width:100%;"/>

#### Related Products Modal
<img src=".github/screenshots/related_grid_modal.png" alt="Related Products Modal" style="width:100%;"/>

</details>

<details>
<summary><strong>Product Grid</strong></summary>

#### Product Grid
<img src=".github/screenshots/product_grid.png" alt="Product Grid" style="width:100%;"/>

</details>

### Parent Products Tab

Lists all the parent products of the product you are currently editing.

<img src=".github/screenshots/parent_products_tab.png" alt="Parent Products Tab" style="width:100%;"/>

## Planned Features
- [ ] Add links to Grouped products grid and selection modal
- [ ] Add unit and integration testing
- [ ] Add links to Sales views (Order, Invoice etc.) products grid

## Customisation

### Adding links to custom product relation grid/modal

If you have a custom product relation set up, you can allow adding the links for this relation's grid and modal. Extend
the data scopes array in your custom module `adminhtml\di.xml`:

```xml

<type name="ElNino\ProductLinksNavigator\Ui\DataProvider\Product\Form\Modifier\RelatedProductLinks">
    <arguments>
        <argument name="dataScopeArray" xsi:type="array">
            <item name="0" xsi:type="string">related</item>
            <item name="1" xsi:type="string">crosssell</item>
            <item name="2" xsi:type="string">upsell</item>
            <item name="3" xsi:type="string">your_custom_scope</item> <!-- Add your custom scope here -->
        </argument>
    </arguments>
</type>
```

### Accommodate a custom parent product type

The module currently lists all the existing parents of Configurable, Grouped and Bundle types. If you have a custom
product type that serves as a parent, you can modify the implementation of parent product retrieval in
`\ElNino\ProductLinksNavigator\Helper\ParentProductHelper::getParentProducts` with a plugin.

## Compatibility
- Magento 2.4.x and later
- PHP >=7.4
- Hyvä Theme

## License

ProductLinksNavigator is built by El Niño, a digital development studio in Enschede and The Hague, the Netherlands, that
builds custom web and mobile apps, webshops, and more, backed by 15+ years of experience.

This module is open-source and available under the MIT License.

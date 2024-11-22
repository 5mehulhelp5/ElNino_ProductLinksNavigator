# ProductLinksNavigator

**ProductLinksNavigator** is a Magento 2 extension for enhanced admin product navigation. It is especially useful for
merchants who want to simplify the process of navigating complex and custom product relationships.

## Features

- **Integrated Product Links:** Adds "View in Store" (frontend) and "Edit" (admin) links to the following grids and modals:
    - Bundle items grid and selection modal

      <div align="center">
        <table>
          <tr>
            <td style="text-align:center;">
              <img src=".github/screenshots/bundle_selections_tab.png" alt="Bundle Items Grid" width="400">
              <div><strong>Bundle Items Grid</strong></div>
            </td>
            <td style="text-align:center;">
              <img src=".github/screenshots/bundle_selections_modal.png" alt="Bundle Items Selection Modal" width="400">
              <div><strong>Bundle Items Selection Modal</strong></div>
            </td>
          </tr>
        </table>
      </div>

    - Configurable items and selection modal

      <div align="center">
        <table>
          <tr>
            <td style="text-align:center;">
              <img src=".github/screenshots/configurable_selections_tab.png" alt="Configurable Items Grid" width="400">
              <div><strong>Configurable Items Grid</strong></div>
            </td>
            <td style="text-align:center;">
              <img src=".github/screenshots/configurable_selections_modal.png" alt="Configurable Items Selection Modal" width="400">
              <div><strong>Configurable Items Selection Modal</strong></div>
            </td>
          </tr>
        </table>
      </div>

    - Related, Cross-sell, and Up-sell products and selection modal

      <div align="center">
        <table>
          <tr>
            <td style="text-align:center;">
              <img src=".github/screenshots/related_grid.png" alt="Related Products Grid" width="400">
              <div><strong>Related Products Grid</strong></div>
            </td>
            <td style="text-align:center;">
              <img src=".github/screenshots/related_grid_modal.png" alt="Related Products Modal" width="400">
              <div><strong>Related Products Modal</strong></div>
            </td>
          </tr>
        </table>
      </div>

    - Product grid

      <div align="center">
        <table>
          <tr>
            <td style="text-align:center;">
              <img src=".github/screenshots/product_grid.png" alt="Product Grid" width="400">
              <div><strong>Product Grid</strong></div>
            </td>
          </tr>
        </table>
      </div>

- **Parent Products Tab:** Lists all the parent products of the product you are currently editing.

  <div align="center">
    <table>
      <tr>
        <td style="text-align:center;">
          <img src=".github/screenshots/parent_products_tab.png" alt="Parent Products Tab" width="400">
          <div><strong>Parent Products Tab</strong></div>
        </td>
      </tr>
    </table>
  </div>

## Installation

Install via Composer:

```bash
composer require elnino/product-links-navigator
bin/magento module:enable ElNino_ProductLinksNavigator
bin/magento setup:upgrade
bin/magento cache:clean
```

## Customisation

### Adding links to custom product relation grid/modal

If you have a custom product relation set up, you can allow adding the links for this relation's grid and modal. Extend
the data scopes array in your custom module `di.xml`:

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
`\ElNino\ProductLinksNavigator\Helper\ParentProductHelper::getParentProducts`.

## License

ProductLinksNavigator is built by El Niño, a digital development studio in Enschede and The Hague, the Netherlands, that
builds custom web and mobile apps, webshops, and more, backed by 15+ years of experience.

This module is open-source and available under the MIT License.
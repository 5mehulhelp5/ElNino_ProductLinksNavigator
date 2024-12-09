# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/).

## [1.1.1] - 2024-12-05
### Fixed
- **Product URL generation**:
  - Updated logic to fetch URLs for scoped products in each store to ensure the correct frontend URLs are retrieved for enabled and visible products.

## [1.1.0] - 2024-12-05
### Added
- Support for displaying multiple frontend links for products in all assigned stores.
  - Added a dropdown in the product grid and modals to select and open store-specific frontend links.
  - Improved product visibility checks to ensure links are only generated for enabled and visible products.
- Refactored `ProductUrlGenerator` for better maintainability and performance.

## [1.0.1] - 2024-12-02
### Fixed
- **Bug:** Product creation failed due to missing product ID check in `getParentProducts`.
  - Added validation to ensure a product ID exists before attempting to retrieve parent products.

## [1.0.0] - 2024-11-22
### Added
- Integrated "View in Store" and "Edit" links for:
  - Bundle items grid and selection modal.
  - Configurable products grid and modal.
  - Related, Cross-sell, and Up-sell products grid and modal.
  - Product grid.
- Parent Products Tab to display parent relationships.
- Hyvä theme compatibility.
# Magento Module: Product Likes

Implementation of a Magento module that lets customers “Like” products on the storefront. Built during an internship at **Go Top** (April 2017).

## What it does
- Displays a **“Like” button** and a **like counter** next to the product image on **Category View** and **Product View** pages.
- When the button is clicked, a record is saved to the `magedoc_product_like` table storing: `customer_ip`, `customer_id`, `product_id`, `created_at`.
- The total number of likes per product is stored in `magedoc_product_like_aggregate` with fields: `product_id`, `store_id`, `like_count`.
- **Duplicate protection:** the same customer (or a guest from the same IP) cannot like the same product twice. Guests from the same IP may like a product **no more than once per day**. If a user/guest cannot like, the button is disabled. After a like is added, the button becomes disabled.

## Widgets and admin
- **Widget:** shows products with the highest number of likes. Configurable in the admin: you can select categories to scope the results. If the current category isn’t selected in the widget settings, the widget shows the most-liked products across the entire store.
- **Admin grid:** lists likes with columns: record ID, store ID, product name, customer IP, customer full name. The full name is composite; if the like was added by a guest, the full name displays **Guest**.

## Implementation details
- Module configuration defined.
- `sql_setup` implemented (with upgrade scripts added later).
- Models and controllers implemented.
- Frontend output via **layout updates**; a block is added to the **main product info** block.
- Added the ability to load a model by two or more fields by overriding the `_getLoadSelect` method of `Mage_Core_Model_Resource_Db_Abstract` to accept an array of fields.
- Separate stylesheet for like UI.
- **Observer** adds product like counts to the product collection (for showing likes in catalog listings).
- Admin grid with a menu entry; adds a composite **Full Name** field from each customer’s first and last name. If these fields are empty, **Guest** is shown.
- Search by the composite **Full Name** implemented.
- Basic translations provided for the widget, grid, and block.

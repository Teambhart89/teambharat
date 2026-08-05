Theme level WooCommerce template overrides go in this folder.

PlantGift Pro deliberately ships with no overrides. All shop layout is applied
through WooCommerce action and filter hooks in inc/woocommerce.php, so the
theme keeps working when WooCommerce updates its own templates.

If you do need an override, copy the file from
wp-content/plugins/woocommerce/templates/ into this folder, keeping the same
relative path, then re-check it after every WooCommerce major update.

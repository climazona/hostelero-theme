<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$price_class = esc_attr(apply_filters('woocommerce_product_price_class', 'price'));
$price_html = $product->get_price_html();
$price_without_tax = $product->get_price();
$formatted_price_without_tax = number_format($price_without_tax, 2, ',', '.');
?>

<div class="<?php echo $price_class; ?>">
    <?php echo $price_html; ?>
    <div class="text-secondary">
        <div class="h6 mt-2 mb-3" style="font-size:.875rem;">
            Precio sin IVA: <b><?php echo $formatted_price_without_tax; ?>€</b>
        </div>
    </div>
</div>
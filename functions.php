<?php

if (!defined('ABSPATH')) exit;

require get_template_directory() . '/inc/array.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/gases-fluorados.php';
require get_template_directory() . '/inc/servicio-instalacion.php';
require get_template_directory() . '/inc/social-share.php';
require get_template_directory() . '/inc/envios.php';

require get_template_directory() . '/lib/rest-admin-setup.php';
require get_template_directory() . '/lib/utils.php';
require get_template_directory() . '/lib/login-config.php';
require get_template_directory() . '/lib/setup-theme.php';
require get_template_directory() . '/lib/setup-woocommerce.php';
require get_template_directory() . '/lib/news.php';
require get_template_directory() . '/lib/table-of-contents.php';
require get_template_directory() . '/lib/search-widget.php';
require get_template_directory() . '/lib/mime-check-fix.php';
require get_template_directory() . '/lib/setup-product.php';
require get_template_directory() . '/lib/product-view.php';
require get_template_directory() . '/lib/product-tabs.php';
require get_template_directory() . '/lib/store-notice.php';
require get_template_directory() . '/lib/seo-next-link.php';
require get_template_directory() . '/lib/custom-checkout-field.php';

require get_template_directory() . '/theme/theme.php';

// Modificar rol "Gestor de la Tienda" para que pueda limitar la vista
// require get_template_directory() . '/lib/shop-manager-role.php';
<?php

add_action('after_setup_theme', 'lebianch_seo_setup');
add_action('after_setup_theme', 'register_navwalker');
add_action('after_setup_theme', 'martin_custom_ficha_producto_woocommmerce');

add_action('init', 'lebianchseo_menus');

add_action('admin_init', 'hide_notices_dashboard');

add_filter('the_content', 'add_responsive_class');

add_filter('woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100);

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10);

remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description');
add_action('woocommerce_archive_description', 'wc_category_description');

add_filter('woocommerce_shipping_package_name', 'custom_shipping_package_name');

add_action('widgets_init', 'dcms_agregar_nueva_zona_widgets');

add_filter('get_image_tag_class', 'wpse302130_add_image_class');

add_action('acf/include_fields', 'my_register_fields');

add_filter('woocommerce_order_button_text', function () {
  return 'Confirmar la compra';
});

function my_register_fields()
{
  include_once(get_template_directory() . '/acf-post-type-selector/post-type-selector-v5.php');
}

function wpse302130_add_image_class($class)
{
  $class .= ' img-fluid';
  return $class;
}

function woocommerce_catalog_ordering_lb()
{
  if (!wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
    return;
  }

  $show_default_orderby = 'menu_order' === apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
  $catalog_orderby_options = apply_filters(
    'woocommerce_catalog_orderby',
    array(
      'menu_order' => __('Default sorting', 'woocommerce'),
      'date'       => 'Novedad',
      'price'      => 'Precio: de bajo a alto',/*__( 'Sort by price: low to high', 'woocommerce' ),*/
      'price-desc' => 'Precio: de alto a bajo',/*__( 'Sort by price: high to low', 'woocommerce' ),*/
    )
  );
  $default_orderby = wc_get_loop_prop('is_search') ? 'relevance' : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', ''));
  $orderby         = isset($_GET['orderby']) ? wc_clean(wp_unslash($_GET['orderby'])) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

  if (wc_get_loop_prop('is_search')) {
    $catalog_orderby_options = array_merge(array('relevance' => __('Relevance', 'woocommerce')), $catalog_orderby_options);
    unset($catalog_orderby_options['menu_order']);
  }

  if (!$show_default_orderby) {
    unset($catalog_orderby_options['menu_order']);
  }

  if (!wc_review_ratings_enabled()) {
    unset($catalog_orderby_options['rating']);
  }

  if (!array_key_exists($orderby, $catalog_orderby_options)) {
    $orderby = current(array_keys($catalog_orderby_options));
  }

  wc_get_template(
    'loop/orderby.php',
    array(
      'catalog_orderby_options' => $catalog_orderby_options,
      'orderby'                 => $orderby,
      'show_default_orderby'    => $show_default_orderby,
    )
  );
}

function lebianch_seo_setup()
{
  add_theme_support('title-tag'); // Titulos SEO
  add_theme_support('wp-block-styles'); // Soporte estilos por default de gutenberg en tu tema
  add_theme_support('post-thumbnails'); // Habilitar imagenes destacadas
  add_theme_support('title-tag'); // Soporte titulos SEO
  add_image_size('square', 350, 350, true); // Agregar tamaños personalizados
  add_image_size('portrait', 350, 724, true);
  add_image_size('cajas', 400, 375, true);
  add_image_size('seothemeimghome', 555, 370, array('left', 'top'));
  add_image_size('mediano', 700, 400, true);
  add_image_size('blog', 966, 644, true);
  add_image_size('seothemeimg', 250, 125, true);
  add_image_size('sizeblog', 750, 375, true);
  add_image_size('sizesidebar', 360, 180, true);
  /* Add support for core custom logo. @link https://codex.wordpress.org/Theme_Logo */
  add_theme_support(
    'custom-logo',
    array(
      'height'      => 75,
      'width'       => 250,
      'flex-height' => true,
      'flex-width'  => true,
      'header-text' => array('site-title', 'site-description')
    )
  );
}

function register_navwalker()
{
  require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

function martin_custom_ficha_producto_woocommmerce()
{
  remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
  add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering_lb', 30);
  add_action('woocommerce_single_product_summary', 'lebianch_abre_row', 7);
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
  add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 35);
  add_action('woocommerce_single_product_summary', 'lebianch_cierra_row', 34);
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
  remove_filter('woocommerce_catalog_orderby', 'filter_woocommerce_catalog_orderby', 10, 1);
}

function tienda_del_aire_scripts()
{
  wp_dequeue_style('wc-blocks-style');
  wp_dequeue_style('wp-block-library');
  
  // Cookieconsent
  wp_enqueue_style('cookieconsent', get_template_directory_uri() . '/assets/cookieconsent/dist/cookieconsent.css', array(), '3.0.1');
  wp_enqueue_script('cookieconsent', get_template_directory_uri() . '/assets/cookieconsent/cookieconsent-config.js', array(), '3.0.1', true);

  // Fonts
  wp_enqueue_style('googleFonts', 'https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap', array());

  // Bootstrap
  wp_enqueue_style('bootstrap-css', get_theme_file_uri() . '/assets/css/bootstrap.min.css', array(), '5.2.0');
  wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css', array(), '1.8.2');
  wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), '5.2.0', true);
  wp_script_add_data('bootstrap-js', array('integrity', 'crossorigin'), array('sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM', 'anonymous'));

  wp_enqueue_style('styles', trailingslashit(get_template_directory_uri()) . 'style.css', array());
  wp_enqueue_style('custom-css-bt', get_theme_file_uri() . '/assets/css/jquery.bootstrap-touchspin.css', array());
  wp_enqueue_style('slickCSS', get_theme_file_uri() . '/assets/css/slick.css', array());
  wp_enqueue_style('slickCSS-Theme', get_theme_file_uri() . '/assets/css/slick-theme.css', array());

  wp_enqueue_script('jqueryNew', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), true); // jQuery
  wp_enqueue_script('scripts-bt', get_template_directory_uri() . '/assets/js/jquery.bootstrap-touchspin.js', array('jqueryNew'), true);
  wp_enqueue_script('slickJS', get_template_directory_uri() . '/assets/js/slick.min.js', array('jqueryNew'), true);
}
add_action('wp_enqueue_scripts', 'tienda_del_aire_scripts', 10);

function add_module_type_attribute($tag, $handle, $src) {
    $module_scripts = array('cookieconsent');

    if (in_array($handle, $module_scripts)) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_module_type_attribute', 10, 3);

function lebianchseo_menus()
{
  register_nav_menus(array(
    'header-menu' => 'Header Menu',
    'footer-menu' => 'Footer Menu'
  ));
}

function add_responsive_class($content)
{
  $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
  if (!empty($content)) {
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    $document->loadHTML(utf8_decode($content));
    $imgs = $document->getElementsByTagName('img');
    foreach ($imgs as $img) {
      $classes = $img->getAttribute('class');
      $img->setAttribute('class', $classes . ' img-fluid');
    }
    $html = $document->saveHTML();
    return $html;
  }
}

function abChangeProductsTitle()
{
  echo '<h4 class="woocommerce-loop-product_title prod-h4"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
}

function wc_category_description()
{
  if (is_product_category()) {
    global $wp_query;
    $cat_id = $wp_query->get_queried_object_id();
    $cat_desc = term_description($cat_id, 'product_cat');
    $rt = str_replace('<p>', '', $cat_desc);
    $tr = str_replace('</p>', '', $rt);
    $subtit = '
    <div id="cat_desc_ta" class="p-3 mb-3 rounded-3 bg-secundario">
        <p class="mb-0">
            '. $tr . '<a class="color-primario text-decoration-none" href="#vermas">¿Quieres saber más?</a>
        </p>
    </div>
    ';
    if ( !empty($tr) ) {
       echo $subtit; 
    }
  }
}

function custom_shipping_package_name($name)
{
  return 'Calcular Envío';
}

function dcms_agregar_nueva_zona_widgets()
{
  register_sidebar(array(
    'name'          => 'Widgets TiendaDelAire Sub categorias',
    'id'            => 'id-nueva-zona',
    'description'   => 'Descripción de la nueva Zona de Widgets TiendaDelAire',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<div class="widget-title">',
    'after_title'   => '</div>',
  ));
}


/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available($rates)
{
  $free = array();
  foreach ($rates as $rate_id => $rate) {
    if ('free_shipping' === $rate->method_id) {
      $free[$rate_id] = $rate;
      break;
    }
  }
  return !empty($free) ? $free : $rates;
}

function hide_notices_dashboard()
{
  global $wp_filter;

  if (is_network_admin() and isset($wp_filter["network_admin_notices"])) {
    unset($wp_filter['network_admin_notices']);
  } elseif (is_user_admin() and isset($wp_filter["user_admin_notices"])) {
    unset($wp_filter['user_admin_notices']);
  } else {
    if (isset($wp_filter["admin_notices"])) {
      unset($wp_filter['admin_notices']);
    }
  }
  if (isset($wp_filter["all_admin_notices"])) {
    unset($wp_filter['all_admin_notices']);
  }
}
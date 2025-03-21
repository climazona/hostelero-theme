<?php

//* Mostrar 15 productos por página en WooCommerce
add_filter('loop_shop_per_page', function ($cols) {
    return 16;
}, 20);

add_action('after_setup_theme', 'woocommerce_support');

/* Display field value on the order edit page */
add_action('woocommerce_checkout_update_order_meta', 'wps_select_checkout_field_update_order_meta');

// Add select field value as custom cart item data
add_filter('woocommerce_add_cart_item_data', 'add_cart_item_custom_data', 20, 2);

// Adding Price with VAT to Product Schema
add_filter('woocommerce_structured_data_product', 'priceWithTaxesSEO', 100, 2);

// Adding GTIN and brand to Product Schema
add_filter('woocommerce_structured_data_product', 'custom_set_extra_schema', 20, 2);

// Hook in
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
// Our hooked in function - $fields is passed via the filter!

add_action('woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta_factura', 10, 1);
add_action('woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1);
add_filter("woocommerce_checkout_fields", "custom_order_fields");
add_action('woocommerce_thankyou', 'cloudways_display_order_data', 20);
add_filter('woocommerce_email_order_meta_fields', 'cloudways_email_order_meta_fields', 10, 3);
add_filter('woocommerce_email_order_meta_fields', 'cloudways_email_order_meta_fields_factura', 10, 3);
add_action('woocommerce_email_customer_details', 'cloudways_show_email_order_meta', 30, 3);
add_action('woocommerce_email_customer_details', 'cloudways_show_email_order_meta_factura', 30, 3);
add_filter('woocommerce_email_subject_new_order', 'change_admin_email_subject', 1, 2);
add_action( 'woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image' ) ;

// Change several of the breadcrumb defaults
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );

// Efecto hover en archive product
function add_on_hover_shop_loop_image() {
    
    $images = wc_get_product()->get_gallery_image_ids();
    
    if (isset($images[1])) {
        $image_id = $images[1] ; 
        if ( $image_id ) {
            echo wp_get_attachment_image( $image_id, $size = 'medium'  ) ;
            return;
        }
    }

    echo wp_get_attachment_image( wc_get_product()->get_image_id(), $size = 'medium' ) ; 
}

// Soporte Woocommerce
function woocommerce_support()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

function custom_override_checkout_fields($fields)
{
    $fields['billing']['billing_nif'] = array(
        'label'     => __('DNI / NIF', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => false
    );

    $fields['billing']['billing_factura'] = array(
        'label' => __('Formato y recepción de la factura', 'woocommerce'),
        'type' => 'select',
        'options' => array(
            '' => 'Selecciona',
            "Email" => 'Factura digital al email',
            "Fisíca" => 'Factura física a la dirección de envío'
        ),
        'required' => true,
        'class' => array('form-row-wide validate-state'),
        'clear' => false,
        'option_class' => array('')
    );

    return $fields;
}

function wps_select_checkout_field_update_order_meta($order_id)
{
    if ($_POST['billing_factura']) update_post_meta($order_id, '_billing_factura', esc_attr($_POST['billing_factura']));
}

function my_custom_checkout_field_display_admin_order_meta_factura($order)
{
    echo '<p><strong>' . __('Factura') . ':</strong> ' . get_post_meta($order->get_id(), '_billing_factura', true) . '</p>';
}

function my_custom_checkout_field_display_admin_order_meta($order)
{
    echo '<p><strong>' . __('DNI/NIF') . ':</strong> ' . get_post_meta($order->get_id(), '_billing_nif', true) . '</p>';
}

function custom_order_fields($fields)
{
    $order = array(
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_country',
        'billing_company',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_postcode',
        'billing_nif',
        'billing_state',
        'billing_factura'
    );

    foreach ($order as $field) {
        $ordered_fields[$field] = $fields['billing'][$field];
    }

    $fields['billing'] = $ordered_fields;
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_last_name']['priority'] = 20;
    $fields['billing']['billing_company']['priority'] = 30;
    $fields['billing']['billing_nif']['priority'] = 40;
    $fields['billing']['billing_country']['priority'] = 50;
    $fields['billing']['billing_address_1']['priority'] = 60;
    $fields['billing']['billing_address_2']['priority'] = 70;
    $fields['billing']['billing_postcode']['priority'] = 80;
    $fields['billing']['billing_city']['priority'] = 90;
    $fields['billing']['billing_state']['priority'] = 92;
    $fields['billing']['billing_email']['priority'] = 100;
    $fields['billing']['billing_phone']['priority'] = 95;
    $fields['billing']['billing_factura']['priority'] = 105;

    return $fields;
}

function cloudways_display_order_data($order_id)
{  ?>
    <table class="shop_table shop_table_responsive additional_info">
        <tbody>
            <tr>
                <th><?php _e('DNI/NIF:'); ?></th>
                <td><?php echo get_post_meta($order_id, '_billing_nif', true); ?></td>
            </tr>
            <tr>
                <th><?php _e('Factura:'); ?></th>
                <td><?php echo get_post_meta($order_id, '_billing_factura', true); ?></td>
            </tr>
        </tbody>
    </table>
<?php }

function cloudways_email_order_meta_fields($fields, $sent_to_admin, $order)
{
    $fields['licence'] = array(
        'label' => __('DNI/NIF'),
        'value' => get_post_meta($order->get_id(), '_billing_nif', true),
    );
    return $fields;
}

function cloudways_email_order_meta_fields_factura($fields, $sent_to_admin, $order)
{
    $fields['licence'] = array(
        'label' => __('Factura'),
        'value' => get_post_meta($order->get_id(), '_billing_factura', true),
    );
    return $fields;
}

function cloudways_show_email_order_meta($order, $sent_to_admin, $plain_text)
{
    $cloudways_dropdown = get_post_meta($order->get_id(), '_billing_nif', true);
    if ($plain_text) {
        echo '>DNI / NIF introducido en el pedido: ' . $cloudways_dropdown;
    } else {
        echo '<p><strong>DNI / NIF</strong> introducido en el pedido: ' . $cloudways_dropdown . '</p>';
    }
}

function cloudways_show_email_order_meta_factura($order, $sent_to_admin, $plain_text)
{
    $cloudways_dropdown = get_post_meta($order->get_id(), '_billing_factura', true);
    if ($plain_text) {
        echo 'Como recibir la factura: ' . $cloudways_dropdown;
    } else {
        echo '<p>Como recibir la factura: ' . $cloudways_dropdown . '</p>';
    }
}

function change_admin_email_subject($subject, $order)
{
    global $woocommerce;

    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $price = html_entity_decode(strip_tags(wc_price($order->get_total())));

    $subject = sprintf('Nuevo pedido #%s [%s] - %s', $order->get_id(), $price, $blogname);

    return $subject;
}

function custom_set_extra_schema($schema, $product)
{
    $gtin       = get_post_meta($product->get_id(), '_gtin', true);
    $tag_brand  = get_the_terms($product->get_id(), 'product_tag');

    if (!empty($gtin)) {
        $schema['gtin13'] = $gtin;
    }

    if ($tag_brand && !is_wp_error($tag_brand)) {
        foreach ($tag_brand as $brand) {
            // $schema['brand'] = $brand->name;
            $schema['brand'] = array(
                '@type'  => 'Brand',
                'name'   => $brand->name,
            );
        }
    }

    return $schema;
}

function priceWithTaxesSEO($markup, $product)
{
    if (is_product()) {
        $price = (float)$markup['offers'][0]['priceSpecification'][0]['price'];
        $precioConIVA =  $price + ($price * 0.21);
        $precioConIVA = number_format($precioConIVA, 2, '.', '');

        $markup['offers'][0]['price'] = $precioConIVA;
        $markup['offers'][0]['priceSpecification']['price'] = $precioConIVA;
        // Especifica si el impuesto al valor agregado (IVA) aplicable está incluido en la especificación de precio o no.
        $markup['offers'][0]['priceSpecification']['valueAddedTaxIncluded'] = 'true';
    }
    return $markup;
}

function add_cart_item_custom_data($cart_item_data, $product_id)
{
    if (isset($_POST['type'])) {
        $cart_item_data['custom_data'] = $_POST['type'];
    }
    return $cart_item_data;
}

function woocommerce_button_proceed_to_checkout()
{ ?>
    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-button button alt wc-forward">
        <?php esc_html_e('Siguiente', 'woocommerce'); ?> <i class="bi bi-chevron-right"></i>
    </a>
<?php
}

add_filter( 'woocommerce_states', 'custom_es_states', 10, 1 );
function custom_es_states( $states ) {
    $non_allowed_es_states = array( 'PM', 'ML', 'CE', 'GC', 'TF'); 

    // Loop through your non allowed us states and remove them
    foreach( $non_allowed_es_states as $state_code ) {
        if( isset($states['ES'][$state_code]) )
            unset( $states['ES'][$state_code] );
    }
    return $states;
}

function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' <i class="bi bi-chevron-right"></i> ',
            'wrap_before' => '
            <div class="container-fluid bg-theme-primary-light mb-3 mb-md-4"> <div class="container py-2"> <nav class="woocommerce-breadcrumb mb-0" itemprop="breadcrumb">',
            'wrap_after'  => '</nav> </div> </div>',
            'before'      => '',
            'after'       => ''
        );
}

add_action( 'woocommerce_review_order_before_submit', 'custom_privacy_checkbox', 9 );

function custom_privacy_checkbox() {

    woocommerce_form_field( 'privacy_policy', array(
        'type'          => 'checkbox',
        'class'         => array('form-row privacy'),
        'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'required'      => true,
        'label'         => 'He leído y estoy de acuerdo con la <a href="/politica-de-privacidad" target="_blank">política de privacidad</a>.',
   ) );

}

add_action( 'woocommerce_checkout_process', 'custom_privacy_checkbox_error_message' );

function custom_privacy_checkbox_error_message() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
        wc_add_notice( __( 'Debes aceptar nuestra política de privacidad para proceder' ), 'error' );
    }
}
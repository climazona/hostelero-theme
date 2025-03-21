<?php

// Parámetro global para habilitar o deshabilitar funcionalidades de entrega personalizada.
define('DESACTIVAR_SERVICIOS_DOMICILIO', true);

define('WP_ENVIOS', true);

function envios_get_config() {
    $tarifa = [
        '25,43,17' => [19], // Lleida, Tarragona, Girona
        '08' => [28.92], // Barcelona
        '28' => [24.79], // Madrid
        '46,30,50' => [35], // Valencia, Murcia, Zaragoza
        '29,03,48,41' => [45], // Málaga, Alicante, Bilbao, Sevilla
        '00' => [55], // Resto de España
    ];

    return [
        'paqueteria' => [
            'tarifas' => [
                '25' => [0], // mínimo
                '00' => [0]
            ]
        ],
        'entrega-pie-calle' => [
            'tarifas' => [
                '25' => [0, 0], // mínimo, porcentaje
                '08,43,17' => [0, 0],
                '00' => [0, 0]
            ]
        ],
        'entrega-pie-calle-domicilio' => [
            'servicios' => ['domicilio', 'recogida'],
            'tarifas' => $tarifa
        ],
        'entrega-pie-calle-domicilio-instalacion' => [
            'servicios' => ['domicilio', 'recogida', 'instalacion'],
            'tarifas' => $tarifa
        ],
        'entrega-especial-frigo-americano' => [
            'servicios' => ['domicilio', 'recogida', 'instalacion'],
            'tarifas' => $tarifa,
            'suplemento' => 24.79 // Suplemento frigorífico americano
        ],
    ];
}

function calcular_entrega_pie_calle($itemPrice, $quantity, $tarifa) {
    $minimo = $tarifa[0] ?? 0;
    $porcentaje = $tarifa[1] ?? 0;
    
    $shippingPrice = $itemPrice * $quantity;
    $shippingCost = ($porcentaje / 100) * $shippingPrice;
    
    $shippingPrice += $shippingCost;

    return max($shippingPrice, $minimo);
}

function get_shipping_cost($tipoEnvio, $postcode, $itemPrice, $quantity) {
    if (!isset($tipoEnvio) || $tipoEnvio == '') return 0;

    $itemPrice = floatval($itemPrice);
    $postcodeStart = substr($postcode, 0, 2);

    $config = envios_get_config();

    if (!isset($config[$tipoEnvio])) return 0;

    $tipoEnvioConfig = $config[$tipoEnvio];

    $tarifa = $tipoEnvioConfig['tarifas']['00'] ?? [0, 0];
    foreach ($tipoEnvioConfig['tarifas'] as $postCodeKey => $tarifaValue) {
        if (!empty($postcodeStart) && strpos($postCodeKey, $postcodeStart) !== false) {
            $tarifa = $tarifaValue;
            break;
        }
    }

    switch ($tipoEnvio) {
        case 'paqueteria':
            return $tarifa[0] * $quantity;

        case 'entrega-pie-calle':
            return calcular_entrega_pie_calle($itemPrice, $quantity, $tarifa);

        case 'entrega-pie-calle-domicilio':
        case 'entrega-pie-calle-domicilio-instalacion':
            if (!DESACTIVAR_SERVICIOS_DOMICILIO) {
                return $tarifa[0] * $quantity;
            }
            return calcular_entrega_pie_calle($itemPrice, $quantity, $tarifa);

        case 'entrega-especial-frigo-americano':
            if (!DESACTIVAR_SERVICIOS_DOMICILIO) {
                $suplemento = $config['entrega-especial-frigo-americano']['suplemento'];
                return ($tarifa[0] + $suplemento) * $quantity;
            }
            return calcular_entrega_pie_calle($itemPrice, $quantity, $tarifa);

        default:
            return 0;
    }
}

function ocultar_servicios_adicionales($tipoEnvio) {
    $config = envios_get_config();

    if (DESACTIVAR_SERVICIOS_DOMICILIO) {
        return true;
    }
    
    if (!isset($config[$tipoEnvio]) || !isset($config[$tipoEnvio]['servicios'])) {
        return true;
    }
    
    return false;
}


function add_field_envios() {
    $_product = wc_get_product();
    $tipoEnvio = $_product->get_shipping_class();

    if (!isset($tipoEnvio) || $tipoEnvio == '') return;

    if (ocultar_servicios_adicionales($tipoEnvio)) return; // Ocultar si corresponde.

    $config = envios_get_config();
    if (!isset($config[$tipoEnvio])) return;

    $tipoEnvioConfig = $config[$tipoEnvio];
    $servicios = $tipoEnvioConfig['servicios'] ?? [];

    // Si no hay servicios definidos, no generamos nada
    if (empty($servicios)) return;

    $html = "
    <section>
        <h6>Servicios disponibles</h6>  
        <ul>  
    ";

    // Generar dinámicamente la lista de servicios
    foreach ($servicios as $servicio) {
        $html .= "
            <li>" . ucfirst($servicio) . "</li>
        ";
    }

    $html .= "
        </ul>  
        Podrás añadir los servicios en el carrito.  
    </section>
    ";

    echo $html;
}
add_action('woocommerce_before_add_to_cart_quantity', 'add_field_envios', 10);

function envios_hide_services_in_cart($cart_item, $key) {
    $tipoEnvio = $cart_item['data']->get_shipping_class();

    if (ocultar_servicios_adicionales($tipoEnvio)) {
        $config = envios_get_config();
        if (isset($config[$tipoEnvio]['servicios'])) {
            foreach ($config[$tipoEnvio]['servicios'] as $servicio) {
                unset($cart_item["envio_tiene_$servicio"]);
            }
        }
    } else {
        $config = envios_get_config();
        if (isset($config[$tipoEnvio])) {
            $servicios = $config[$tipoEnvio]['servicios'] ?? [];
            foreach ($servicios as $servicio) {
                $cart_item["envio_tiene_$servicio"] = [
                    'key' => "envio_tiene_$servicio",
                    'value' => $cart_item["envio_tiene_$servicio"]['value'] ?? false
                ];
            }
        }
    }

    return $cart_item;
}
add_filter('woocommerce_get_cart_item_from_session', 'envios_hide_services_in_cart', 10, 2);

function validate_checkbox_state($cart_item) {
    if (isset($cart_item['envio_tiene_domicilio']) && !$cart_item['envio_tiene_domicilio']['value']) {
        foreach ($cart_item as $key => $service) {
            if (strpos($key, 'envio_tiene_') === 0 && $key !== 'envio_tiene_domicilio') {
                $cart_item[$key]['value'] = false;
            }
        }
    }

    return $cart_item;
}
add_filter('woocommerce_cart_item_data', 'validate_checkbox_state', 10, 1);


/*
 * Añadir información de envío predeterminada al añadir al carrito
 */
function add_cart_item_envios_data($cart_item_data, $product_id) {
    $_product = wc_get_product($product_id);
    if (!$_product) return $cart_item_data;
    
    $tipoEnvio = $_product->get_shipping_class();
    if (isset($tipoEnvio) && $tipoEnvio != '') {
        $tipoEnvioConfig = envios_get_config()[$tipoEnvio] ?? [];
    }

    $cart_item_data['shipping_class'] = [
        'key' => 'shipping_class',
        'value' => $tipoEnvio
    ];

    if (isset($tipoEnvioConfig['servicios'])) {
        foreach ($tipoEnvioConfig['servicios'] as $servicio) {
            $cart_item_data["envio_tiene_$servicio"] = [
                'key' => "envio_tiene_$servicio",
                'value' => false // Valor predeterminado
            ];
        }
    }

    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'add_cart_item_envios_data', 21, 2);

/*
 * Mostrar información del de envío en los detalles de pedido y en la pagina de administración de pedidos
 */
function envios_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
  if ( isset( $values['shipping_class'] ) ) {
    $item->add_meta_data(
      'shipping_class',
      $values['shipping_class']['value'],
      false
    );
  }

  if ( isset( $values['es_paqueteria'] ) ) {
    $item->add_meta_data(
      'es_paqueteria',
      $values['es_paqueteria']['value'],
      false
    );
  }

  if ( isset( $values['es_entrega_domicilio'] ) ) {
    $item->add_meta_data(
      'es_entrega_domicilio',
      $values['es_entrega_domicilio']['value'],
      false
    );
  }

  if ( isset( $values['envio_tiene_recogida'] ) ) {
    $item->add_meta_data(
      'envio_tiene_recogida',
      $values['envio_tiene_recogida']['value'],
      false
    );
  }

  if ( isset( $values['envio_tiene_instalacion'] ) ) {
    $item->add_meta_data(
      'envio_tiene_instalacion',
      $values['envio_tiene_instalacion']['value'],
      false
    );
  } 
}
add_filter( 'woocommerce_checkout_create_order_line_item', 'envios_checkout_create_order_line_item', 10, 4 );

/*
 * Añade al informe de carrito la edición de los envios
 */
function envios_after_cart_item_name($cart_item, $cart_item_key) {
    
    if (DESACTIVAR_SERVICIOS_DOMICILIO) return;

    if (!isset($cart_item['shipping_class'])) return;

    $tipoEnvio = $cart_item['shipping_class']['value'];
    $config = envios_get_config();

    if (!isset($config[$tipoEnvio]['servicios'])) return; 

    $servicios = $config[$tipoEnvio]['servicios'];
    if (empty($servicios)) return;
  
    $shippingPrice = 0;
    $cart = WC()->cart;
    $has_calculated_shipping = $cart->show_shipping();

    if ($has_calculated_shipping) {
        $packages = $cart->get_shipping_packages() ?? [];
        $postcode = $packages[0]['destination']['postcode'] ?? '';

        $itemPrice = $cart_item['data']->get_price();
        $quantity = $cart_item['quantity'];
        $shippingPrice = get_shipping_cost($tipoEnvio, $postcode, $itemPrice, $quantity);
        $vatRate = 0.21;
        $shippingPriceWithVat = $shippingPrice * (1 + $vatRate);

        $shippingPriceFormatted = number_format($shippingPrice, 2, ',', '.');
        $shippingPriceWithVatFormatted = number_format($shippingPriceWithVat, 2, ',', '.');
    }

    $html = "<section>
        <h6>Servicios disponibles</h6>  
        <ul class='list-group' data-item='item-service-{$cart_item_key}'>";

    foreach ($servicios as $servicio) {
        $serviceKey = $servicio === 'domicilio' ? 'es_entrega_domicilio' : "envio_tiene_{$servicio}";
        $checked = isset($cart_item[$serviceKey]['value']) && $cart_item[$serviceKey]['value'] ? 'checked' : '';
        $disabled = ($servicio !== 'domicilio' && (!isset($cart_item['es_entrega_domicilio']) || !$cart_item['es_entrega_domicilio']['value'])) ? "disabled='disabled'" : '';

        $html .= "<li class='list-group-item'>
            <input class='form-check-input me-1' type='checkbox' data-item='{$serviceKey}' data-value='{$cart_item_key}' id='{$serviceKey}-{$cart_item_key}' name='cart[{$cart_item_key}][{$serviceKey}]' {$checked} {$disabled}/>
            <label class='d-inline form-check-label stretched-link' for='{$serviceKey}-{$cart_item_key}'>
                " . ucfirst($servicio) . ($servicio === 'domicilio' && $shippingPrice > 0 ? ": {$shippingPriceFormatted}€ +IVA ({$shippingPriceWithVatFormatted}€ IVA Incluido)" : '') . "
            </label>
        </li>";
    }

    $html .= "</ul></section>";

    echo $html;
}
add_filter('woocommerce_after_cart_item_name', 'envios_after_cart_item_name', 10, 2);

function envios_update_cart_action_cart_updated($cart_updated) {
    $contents = WC()->cart->get_cart();

    foreach ($contents as $key => &$item) {
        // Actualiza el valor de "Entrega a domicilio" en base a los datos enviados por el formulario
        if (isset($_POST['cart'][$key]['es_entrega_domicilio'])) {
            $item['es_entrega_domicilio']['value'] = true;
        } else {
            $item['es_entrega_domicilio']['value'] = false;
        }

        // Actualiza el valor de "Recogida"
        if (isset($_POST['cart'][$key]['envio_tiene_recogida'])) {
            $item['envio_tiene_recogida']['value'] = true;
        } else {
            $item['envio_tiene_recogida']['value'] = false;
        }

        // Actualiza el valor de "Instalación"
        if (isset($_POST['cart'][$key]['envio_tiene_instalacion'])) {
            $item['envio_tiene_instalacion']['value'] = true;
        } else {
            $item['envio_tiene_instalacion']['value'] = false;
        }
    }

    WC()->cart->set_cart_contents($contents); // Guarda los cambios en el carrito
    return $cart_updated;
}
add_filter('woocommerce_update_cart_action_cart_updated', 'envios_update_cart_action_cart_updated');

/**
 * Añade al carrito los servicios como tarifa adicional
 */
function envios_woocommerce_cart_calculate_fees( $cart ) {
  if ( is_admin() && ! defined( 'DOING_AJAX' ) )
      return;

  $shippingPrice = 0;
  $postcode = '';

  $has_calculated_shipping = $cart->show_shipping();

  if ($has_calculated_shipping) {
    $packages = $has_calculated_shipping ? $cart->get_shipping_packages() : [];  
    $postcode = $packages[0]['destination']['postcode'];    
  }

  $total = 0;
  $totalQuantity = 0;
  $totalRecogida = 0;
  $totalInstalacion = 0;
  foreach ($cart->get_cart_contents() as $cart_item) {          
    if (!isset($cart_item['shipping_class'])) continue;
    if (!isset($cart_item['es_entrega_domicilio'])) continue;

    if ($cart_item['es_entrega_domicilio']['value'] === false) continue;

    $tipoEnvio = $cart_item['shipping_class']['value'];    

    $itemPrice = $cart_item['data']->get_price();
    $quantity = $cart_item['quantity'];
    $shippingPrice = get_shipping_cost($tipoEnvio, $postcode, $itemPrice, $quantity);

    if ( $shippingPrice > 0 ) $total = $total + $shippingPrice;
    if ( $quantity > 0 ) $totalQuantity = $quantity + $totalQuantity;

    if ( isset( $cart_item['envio_tiene_recogida'] ) && $cart_item['envio_tiene_recogida']['value'] == 1 ) {
      $totalRecogida = $totalRecogida + $quantity;
    }

    if ( isset( $cart_item['envio_tiene_instalacion'] ) && $cart_item['envio_tiene_instalacion']['value'] == 1 ) {
      $totalInstalacion = $totalInstalacion + $quantity;
    }
  }

  if ($total > 0) {
    $cart->add_fee(sprintf(
        __('Servicio: Entrega a domicilio (%d artículos)', 'woocommerce'),
        $totalQuantity
    ), $total, true, '');
  }

  if ($totalRecogida > 0) {
    $cart->add_fee(sprintf(
        __('Servicio: Recogida de producto antiguo (%d artículos)', 'woocommerce'),
        $totalRecogida
    ), 0, false);
  }

  if ($totalInstalacion > 0) {
    $cart->add_fee(sprintf(
        __('Servicio: Instalación (%d artículos)', 'woocommerce'),
        $totalInstalacion
    ), 0, false);
  }
}
add_filter( 'woocommerce_cart_calculate_fees', 'envios_woocommerce_cart_calculate_fees', 10, 1 );

/**
 * Cambia el texto de 0 por Gratis en las lineas de servicios
 */
function envios_cart_totals_fee_html( $label, $fee ) {  
    if ( $fee->total == 0 ) {
        $label = 'Gratis';
    }
    return $label;
}
add_filter( 'woocommerce_cart_totals_fee_html', 'envios_cart_totals_fee_html', 10, 2 );

/**
 * Detalla en el checkout las lineas de servicio
 */
function wc_envios_get_formatted_cart_item_data($cart, $cart_item) {
  $quantity = $cart_item['quantity'];
  $shippingPrice = 0;

  $has_calculated_shipping = $cart->show_shipping();

  if ($has_calculated_shipping && isset($cart_item['shipping_class'])) {
    $packages = $has_calculated_shipping ? $cart->get_shipping_packages() : [];  
    $postcode = $packages[0]['destination']['postcode'];

    $tipoEnvio = $cart_item['shipping_class']['value'];
    $itemPrice = $cart_item['data']->get_price();
    $quantity = $cart_item['quantity'];
    $shippingPrice = get_shipping_cost($tipoEnvio, $postcode, $itemPrice, $quantity);
  }

  $html = '';

  if ( isset( $cart_item['es_entrega_domicilio'] ) && $cart_item['es_entrega_domicilio']['value'] == 1 ) {
    $total = wc_price( $shippingPrice );
    $html .= "
      <tr>
        <td class='product-name'>
          Servicio: Entrega a domicilio x <strong>{$quantity}</strong>
        </td>      
        <td class='product-total'>
          {$total}
        </td>
      </tr>
    ";
  }

  if ( isset( $cart_item['envio_tiene_recogida'] ) && $cart_item['envio_tiene_recogida']['value'] == 1 ) {
    $html .= "
      <tr>
        <td class='product-name'>
          Servicio: Retirada del antiguo x <strong>{$quantity}</strong>
        </td>      
        <td class='product-total'>
          Gratis
        </td>
      </tr>
    ";
  }

  if ( isset( $cart_item['envio_tiene_instalacion'] ) && $cart_item['envio_tiene_instalacion']['value'] == 1 ) {
    $html .= "
      <tr>
        <td class='product-name'>
          Servicio: Instalación x <strong>{$quantity}</strong>
        </td>      
        <td class='product-total'>
          Gratis
        </td>
      </tr>
    ";
  }

  return $html;
}

/**
 * Detalle en la página de cliente los servicios
 */
function wc_envios_get_formatted_order_item_meta(
  \Automattic\WooCommerce\Admin\Overrides\Order $order, 
  WC_Order_Item_Product $item) {
  $quantity = $item->get_quantity();
  $shippingPrice = 0;
  
  $itemPrice = $item->get_product()->get_price();
  $postcode = $order->get_shipping_postcode();
  $tipoEnvio = '';

  foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {    
    if ($meta->key == 'shipping_class') {
      $tipoEnvio =$meta->value;
      break;
    }
  }  

  $shippingPrice = get_shipping_cost($tipoEnvio, $postcode, $itemPrice, $quantity);
  $html = ''; 

  foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {
    $key = $meta->key;
    $value = $meta->value;
    
    if ( $key === 'es_entrega_domicilio' && $value === 1 ) {
      $total = wc_price( $shippingPrice );
      $html .= "
        <tr>
          <td class='product-name'>
            Servicio: Entrega a domicilio x <strong>{$quantity}</strong>
          </td>      
          <td class='product-total'>
            {$total}
          </td>
        </tr>
      ";
    }

    if ( $key == 'envio_tiene_recogida' && $value == 1 ) {
      $html .= "
        <tr>
          <td class='product-name'>
            Servicio: Retirada del antiguo x <strong>{$quantity}</strong>
          </td>      
          <td class='product-total'>
            Gratis
          </td>
        </tr>
      ";
    }
  
    if ( $key  === 'envio_tiene_instalacion' && $value == 1 ) {
      $html .= "
        <tr>
          <td class='product-name'>
            Servicio: Instalación x <strong>{$quantity}</strong>
          </td>      
          <td class='product-total'>
            Gratis
          </td>
        </tr>
      ";
    }
  }

  return $html;  
}

/**
 * Detalle del total de los servicios en el carrito
 */
function wc_envios_cart_totals_services_html() {
  $total = 0;

  foreach ( WC()->cart->get_fees() as $fee ){
    $total = $total + $fee->amount;     
  }
  
  if ($total == 0) return '';

  $total = wc_price($total);

  $html = "
    <tr>
      <th>Servicios adicionales</th>
      <td>{$total}</td>
    </tr>
  ";

  return $html;
}

/**
 * Script de actualización de los inputs de los servicios en la pagina de carrito 
 */
function wc_envios_footer_add_scripts() {
  if ( ! is_cart() ) return;

  ?>
    <script>
      let autoUpdateCartTimeout = null;

      // Actualiza el carrito automáticamente cuando hay cambios
      function onUpdateCartStatus() {
        console.log('onChange');
        if (autoUpdateCartTimeout !== null) clearTimeout(autoUpdateCartTimeout);

        // Si el valor es vacío, no procesar
        if ($(this).val() == '') return;

        autoUpdateCartTimeout = setTimeout(function() {
          let $updateCartButton = $('[name="update_cart"]');
          if ($updateCartButton.length > 0) {
            $updateCartButton.trigger('click');
          }
        }, 500);
      }

      // Actualiza los checkboxes de servicios en función del estado de "Entrega a domicilio"
      function updateServicesInputs() {
        $('[data-item="es_entrega_domicilio"]').on('change', function(e) {
          const key = $(this).data('value');
          const $itemContainer = $(`[data-item="item-service-${key}"]`);

          if (e.target.checked) {
            console.log(`Activando servicios para: ${key}`);
            $itemContainer.find('[data-item^="envio_tiene_"]').removeAttr('disabled');
          } else {
            console.log(`Desactivando servicios para: ${key}`);
            $itemContainer.find('[data-item^="envio_tiene_"]').prop('checked', false).attr('disabled', 'disabled');
          }
        });
      }

      // Vincula eventos de cambio y actualización de carrito
      $(document).ready(function() {
        $('div.woocommerce').on('change keyup', 'input.qty', onUpdateCartStatus);
        $('div.woocommerce').on('change', '[data-item="envio_tiene_recogida"], [data-item="envio_tiene_instalacion"], [data-item="es_entrega_domicilio"]', onUpdateCartStatus);
        $(document.body).on('added_to_cart removed_from_cart updated_cart_totals', updateServicesInputs);

        // Inicializa los inputs al cargar
        updateServicesInputs();
      });
    </script>
  <?php
}
add_action('wp_footer', 'wc_envios_footer_add_scripts');


function wc_envios_hide_update_cart_button() {
  if ( ! is_cart() ) return;  
?> 
	<style>
		.woocommerce button[name="update_cart"], .woocommerce input[name="update_cart"] {
			display: none;
		}
  </style>
<?php 
}
add_action( 'wp_head', 'wc_envios_hide_update_cart_button' );

/**
 * Validar que los productos con servicios opcionales tengan entrega a domicilio
 */
function validar_servicios_envios($passed, $product_id, $quantity) {
    $cart = WC()->cart->get_cart();

    foreach ($cart as $cart_item) {
        $has_domicilio = isset($cart_item['es_entrega_domicilio']) && $cart_item['es_entrega_domicilio']['value'];
        $has_recogida = isset($cart_item['envio_tiene_recogida']) && $cart_item['envio_tiene_recogida']['value'];
        $has_instalacion = isset($cart_item['envio_tiene_instalacion']) && $cart_item['envio_tiene_instalacion']['value'];

        if (($has_recogida || $has_instalacion) && !$has_domicilio) {
            wc_add_notice(__('Error: Los servicios de instalación o retirada del antiguo requieren el servicio de entrega a domicilio.', 'woocommerce'), 'error');
            $passed = false;
            break;
        }
    }

    return $passed;
}
add_filter('woocommerce_add_to_cart_validation', 'validar_servicios_envios', 10, 3);

/**
 * Validar en la actualización del carrito
 */
function validar_actualizacion_carrito() {
    $cart = WC()->cart->get_cart();
    $error = false;

    foreach ($cart as $cart_item) {
        $has_domicilio = isset($cart_item['es_entrega_domicilio']) && $cart_item['es_entrega_domicilio']['value'];
        $has_recogida = isset($cart_item['envio_tiene_recogida']) && $cart_item['envio_tiene_recogida']['value'];
        $has_instalacion = isset($cart_item['envio_tiene_instalacion']) && $cart_item['envio_tiene_instalacion']['value'];

        if (($has_recogida || $has_instalacion) && !$has_domicilio) {
            wc_add_notice(__('Error: Los servicios de instalación o retirada del antiguo requieren el servicio de entrega a domicilio.', 'woocommerce'), 'error');
            $error = true;
            break;
        }
    }

    if ($error) {
        remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
        add_action('woocommerce_proceed_to_checkout', function() {
            echo '<div class="woocommerce-error">' . __('Corrige los errores del carrito antes de proceder al pago.', 'woocommerce') . '</div>';
        }, 20);
    }
}
add_action('woocommerce_check_cart_items', 'validar_actualizacion_carrito');
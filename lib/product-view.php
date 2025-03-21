<?php

function lebianch_abre_row() {
    echo '
        <!-- start product row -->
        <div class="row">
            <!-- start product left column -->
            <div class="col-12 col-lg-5 mb-3">
                <div class="p-4 border rounded-3">
    ';
};

function lebianch_cierra_row() {
    echo '
            </div>
        </div>
        <!-- end product left column -->
        
        <!-- start product right column -->
        <div class="col-12 col-lg-7">
            
    ';
    
    echo mostrar_etiqueta_producto();
    
    global $product;
  
    if ($product) {
    
        /**
         * Obtiene el pronóstico de entrega.
         */
        function get_delivery_forecast($stock_quantity, $availability_status) {
            setlocale(LC_TIME, 'es_ES.UTF-8');
            date_default_timezone_set('Europe/Madrid');
            $current_time = time();
            $delivery_delay = (date('H', $current_time) >= 15) ? 1 : 0;
    
            $delivery_date_start = strtotime("+1 weekday +{$delivery_delay} day", $current_time);
            $delivery_date_end   = strtotime("+3 weekdays +{$delivery_delay} day", $current_time);
    
            $is_tomorrow = date('Y-m-d', $delivery_date_start) === date('Y-m-d', strtotime('+1 day', $current_time));
    
            $start_date_text = $is_tomorrow ? "mañana" : strftime('%A %e de %B', $delivery_date_start);
            $end_date_text   = strftime('%A %e de %B', $delivery_date_end);
    
            // Para los casos en que haya stock (o no) se muestra el rango de fechas
            if (in_array($availability_status, ['Product in stock', 'Product on request'])) {
                if ($stock_quantity > 0) {
                    return "Recíbelo entre <strong>$start_date_text</strong> y <strong>$end_date_text</strong>.";
                }
                return "Consúltanos el plazo de entrega.";
            } elseif ($availability_status === 'Product to be removed') {
                if ($stock_quantity > 0) {
                    return "Recíbelo entre <strong>$start_date_text</strong> y <strong>$end_date_text</strong>.";
                }
                return "Producto descatalogado.";
            }
        }
    
        /**
         * Obtiene el mensaje de envío gratis.
         */
        function get_free_shipping_message() {
            global $product;
    
            if (!$product) {
                return '<ul class="list-group list-group-flush small">
                            <li class="list-group-item">Consulta las condiciones de envío en el carrito.</li>
                        </ul>';
            }
    
            $product_price = (float) $product->get_price();
            $shipping_zones = WC_Shipping_Zones::get_zones();
    
            foreach ($shipping_zones as $zone) {
                if ($zone['zone_name'] === 'Envío') {
                    foreach ($zone['shipping_methods'] as $method) {
                        if ($method->id === 'free_shipping' && $method->is_enabled()) {
                            $min_amount = isset($method->min_amount) ? (float) $method->min_amount : 0.0;
                            // Se calcula el mínimo con IVA (suponiendo un 21% de IVA)
                            $min_amount_with_tax = number_format(ceil($min_amount * 1.21), 2, ',', '') . ' €';
    
                            if ($product_price >= $min_amount_with_tax) {
                                $message = '<li class="list-group-item"><i class="bi bi-check-circle-fill me-1 text-success"></i> Entrega gratis (solo península)</li>';
                            } else {
                                $message = '<li class="list-group-item">Envío gratis a partir de ' . $min_amount_with_tax . ' (IVA Incluido)</li>';
                            }
                            return '<ul class="list-group list-group-flush small">' . $message . '</ul>';
                        }
                    }
                }
            }
    
            return '<ul class="list-group list-group-flush small">
                        <li class="list-group-item">Consulta las condiciones de envío en el carrito.</li>
                    </ul>';
        }
    
        /**
         * Renderiza la tarjeta de entrega.
         *
         * Se agrega el mensaje de envío gratis salvo en el caso de "Product to be removed" sin stock.
         * Además, se muestra un pie de tarjeta con información de tiempo de entrega cuando procede.
         */
        function render_delivery_card($delivery_forecast, $free_shipping_message, $availability_status, $stock_quantity) {
            $footer = '';
            // En stock o producto por encargo (incluso sin stock) muestran el pie con tiempo de entrega
            if ($stock_quantity > 0 || ($stock_quantity <= 0 && $availability_status === 'Product in stock')) {
                $footer = '<div class="card-footer text-body-secondary small">
                            Según nuestro tiempo de entrega promedio. Para productos voluminosos la entrega es a pie de calle.
                        </div>';
            }
            // Para "Product to be removed" sin stock se omite el mensaje de envío gratis
            $freeShipping = ($availability_status === 'Product to be removed' && $stock_quantity <= 0) ? '' : $free_shipping_message;
    
            return '<div class="card mb-3">
                        <div class="card-header"><i class="bi bi-truck me-1"></i> Entrega a domicilio</div>
                        <div class="card-body">' . $delivery_forecast . '</div>'
                        . $freeShipping .
                        $footer .
                    '</div>';
        }
    
        /**
         * Renderiza la tarjeta de disponibilidad.
         *
         * Dependiendo del stock y tipo de producto, se asignan clases, textos y pies de tarjeta.
         */
        function render_availability_card($availability_status, $stock_quantity) {
            if ($stock_quantity === 1) {
                $stockText = '1 unidad en stock.';
                $spinner   = '<div class="spinner-grow spinner-grow-sm text-success" role="status"></div>';
                $footer    = '';
            } elseif ($stock_quantity > 1) {
                $stockText = $stock_quantity . ' unidades en stock.';
                $spinner   = '<div class="spinner-grow spinner-grow-sm text-success" role="status"></div>';
                $footer    = '';
            } else {
                if ($availability_status === 'Product in stock') {
                    $stockText = 'Sin stock, en reposición.';
                    $spinner   = '<div class="spinner-grow spinner-grow-sm text-warning" role="status"></div>';
                    $footer    = '<div class="card-footer text-body-secondary small">
                                    Agotado temporalmente. <a href="/contacto/">Consultar disponibilidad.</a>
                                  </div>';
                } elseif ($availability_status === 'Product to be removed') {
                    $stockText = 'Sin stock.';
                    $spinner   = '<div class="spinner-grow spinner-grow-sm text-danger" role="status"></div>';
                    $footer    = '<div class="card-footer text-body-secondary small">
                                    Agotado permanentemente, producto descatalogado.
                                  </div>';
                } elseif ($availability_status === 'Product on request') {
                    $stockText = 'Sin stock.';
                    $spinner   = '<div class="spinner-grow spinner-grow-sm text-warning" role="status"></div>';
                    $footer    = '<div class="card-footer text-body-secondary small">
                                    Producto por encargo. <a href="/contacto/">Consultar disponibilidad.</a>
                                  </div>';
                }
            }
    
            return '<div class="card">
                        <div class="card-header"><i class="bi bi-box-seam me-1"></i> Disponibilidad</div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                ' . $spinner . '
                                <p class="m-0 ms-2">' . $stockText . '</p>
                            </div>
                        </div>'
                        . $footer .
                    '</div>';
        }
    
        // Variables del producto
        $availability_status  = $product->get_meta('_availability_status');
        $stock_quantity       = $product->get_stock_quantity();
        $delivery_forecast    = get_delivery_forecast($stock_quantity, $availability_status);
        $free_shipping_message= get_free_shipping_message();
    
        // Renderizamos las dos tarjetas: Entrega y Disponibilidad
        echo render_delivery_card($delivery_forecast, $free_shipping_message, $availability_status, $stock_quantity);
        echo render_availability_card($availability_status, $stock_quantity);
    }
    
    echo display_store_notice();
    
    echo generate_social_share_component();
    
    echo '
            <div>
                '. do_shortcode('[cusrev_trustbadge type="VSL" color="#FFFFFF"]') .'
            </div>
            
        </div>
        <!-- end product right column -->
    </div>
    <!-- end product row -->
    ';
}
<?php

function custom_checkout_field() {
    // Verifica si algún producto en el carrito tiene el campo "gases_fluorados" activado
    $has_gases_fluorados = false;
    foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
        $product = $cart_item['data'];
        if ( get_field( 'gases_fluorados', $product->get_id() ) ) {
            $has_gases_fluorados = true;
            $gases_fluorados_products[] = array(
                'name' => $product->get_name(),
                'quantity' => $cart_item['quantity'],
            );
        }
    }

    // Si hay algún producto con el campo "gases_fluorados" activado, muestra el check personalizado
    if ( $has_gases_fluorados ) {
        ?>
        <p class="form-row custom-checkbox">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="custom_checkbox" id="custom_checkbox" required> He leído y acepto el <a href="#gasesModal" data-bs-toggle="modal" data-bs-target="#gasesModal">Requerimiento del Real Decreto 115/2017, Anexo VI, Parte A</a>.
                <abbr class="required" title="obligatorio">*</abbr>
            </label>
        </p>
        
        <!-- Modal -->
        <div class="modal fade" id="gasesModal" tabindex="-1" aria-labelledby="gasesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="gasesModalLabel">Anexo VI - Parte A</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Tienes agregado en el carrito uno o varios equipos no herméticamente sellados, cargados con gases fluorados de efecto invernadero, que requieren ser instalados por una empresa habilitada con personal certificado para su instalación.
                        </p>
                        <p>
                            Al marcar la casilla de verificación, das tu consentimiento para recibir un correo electrónico de VIAFIRMA S.L., CIF B-91052142. Dicho correo solicitará tu firma manuscrita de la Parte A del Anexo VI del Real Decreto 115/2017, proceso que podrás realizar tanto desde dispositivos táctiles como de escritorio utilizando un ratón.
                        </p>
                        <p>Puede consultar la información básica aquí: <a href="https://tiendadelaire.com/terminos-y-condiciones/#gases-fluorados" target="_blank">Términos y condiciones</a></p>
                        <p>Lista de productos adheridos al carrito no herméticamente sellados, cargados con gases fluorados de efecto invernadero:</p>
                        <ul class="list-group mb-4">
                            <?php foreach ( $gases_fluorados_products as $product ) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $product['name'] ?>
                                    <span class="badge bg-primary rounded-pill">
                                        <?php echo $product['quantity'] ?> unidad(es)
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
add_action( 'woocommerce_review_order_before_submit', 'custom_checkout_field' );

// Valida el check personalizado antes de permitir que la compra sea completada
function validate_custom_checkout_field() {
    // Verifica si algún producto en el carrito tiene el campo "gases_fluorados" activado
    $has_gases_fluorados = false;
    foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
        $product = $cart_item['data'];
        if ( get_field( 'gases_fluorados', $product->get_id() ) ) {
            $has_gases_fluorados = true;
            break;
        }
    }

    // Si hay algún producto con el campo "gases_fluorados" activado y el check no está marcado, muestra un error
    if ( $has_gases_fluorados && empty( $_POST['custom_checkbox'] ) ) {
        wc_add_notice( __( 'Tienes agregado en el carrito uno o varios equipos no herméticamente sellados, para continuar debes aceptar y firmar el "Anexo VI - Parte A" marcando la correspondiente casilla.' ), 'error' );
    }
}
add_action( 'woocommerce_checkout_process', 'validate_custom_checkout_field');
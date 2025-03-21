<?php
/* Añadir info al producto */
add_action('woocommerce_after_add_to_cart_button', 'add_field_servicio_de_instalacion', 15);

function get_servicio_instalacion_cnf(){
    global $product;
    
  return  [
    'true' =>
    '
        <div class="accordion-item bg-secundario">
            <div class="accordion-header lh-base" id="product-headingOne">
                <button class="accordion-button collapsed px-0 py-2 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#product-collapseOne" aria-expanded="false" aria-controls="product-collapseOne">
                    <div class="text-end">
                        <i class="bi bi-shield-check me-3"></i>
                    </div>
                    <div class="text-start">
                        <p class="lh-base mb-0 producto-variables--description">Garant&iacute;a de 3 a&ntilde;os</p>
                    </div>
                </button>
                <div id="product-collapseOne" class="accordion-collapse collapse bg-white" aria-labelledby="product-headingOne" data-bs-parent="#accordionProductInfo">
                    <div class="accordion-body producto-variables--description px-0">
                        3 a&ntilde;os de garant&iacute;a en Espa&ntilde;a, con SAT oficial del fabricante.
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item bg-secundario">
            <div class="accordion-header lh-base" id="product-headingTwo">
                <button class="accordion-button collapsed px-0 py-2 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#product-collapseTwo" aria-expanded="false" aria-controls="product-collapseTwo">
                    <div class="text-end">
                        <i class="bi bi-arrow-repeat me-3"></i>
                    </div>
                    <div class="text-start">
                        <p class="lh-base mb-0 producto-variables--description">14 d&iacute;as para devolverlo</p>
                    </div>
                </button>
                <div id="product-collapseTwo" class="accordion-collapse collapse bg-white" aria-labelledby="product-headingTwo" data-bs-parent="#accordionProductInfo">
                    <div class="accordion-body producto-variables--description px-0">
                        Puedes cancelar tu pedido f&aacute;cilmente o hacer la devoluci&oacute;n durante los 14 d&iacute;as siguientes a la recepci&oacute;n. M&aacute;s informaci&oacute;n: <a rel="nofollow" href="/terminos-y-condiciones/#desistimiento">Clic aqu&iacute;</a>.
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item bg-secundario">
            <div class="accordion-header lh-base" id="product-headingThree">
                <button class="accordion-button collapsed px-0 py-2 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#product-collapseThree" aria-expanded="false" aria-controls="product-collapseThree">
                    <div class="text-end">
                        <i class="bi bi-nut me-3"></i>
                    </div>
                    <div class="text-start">
                        <p class="lh-base mb-0 producto-variables--description">Servicio de instalaci&oacute;n</p>
                    </div>
                </button>
                <div id="product-collapseThree" class="accordion-collapse collapse bg-white" aria-labelledby="product-headingThree" data-bs-parent="#accordionProductInfo">
                    <div class="accordion-body producto-variables--description px-0">
                        Cons&uacute;ltanos precio y disponibilidad del servicio en tu zona. <a rel="nofollow" href="/contacto">Contactar</a>.
                    </div>
                </div>
            </div>
        </div>
    ',
    'false' =>
    '
        <div class="accordion-item bg-secundario">
            <div class="accordion-header lh-base" id="product-headingOne">
                <button class="accordion-button collapsed px-0 py-2 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#product-collapseOne" aria-expanded="false" aria-controls="product-collapseOne">
                    <div class="text-end">
                        <i class="bi bi-shield-check me-3"></i>
                    </div>
                    <div class="text-start">
                        <p class="lh-base mb-0 producto-variables--description">Garant&iacute;a de 3 a&ntilde;os</p>
                    </div>
                </button>
                <div id="product-collapseOne" class="accordion-collapse collapse bg-white" aria-labelledby="product-headingOne" data-bs-parent="#accordionProductInfo">
                    <div class="accordion-body producto-variables--description px-0">
                        3 a&ntilde;os de garant&iacute;a en Espa&ntilde;a, con SAT oficial del fabricante.
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item bg-secundario">
            <div class="accordion-header lh-base" id="product-headingTwo">
                <button class="accordion-button collapsed px-0 py-2 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#product-collapseTwo" aria-expanded="false" aria-controls="product-collapseTwo">
                    <div class="text-end">
                        <i class="bi bi-arrow-repeat me-3"></i>
                    </div>
                    <div class="text-start">
                        <p class="lh-base mb-0 producto-variables--description">14 d&iacute;as para devolverlo</p>
                    </div>
                </button>
                <div id="product-collapseTwo" class="accordion-collapse collapse bg-white" aria-labelledby="product-headingTwo" data-bs-parent="#accordionProductInfo">
                    <div class="accordion-body producto-variables--description px-0">
                        Puedes cancelar tu pedido f&aacute;cilmente o hacer la devoluci&oacute;n durante los 14 d&iacute;as siguientes a la recepci&oacute;n. M&aacute;s informaci&oacute;n: <a rel="nofollow" href="/terminos-y-condiciones/#desistimiento">Clic aqu&iacute;</a>.
                    </div>
                </div>
            </div>
        </div>
    ',
  ];
}


function add_field_servicio_de_instalacion() {
    global $product;
    
	$config = get_servicio_instalacion_cnf();
	
	if (get_field('servicio_de_instalacion') == 1) {
	    echo '<div class="accordion accordion-flush rounded-3" id="accordionProductInfo">' . $config['true'] . '</div>';
	} else {
	    echo '<div class="accordion accordion-flush rounded-3" id="accordionProductInfo">' . $config['false'] . '</div>';
	}
}
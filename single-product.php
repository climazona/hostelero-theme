<?php get_header('');
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

?>
<!-- Start: categorias destacadas -->
<section id="single-prod-lb">
    <?php
        /**
        * woocommerce_before_main_content hook.
        *
        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
        * @hooked woocommerce_breadcrumb - 20
        */
        do_action( 'woocommerce_before_main_content' );
    ?>
    
    <?php
        global $product;
        do_action( 'woocommerce_before_single_product' );
    ?>
    
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="row bg-white">
                    <?php while ( have_posts() ) : ?>
                        <?php the_post(); ?>
                            <div style="position:relative; " class="col-12 col-md-6 col-lg-5 px-0 btlr">
                                <?php
                                do_action( 'woocommerce_before_single_product_summary' );
                                ?>
                            </div>
                            <div class="col-12 col-md-6 col-lg-7 mt-2 mt-lg-0 border-col-prod">
                            	<div id="puntada" class="bg-white" style="width:100%; height:100%">
                                <?php
                                /**
                                * Hook: woocommerce_single_product_summary.
                                *
                                * @hooked woocommerce_template_single_title - 5
                                7 - row y col 6
                                * @hooked woocommerce_template_single_rating - 10
                                * @hooked woocommerce_template_single_price - 10
                                * @hooked woocommerce_template_single_excerpt - 20
                                * @hooked woocommerce_template_single_add_to_cart - 30
                                37 - abro col 6, pongo el envio y cierro la col y la row
                                * @hooked woocommerce_template_single_meta - 40
                                * @hooked woocommerce_template_single_sharing - 50
                                * @hooked WC_Structured_Data::generate_product_data() - 60
                                */
                                do_action( 'woocommerce_single_product_summary' );
                                ?>
    					    </div>
                        </div>
                    <?php
                    //comments_template( '/comments.php' );
					endwhile; ?>
                </div>
            </div>
            <div class="col-12 col-lg-9 col-xxl-8">
		        <?php
                    global $post;
                    $heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );
                ?>
                <h2 class="h6 mb-3">Descripción de <?php the_title(); ?> </h2>
                <hr>
                <?php
                $current_tags = get_the_terms( get_the_ID(), 'product_tag' );
                $single_ean13=get_field('_gtin');
                if ( $current_tags && ! is_wp_error( $current_tags ) ) {
                    foreach ($current_tags as $tag) {
                        $tag_title = $tag->name; // tag name
                        echo '<span class="badge rounded-pill bg-light text-dark mb-3 me-2"><i class="bi bi-box-seam me-1"></i> Marca: '.$tag_title.'</span>';
                    }
                }
                if ($single_ean13 !== '0') {
                    echo '<span class="badge rounded-pill bg-light text-dark mb-3 me-2"><i class="bi bi-upc-scan me-1"></i> Código EAN: '.$single_ean13.'</span>';
                }
                ?>
                <ul class="nav nav-pills border flex-column flex-md-row mb-3 mx-0 rounded-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <?php if ( $heading ) : ?>
                            <a class="nav-link active" id="nav-<?php echo esc_html( $heading ); ?>-tab" data-bs-toggle="tab" href="#pills-<?php echo esc_html( $heading ); ?>" role="tab" aria-controls="pills-<?php echo esc_html( $heading ); ?>" aria-selected="true"><?php echo esc_html( $heading ); ?></a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="bi bi-file-pdf"></i> Ficha técnica</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-garantia" role="tab" aria-controls="pills-garantia" aria-selected="false">Garantía y devolución</a>
                    </li>
                    <?php 
                        if(get_field('gases_fluorados') == 1){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-gases" role="tab" aria-controls="pills-gases" aria-selected="false">Gases fluorados</a>
                            </li>
                            ';
                        }
                    ?>
                    
                </ul>
                <div class="tab-content mb-4" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-<?php echo esc_html( $heading ); ?>" role="tabpanel" aria-labelledby="pills-home-tab">
                        <?php the_content(); ?>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <p>Ver / descargar ficha técnica <?php the_title(); ?></p>
                        <?php
                        $ppp1=get_field('f_tecnica');
                        if(empty($ppp1['url'])){
                            echo '
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <div>
                                    <i class="bi bi-exclamation-square"></i> Este producto no dispone de ficha técnica.
                                </div>
                            </div>
                            ';
                        } else {
                            $ppp1_url = get_headers($ppp1['url'], true);
                            $ppp1_peso = $ppp1_url['Content-Length'];
                            echo '
                                <small><a class="text-decoration-none" href="'; ?><?php echo $ppp1['url']; ?><?php echo '" target="_blank"> Abrir PDF en una pestaña nueva <i class="bi bi-box-arrow-up-right"></i></a></small><br>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="card border-primary rounded-3 py-5 my-3 text-center">
                                            <div class="card-body"><a class="text-decoration-none h5 stretched-link" href="'; ?><?php echo $ppp1['url']; ?><?php echo '" download="'; ?><?php the_title(); ?><?php echo '"><i class="bi bi-file-earmark-arrow-down"></i> Descargar PDF</a></div>
                                            <div class="font-monospace">[ '.size_format($ppp1_peso, $decimals = 2).' ]</div>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="pills-garantia" role="tabpanel" aria-labelledby="pills-garantia-tab">
                        <div class="card rounded-3 mb-3">
                            <div class="card-body">
                                <p class="h5 mb-3">¡Satisfacción garantizada!</p>
                                <hr>
                                <p><i class="bi bi-patch-check text-success"></i>&nbsp; ¡Compra con seguridad!, 14 días para devolver el producto.</p>
                                <p><i class="bi bi-box-seam text-success"></i>&nbsp; Producto nuevo, comprado directamente al fabricante.</p>
                                <p><i class="bi bi-shield-check text-success"></i>&nbsp; Garantía con el SAT Oficial del fabricante.</p>
                                <p class="mb-0"><i class="bi bi-clipboard-check text-success"></i>&nbsp; ¡Despreocúpate! Nos ocupamos nosotros de tramitar la garantía.</p>
                            </div>
                        </div>
                        <div class="my-4">
                            <h4>Preguntas frecuentes sobre la Política de Desistimiento</h4>
                            <p>Puedes consultar la información básica aquí: <a href="https://tiendadelaire.com/terminos-y-condiciones/" rel="nofollow" class="woocommerce-terms-and-conditions-link" target="_blank">términos y condiciones</a>.</p>
                        </div>
                        <div class="accordion" id="garantiaPreguntasFrecuentes">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingUno">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUno" aria-expanded="true" aria-controls="collapseUno">
                                    ¿Puedo devolver mi pedido?
                                    </button>
                                </h4>
                                <div id="collapseUno" class="accordion-collapse collapse show" aria-labelledby="headingUno" data-bs-parent="#garantiaPreguntasFrecuentes">
                                    <div class="accordion-body">
                                        <p><strong>Todos los pedidos se pueden devolver</strong> si no estás satisfecho con lo que has comprado o ya no lo necesitas. El plazo es de 14 días naturales a partir de la fecha de la recepción del producto.</p>
                                        <p>Debes enviarlo en exactamente las mismas condiciones en las que se te entregó sin haber sido manipulado ni instalado. Además, los eventuales gastos de devolución corren a cargo del cliente. Aconsejamos contratar el envío con seguro por el valor del producto enviado.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingDos">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDos" aria-expanded="false" aria-controls="collapseDos">
                                    ¿Cómo puedo realizar la devolución?
                                    </button>
                                </h4>
                                <div id="collapseDos" class="accordion-collapse collapse" aria-labelledby="headingDos" data-bs-parent="#garantiaPreguntasFrecuentes">
                                    <div class="accordion-body">
                                        <p>Es tan sencillo como llamarnos por teléfono con uno de nuestros agentes y te daremos instrucciones personalizadas sobre cómo proceder a la devolución. También a través de nuestro correo electrónico se pueden realizar el proceso. ¡Preferimos que hables directamente con nosotros!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingTres">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTres" aria-expanded="false" aria-controls="collapseTres">
                                    ¿Cuándo puedo realizar una devolución?
                                    </button>
                                </h4>
                                <div id="collapseTres" class="accordion-collapse collapse" aria-labelledby="headingTres" data-bs-parent="#garantiaPreguntasFrecuentes">
                                    <div class="accordion-body">
                                        <p>Durante los 14 días naturales desde que recibas el pedido, lo puedes devolver si has cambiado de opinión. Una vez que pasan estos días no es posible realizar la devolución.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingCuatro">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuatro" aria-expanded="false" aria-controls="collapseCuatro">
                                    ¡He recibido el producto golpeado! ¿Qué hago?
                                    </button>
                                </h4>
                                <div id="collapseCuatro" class="accordion-collapse collapse" aria-labelledby="headingCuatro" data-bs-parent="#garantiaPreguntasFrecuentes">
                                    <div class="accordion-body">
                                        <p>Lo primero, calma. Estamos para ayudarte. Si has recibido un pedido y observas daños originados por el transporte, nos lo debes comunicar en un plazo no superior a las 48-72 horas desde la fecha de la recepción del pedido. Llámanos o envíanos un email indicándonos todos los detalles de tu pedido junto con fotografías. En un plazo no superior a 24 horas si el daño es debido al transporte, repondremos la mercancía.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingCinco">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCinco" aria-expanded="false" aria-controls="collapseCinco">
                                    ¿Cuánto supone el coste de devolución?
                                    </button>
                                </h4>
                                <div id="collapseCinco" class="accordion-collapse collapse" aria-labelledby="headingCinco" data-bs-parent="#garantiaPreguntasFrecuentes">
                                    <div class="accordion-body">
                                        <p>Depende del motivo. Si el motivo es porque te hemos enviado un producto erróneo, los costes son a coste nuestro.</p>
                                        <p>Si el motivo es porque quieres devolverlo, no lo quieres, te reembolsaremos el pedido descontando los gastos de envío y recogida. El producto debe llegar en las mismas condiciones que se te entregó. Si no se entrega así aplicaremos deducciones debido a depreciación.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingSeis">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeis" aria-expanded="false" aria-controls="collapseSeis">
                                    ¿Cómo y cuándo se realiza el reembolso?
                                    </button>
                                </h4>
                                <div id="collapseSeis" class="accordion-collapse collapse" aria-labelledby="headingSeis" data-bs-parent="#garantiaPreguntasFrecuentes">
                                    <div class="accordion-body">
                                        <p>Tan pronto llegue el producto a nuestro almacén y lo verifiquemos, tramitaremos el reembolso en la misma forma de pago en la que realizaste la compra.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingSiete">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSiete" aria-expanded="false" aria-controls="collapseSiete">
                                    Sobre devolución de productos
                                    </button>
                                </h4>
                                <div id="collapseSiete" class="accordion-collapse collapse" aria-labelledby="headingSiete" data-bs-parent="#garantiaPreguntasFrecuentes">
                                    <div class="accordion-body">
                                        En los siguientes casos no podremos admitir la devolución de tu pedido:
                                        <ul class="lh-lg">
                                            <li>Cuando han pasado más de 14 días desde la recepción del pedido.</li>
                                            <li>Si el producto que quieres devolver no se encuentra en perfectas condiciones.</li>
                                            <li>Si el artículo ha sido instalado o manipulado.</li>
                                            <li>Si habiendo recibido el producto con aparentes daños de transporte, no nos lo has comunicado antes de transcurridas 48-72 horas de la recepción del mismo.</li>
                                            <li>Si se trata de un producto que te hemos traído expresamente para ti y que no solemos vender.</li>
                                            <li>Si se trata de un recambio o repuesto (que entraría en la categoría de arriba).</li>
                                            <li>Si estás tratando de engañarnos. Por ejemplo: Se te ha caído al suelo y estás intentando hacerlo pasar como daño en el transporte. En este caso, el perito del seguro iría a verificarlo.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                		if(get_field('gases_fluorados') == 1){
                			add_field_gases_fluorados();
                		}
            		?>
                </div> 
            </div> 
            <div class="col-12 col-lg-3 col-xxl-4">
                <?php
                /* crossells */
                $crosssell_ids = get_post_meta( get_the_ID(), '_upsell_ids' ); 
                if (isset($crosssell_ids[0])){
                  $crosssell_ids = $crosssell_ids[0];
                }
                else {
                  $crosssell_ids = [];
                }
                ?>
                <div class="col-12">
                    <h4 class="h6 mb-3">Productos relacionados</h4>
                    <hr>
                </div>
                <div class="row g-2">
                    <?php
                    if(is_array($crosssell_ids) && !count($crosssell_ids) > 0) {
                        echo '
                        <div class="col-12">
                            <div class="alert alert-light mb-0" role="alert">
                                No se encontraron productos relacionados.
                            </div>
                        </div>
                        ';
                    } else {
                        $args = array( 'post_type' => 'product', 'posts_per_page' => 6, 'post__in' => $crosssell_ids );
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-12 col-xxl-6">
                            <div class="mb-3 p-1 border rounded-3 efecto-shadow position-relative">
                                <?php
                                if (has_post_thumbnail( $loop->post->ID )) {
                                    echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog', array('class' => 'img-fluid'));
                                } else {
                                    echo '<img class="img-fluid" src="'.woocommerce_placeholder_img_src().'" width="300px" height="300px" />';
                                }
                                mostrar_etiquetas_catalogo();
                                ?>
                                <div class="px-2 my-2">
                                    <a class="stretched-link" href='<?php the_permalink(); ?>'>
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                        endwhile;
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>
            
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
            
        <?php endwhile; // end of the loop. ?>
        
        <?php
    		/**
    		 * woocommerce_after_main_content hook.
    		 *
    		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    		 */
    		do_action( 'woocommerce_after_main_content' );
    	?>
    	
    </div>
</section>
<div class="clearfix"></div>
<?php get_footer(); ?>
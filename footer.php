        <section class="bottom-main-banner mt-3 py-3 bg-theme-primary-light">
            <div class="container">
                <div class="row my-3">
                    <div class="col-6 col-xl-2 d-flex my-2 my-xl-0 justify-content-start justify-content-sm-center">
                        <i class="text-theme-primary bi bi-truck me-3 me-sm-4"></i>
                        <p class="mb-0">Env&iacute;o Gratis<br>a partir de 300&euro;</p>
                    </div>
                    <div class="col-6 col-xl-2 d-flex my-2 my-xl-0 justify-content-start justify-content-sm-center">
                        <i class="text-theme-primary bi bi-telephone me-3 me-sm-4"></i>
                        <p class="mb-0">Ll&aacute;manos al<br><a class="text-decoration-none" href="tel:+34910600508">910 600 508</a></p>
                    </div>
                    <div class="col-6 col-xl-2 d-flex my-2 my-xl-0 justify-content-start justify-content-sm-center">
                        <i class="text-theme-primary bi bi-emoji-laughing me-3 me-sm-4"></i>
                        <p class="mb-0">Satisfacci&oacute;n<br>Garantizada</p>
                    </div>
                    <div class="col-6 col-xl-2 d-flex my-2 my-xl-0 justify-content-start justify-content-sm-center">
                        <?php if (get_bloginfo( 'name' ) != "Tienda del Hostelero"){ ?>
                            <i class="text-theme-primary bi bi-shield-check me-3 me-sm-4"></i>
                            <p class="mb-0">Pago Seguro<br>
                            Fracciona tu pago
                            </p>
                        <?php } else { ?>
                            <i class="text-theme-primary bi bi-shield-check me-3 me-sm-4"></i>
                            <p class="mb-0">Garantía oficial<br>
                            Producto nuevo
                            </p>
                        <?php } ?>
                    </div>
                    <div class="col-6 col-xl-2 d-flex my-3 my-xl-0 justify-content-start justify-content-sm-center">
                        <i class="text-theme-primary bi bi-boxes me-2 me-sm-4"></i>
                        <p class="mb-0">Gran Stock<br>Envío en 2 días</p>
                    </div>
                    <div class="col-6 col-xl-2 d-flex my-3 my-xl-0 justify-content-start justify-content-sm-center">
                        <i class="text-theme-primary bi bi-box-seam me-2 me-sm-4"></i>
                        <p class="mb-0">Devoluci&oacute;n<br>Durante 14 D&iacute;as</p>
                    </div>
                </div>
            </div>
        </section>
        
        <footer class="footer-web">
            <div class="bg-theme-secondary py-4" >
                <div class="container pb-2">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-7">
                            <div class="fw-semibold mx-1 mb-4">
                                Ayuda y servicios
                            </div>
                            <div class="footer-main-links row row-cols-2 row-cols-md-3">
                                <div class="col mb-2">
                                    <i class="bi bi-envelope-paper me-2 fs-5"></i>
                                    <a href="/contacto" target="_blank">
                                        Contactar
                                    </a>
                                </div>
                                <div class="col mb-2">
                                    <i class="bi bi-person me-2 fs-5"></i>
                                    <a href="/mi-cuenta" target="_blank">
                                        Mi cuenta
                                    </a>
                                </div>
                                <div class="col mb-3">
                                    <i class="bi bi-bag-check me-2 fs-5"></i>
                                    <a href="/mi-cuenta/pedidos" target="_blank">
                                        Mis pedidos
                                    </a>
                                </div>
                                <div class="col mb-3">
                                    <i class="bi bi-arrow-left-right me-2 fs-5"></i>
                                    <a href="/terminos-y-condiciones/#desistimiento" target="_blank">
                                        Devoluciones
                                    </a>
                                </div>
                                <div class="col mb-3">
                                    <i class="bi bi-clipboard-check me-2 fs-5"></i>
                                    <a href="/terminos-y-condiciones/#garantia" target="_blank">
                                        Garantía
                                    </a>
                                </div>
                                <div class="col mb-3">
                                    <i class="bi bi-truck me-2 fs-5"></i>
                                    <a href="/terminos-y-condiciones/#envio" target="_blank">
                                        Opciones de envío
                                    </a>
                                </div>
                                <div class="col mb-3">
                                    <i class="bi bi-wallet2 me-2 fs-5"></i>
                                    <a href="/terminos-y-condiciones/#pago" target="_blank">
                                        Métodos de pago 
                                    </a>
                                </div>
                                <div class="col mb-3">
                                    <i class="bi bi-newspaper me-2 fs-5"></i>
                                    <a href="/noticias" target="_blank">
                                        Noticias
                                    </a>
                                </div>
                                <div class="col mb-3">
                                    <i class="bi bi-chat-left-text me-2 fs-5"></i>
                                    <a href="/blog" target="_blank">
                                        Blog
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                            <div class="footer-reviews px-4 py-1 bg-white rounded-4">
                                <?php echo do_shortcode( '[cusrev_trustbadge type="SLP" border="no" color="#FFFFFF"]' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-secondary">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-start">
                            <ul class="footer-our-websites list-group list-group-horizontal-xxl">
                                <li class="list-group-item fw-semibold">Nuestros sitios</li>
                                <?php
                                $current_site_url = str_replace('https://', '', get_site_url());
                                $current_site_name = get_bloginfo('name');
                                
                                $sites = [
                                    ['Tienda del Aire', 'https://tiendadelaire.com'],
                                    ['Tienda del Hostelero', 'https://tiendadelhostelero.com'],
                                    ['Tienda del Electro', 'https://tiendadelelectro.com'],
                                ];
                                
                                foreach ($sites as [$site_name, $site_url]) {
                                    if ($current_site_name == $site_name) {
                                        continue;
                                    }
                                    
                                    echo "
                                        <li class='list-group-item'>
                                            <a href='$site_url' target='_blank'>$site_name</a>
                                        </li>
                                    ";
                                }
                                
                                $reviews_url = sprintf('https://www.cusrev.com/es/reviews/%s', $current_site_url);
                                echo "
                                    <li class='list-group-item'>
                                        <a href='$reviews_url' target='_blank'>Opiniones $current_site_name</a>
                                    </li>
                                ";
                                ?>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-6 text-start">
                            <ul class="footer-about-us mt-3 mt-sm-0 list-group list-group-horizontal-xxl">
                                <li class="list-group-item fw-semibold">Sobre nosotros</li>
                                <li class='list-group-item'>
                                    <a href="https://climazona.com" target="_blank">Grupo Climazona</a>
                                </li>
                                <li class='list-group-item'>
                                    <a href="https://climazona.com/sostenibilidad" target="_blank">Sostenibilidad</a>
                                </li>
                                <li class='list-group-item'>
                                    <a href="https://climazona.com/publicidad" target="_blank">Publicidad</a>
                                </li>
                                <li class='list-group-item'>
                                    <a href="https://climazona.com/trabaja-con-nosotros" target="_blank">Trabaja con nosotros</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr class="border-secondary">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-xl-6">
                            <div class="footer-legal text-center text-xl-start mt-3 mt-sm-0">
                                <a rel="nofollow" style="white-space:nowrap;" href="/aviso-legal/">Aviso legal</a>
                                <a el="nofollow" style="white-space:nowrap;" href="/terminos-y-condiciones/">T&eacute;rminos y condiciones</a>
                                <a rel="nofollow" style="white-space:nowrap;" href="/politica-de-privacidad/">Pol&iacute;tica de privacidad</a>
                                <a rel="nofollow" style="white-space:nowrap;" href="/politica-de-cookies/">Pol&iacute;tica de cookies</a>
                                <a rel="nofollow" style="white-space:nowrap;" href="/politica-de-cookies/">Pol&iacute;tica de cookies</a>
                                <button type="button" style="white-space:nowrap;" class="btn btn-link" data-cc="show-preferencesModal">Configurar preferencias de cookies</button>
                            </div>
                        </div>
                    	<div class="col-12 col-xl-6 mt-2 mt-xl-0">
                            <div class="footer-social text-center text-xl-end mt-3 mt-sm-0">
                                <a target="_blank" href="<?php echo get_theme_mod('rrss_instagram'); ?>">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a target="_blank" href="<?php echo get_theme_mod('rrss_facebook'); ?>">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a target="_blank" href="<?php echo get_theme_mod('rrss_twitter'); ?>">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a target="_blank" href="<?php echo get_theme_mod('rrss_youtube'); ?>">
                                    <i class="bi bi-youtube"></i>
                                </a>
                                <a target="_blank" href="<?php echo get_theme_mod('rrss_linkedin'); ?>">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            </div>
                    	</div>
                    </div>
                    <div class="row align-items-center mt-3 mb-5 mb-lg-0 py-3">
                        <div class="col-12 col-lg-6">
                            <div class="footer-copyright small text-center text-lg-start">
                                Grupo Climazona <?php echo" &copy; " . date('Y')  ;?> - Todos los derechos reservados. | Dise&ntilde;o web realizado por <a class="text-decorative-none link-dark" href="https://seoseu.com"target="_blank">Seoseu</a>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="footer-payments text-center text-xl-end mt-3 mt-lg-0">
                                <?php if (isset($current_site_name) && $current_site_name != "Tienda del Hostelero") { ?>
                                    <img width="50" height="25" src="/wp-content/themes/climazona/assets/img/payments/visa.webp" alt="Método de pago Visa" class="img-fluid border rounded-1"/>
                                    <img width="50" height="25" src="/wp-content/themes/climazona/assets/img/payments/mastercard.webp" alt="Método de pago Mastercard" class="img-fluid border rounded-1"/>
                                    <img width="50" height="25" src="/wp-content/themes/climazona/assets/img/payments/sequra.webp" alt="Método de pago Sequra" class="img-fluid border rounded-1"/>
                                <?php } ?>
                                <img width="50" height="25" src="/wp-content/themes/climazona/assets/img/payments/sepa.webp" alt="Método de pago SEPA" class="img-fluid border rounded-1"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <?php wp_footer(); ?>
        
        <script>
            window.addEventListener('scroll', () => {
                
                const stickyElement = document.getElementById('menu-prod');
                
                stickyElement.classList.toggle("shadow", window.pageYOffset >= stickyElement.offsetTop);
            });
        </script>
        <script>
        $(document).ready(function(){
            //user sided variable for PHP value
            var total = parseInt($(".totalCost").text()); 
            $(".add_to_cart_button").click(function(){
                total++;   		//add to cart
                $(".totalCost").text(total); //update
            });
        	$(".remove").click(function(){
                total--;   		//add to cart
                $(".totalCost").text(total); //update
            });
        });
        </script>
        <script>
            $(document).ready(function(){
                $(window).resize(function() {
               if ($(this).width() <= 992) {
                 $('#btn-dis').prop('disabled', false);
               }
               else if ($(this).width() > 992){
            	 $('#btn-dis').prop('disabled', true); 
               }
            });
            	if ($(window).width() <= 992) {
                 $('#btn-dis').prop('disabled', false);
               }
            });
        </script>
        <script>
            $(document).ready(function(){
                $("input[title='Cantidad']").TouchSpin({
                    verticalbuttons: true,
                    verticalupclass: 'glyphicon glyphicon-plus',
                    verticaldownclass: 'glyphicon glyphicon-minus',
                    min: 1,
                    max: 1000,
                });
            });
        </script>
    </body>
</html>
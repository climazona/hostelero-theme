<?php
$currurl = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<div class="archive-container-filtro d-lg-none" style="z-index: 95;">
    <button class="btn btn-lg btn-light boton-filtro"  type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFiltros" aria-controls="offcanvasFiltros">
        Filtros
    </button>
</div>

<section id="archipro" class="bg-secundario">
    <?php
        /**
         * Hook: woocommerce_before_main_content.
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         * @hooked WC_Structured_Data::generate_website_data() - 30
         */
        do_action( 'woocommerce_before_main_content' );
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9 bg-white order-2">
                <header class="woocommerce-products-header">
                    <div class="d-flex align-items-center">
                        <?php
                        global $wp_query;
                	    $cat = $wp_query->get_queried_object();
                	    if (isset($cat->term_id)) {
                	        $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                	    
                    	    $image = wp_get_attachment_url( $thumbnail_id );
                            if ( $image ) {
                                echo '<img class="img-fluid pe-3 rounded-3 d-none d-md-block" src="' . $image . '" width="170" height="170" alt="' . $cat->name . '" />';
                            }
                	    }
                        ?>
                    
                        <div class="">
                            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                            <h1 class="woocommerce-products-header__title page-title h2 my-3"><?php woocommerce_page_title(); ?></h1>
                            <?php endif; ?>
                            
                            <?php if ( false == strpos($currurl,'/page/') ) {
                                /**
                                 * Hook: woocommerce_archive_description.
                                 *
                                 * @hooked woocommerce_taxonomy_archive_description - 10
                                 * @hooked woocommerce_product_archive_description - 10
                                 */
                                do_action( 'woocommerce_archive_description' );
                                $term = get_queried_object();
                                $editor = get_field('editor', $term);
                            } ?>
                        </div>
                    </div>
                </header>
            
                <div class="col-12 d-flex align-items-center">
                <?php 
                    /**
                    * Hook: woocommerce_before_shop_loop.
                    *
                    * @hooked woocommerce_output_all_notices - 10
                    * @hooked woocommerce_result_count - 20
                    * @hooked woocommerce_catalog_ordering - 30
                    */
                    do_action( 'woocommerce_before_shop_loop' );
                ?>
                </div>
                
                <div id="contenido-tienda" class="col-12 bg-white my-3 px-0">
                    
                    <?php
                    if ( woocommerce_product_loop() ) {
                        
                        woocommerce_product_loop_start();
                        
                        echo '<div class="row">';
                            if ( wc_get_loop_prop( 'total' ) ) {
                                while ( have_posts() ) {
                                    the_post();
                                    /**
                                    * Hook: woocommerce_shop_loop.
                                    */
                                    do_action( 'woocommerce_shop_loop' );
                                    wc_get_template_part( 'content', 'product' );
                                }
                            }
                        echo '</div>';
                        
                        woocommerce_product_loop_end(); ?>
                        
                        <div class="container px-lg-0">
                            <?php
                            /**
                            * Hook: woocommerce_after_shop_loop.
                            *
                            * @hooked woocommerce_pagination - 10
                            */
                            do_action( 'woocommerce_after_shop_loop' );
                            
                            if ( !empty($editor) ) { ?>
                                <div id="vermas">
                                    <?php echo $editor; ?>
                                </div>
                            <?php }
                            ?>
                        </div>
                        <?php
                    } else {
                        /**
                        * Hook: woocommerce_no_products_found.
                        *
                        * @hooked wc_no_products_found - 10
                        */
                        do_action( 'woocommerce_no_products_found' );
                    } ?>
                </div>
            </div>
            <div id="widgets-lb" class="col-12 col-lg-3 pt-3 order-1">
                
                <?php /*test*/ ?>
                
                <div class="offcanvas offcanvas-start d-block overflow-auto d-lg-none" tabindex="-1" id="offcanvasFiltros" aria-labelledby="offcanvasFiltrosLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasFiltrosLabel">Filtros</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <?php dynamic_sidebar( 'id-nueva-zona' ); ?>
                        <hr>
                        <div class="text-center">
                            <div class="fs-6 fw-bolder text-center">¿No encuentras lo que buscas?</div>
                            Pídenos presupuesto y te contestamos de inmediato.
                            <div class="d-grid my-3">
                                <a class="btn btn-primary" href="/contacto/">Pedir presupuesto</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-block">
                    <?php dynamic_sidebar( 'id-nueva-zona' ); ?>
                </div>
                
                <?php /*test*/ ?>
                
                <?php /* dynamic_sidebar( 'id-nueva-zona' ); */ ?>
            </div>
        </div>
    </div>
    <?php
    /**
    * Hook: woocommerce_after_main_content.
    *
    * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    */
    do_action( 'woocommerce_after_main_content' );
    ?>
</section>

<?php
get_footer();
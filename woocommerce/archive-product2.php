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
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$term = get_queried_object();
$editor = get_field('editor', $term);
$filter_active = get_field('filtro', $term);

if ($filter_active) { ?>
    <div class="archive-container-filtro d-lg-none" style="z-index: 95;">
        <button class="btn btn-lg btn-light boton-filtro"  type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFiltros" aria-controls="offcanvasFiltros">
            Filtros
        </button>
    </div>
<?php } ?>

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
    <div id="cat-padre" class="container">
        <div class="row">
            <div class="col-12 col-lg-9 bg-white order-2">
                <header class="woocommerce-products-header">
                    <div class="d-flex align-items-center mb-3">
                        <?php
                        global $wp_query;
                	    $cat = $wp_query->get_queried_object();
                	    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                	    $image = wp_get_attachment_url( $thumbnail_id );
                        if ( $image ) {
                            echo '<img class="img-fluid pe-3 rounded-3 d-none d-md-block" src="' . $image . '" width="170" height="170" alt="' . $cat->name . '" />';
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
                            } ?>
                        </div>
                    </div>
                </header>
                <hr>
                <?php /* DISPLAY CHILD CATEGORIES START */ ?>
                <section class="float-none">
                    <div>
                        <div class="row">
                            <?php
                            if ( is_product_category() ) {
                                $term_id  = get_queried_object_id();
                                $taxonomy = 'product_cat';
                                // Get subcategories of the current category
                                $terms    = get_terms([
                                    'taxonomy'    => $taxonomy,
                                    'hide_empty'  => true,
                                    'parent'      => get_queried_object_id()
                                ]);
                                // Loop through product subcategories WP_Term Objects
                                foreach ( $terms as $term ) {
                                    $term_link      =   get_term_link( $term, $taxonomy );
                                    $cat_thumb_id   =   get_term_meta( $term->term_id, 'thumbnail_id', true );
                                    $cat_thumb_url  =   wp_get_attachment_thumb_url( $cat_thumb_id );
                            ?>
                                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-inline-flex justify-content-center nav-cat">
                                        <a class="text-decoration-none text-center" href="<?php echo get_category_link($term); ?>">
                                            <figure class="position-relative">
                                                <?php /* woocommerce_subcategory_thumbnail( $term ); */ ?>
                                                <img class="img-fluid border rounded-3 efecto-shadow" src="<?php echo $cat_thumb_url; ?>" alt="<?php echo $term->name; ?>" />
                                                <p class="text-secondary my-2 lh-base"><?php echo $term->name; ?></p>
                                                <span class="position-absolute top-0 end-0 badge rounded-3 bg-primario mt-1 me-1">
                                                    <?php echo $term->count; ?>
                                                    <span class="visually-hidden">Productos</span>
                                                </span>
                                            </figure>
                                        </a>
                                        <?php if (isset($url[0])) { echo $url1[0]; } ?>
                                    </div>
                            <?php    
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>
                <?php /* DISPLAY CHILD CATEGORIES END */ ?>
                <div class="col-12 col-md-4 offset-md-8">
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
        	<!-- <div id="widgets-lb" class="col-12 col-lg-3 pt-3 order-1"> -->
        	<div id="widgets-lb" class="col-12 col-lg-3 pt-3 order-1">
                <?php
                if ( is_product_category() ) {
                    echo '
                    <div class="d-none d-lg-block">
                        <div class="h5 my-3 text-center">Categorías</div>
                        <div class="list-group mb-3">';
                        // Loop through product subcategories WP_Term Objects
                        foreach ( $terms as $term ) { ?>
                            <button type="button" class="list-group-item list-group-item-action py-3">
                                <a class="text-decoration-none text-start stretched-link" href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a>
                            </button>
                        <?php    
                        }
                        echo '
                        </div>
                    </div>
                    ';
                }
                ?>
                
                <?php if ($filter_active) { ?>

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
                                    
                <?php } ?>
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
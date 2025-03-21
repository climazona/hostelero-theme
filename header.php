<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta content="initial-scale=1, minimum-scale=1, width=device-width" name="viewport">
        <meta name="theme-color" content="#ffffff">
        <?php 
            $header=get_theme_mod('campo_header'); 
            echo $header;
        ?>
        <?php wp_head(); ?>
    </head>

    <body style="font-family: 'Poppins', sans-serif;">
    <?php 
        $body=get_theme_mod('campo_body'); 
        echo $body;
	?>
	<div>	
        <nav class="navbar navbar-light bg-secundario navbar-expand-lg navigation-clean-search">
            <div class="container d-flex justify-content-center justify-content-sm-between">
                <?php 
                $custom_logo_id =   get_theme_mod( 'custom_logo' );
                $logo           =   wp_get_attachment_image_src( $custom_logo_id , 'full' );
                if ( has_custom_logo() ) {
                    echo '<a class="p-2" href="'.home_url('/').'" aria-label="'.get_bloginfo( 'name' ).'" >';
                    echo '<img width="auto" height="35" style="max-width:100%;height:35px" class="img-fluid" src="' . esc_url( $logo['0'] ) . '" aria-label="'. get_bloginfo( 'name' )  .'" alt="' . get_bloginfo( 'description' ) . '">';
                } else {
                    echo '<a href="'.home_url('/').'" aria-label="'.get_bloginfo( 'name' ).'" >';
                    echo '<img class="img-fluid" src="' .get_theme_file_uri() . '/assets/img/logo-250x100.jpg" aria-label="'. get_bloginfo( 'name' )  .'" alt="' . get_bloginfo( 'description' ) . '">';
                } ?>
                </a>
                <div class="d-none aviso-header">
                    <small class="m-0 p-2 d-block lh-0 text-primario text-center fw-bold"></small>
                </div>
                <div class="d-flex">
                    <div class="p-2">
                        <a href="tel:+34910600508" class="btn btn-outline-theme-primary icono-llamar rounded-3"><i class="bi bi-telephone"></i><span class="d-none d-sm-inline"> 910 600 508</span></a>
                    </div>
                    <div class="p-2">
                        <a rel="nofollow" href="https://wa.me/+34910600508/" class="btn btn-outline-success icono-whatsapp rounded-3"><i class="bi bi-whatsapp"></i></a>
                    </div>
                    <?php
                    $blogsArray = getArrayFromOtherShops();
                    foreach ($blogsArray as $blog) {
                        echo '
                        <div class="p-2">
                            <a href="https://' . $blog . '.com">
                                <img src="/wp-content/themes/climazona/assets/img/logos/Isotipo-png-color-' . $blog . '.png" alt="Logotipo" class="border rounded-3 img-fluid" width="40" height="40">
                            </a>
                        </div>
                        ';
                    };
                    ?>
                </div>
                <!--Menu desktop -->
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav ms-auto">
                        <?php wp_nav_menu_no_ul(); ?>
                    </ul>
                </div>
            </div>
        </nav>	
    </div>

    <?php get_template_part('template-parts/menu-slide-nav') ?>

    <?php get_template_part('template-parts/menu-bottom-bar') ?>
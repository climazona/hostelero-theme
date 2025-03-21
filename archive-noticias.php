<?php get_header(); ?>
<div class="py-5 bg-secundario">
    <div class="container">
        <h1 class="d-block">Noticias</h1>
        <p>Ofertas y promociones de nuestros proveedores.</p>
    </div>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            global $post;
            $args = array( 'post_type'=>'noticias','posts_per_page' => 3, 'order'=> 'DEC', 'orderby' => '' );
            $postslist = get_posts( $args );
            foreach ( $postslist as $post ) :
            setup_postdata( $post ); ?>
            <div class="col">
                <div class="card rounded-3 h-100 efecto-shadow position-relative">
                    <a class="text-decoration-none" aria-label="<?php the_title(); ?>" href="<?php the_permalink($post->ID) ?>">
                        <img src="<?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail_url();
                        } ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <div class="card-body position-relative">
                            <h3 class="h5 card-title"><?php the_title(); ?></h3>
                            <svg width="2em" height="2em" viewBox="0 0 16 16" class="position-absolute top-0 start-50 translate-middle bi bi-caret-up-fill" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/></svg>
                        </div>
                    </a>
                    <span class="position-absolute top-0 end-0 badge rounded-3 bg-success mt-1 me-1">
                        ¡Nuevo!
                        <span class="visually-hidden">Nuevo</span>
                    </span>
                </div>
            </div>
            <?php
            endforeach; 
            wp_reset_postdata();
            ?>
        </div>
    </div>			
</div>
<div class="container my-3">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card mb-3">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banners/banner-promo-2.gif" class="card-img-top" alt="Panasonic Aquarea">
                <div class="card-footer py-0 px-2 d-flex justify-content-between align-items-center">
                    <i class="bi bi-badge-ad me-2"></i>
                    <small class="text-dark">
                        Más información en <a rel="nofollow" href="https://tiendadelaire.com/noticias/aquarea-compact/" class="stretched-link">Aerotermia Panasonic</a>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <p class="card-title h5 text-primary"><i class="bi bi-megaphone"></i> ¡Anúnciate aquí!</p>
                    <small>Consulta las ventajas.</small>
                </div>
                <div class="card-footer py-0 px-2 d-flex justify-content-between align-items-center">
                    <i class="bi bi-badge-ad me-2"></i>
                    <small class="text-dark">
                        <a rel="nofollow" href="#" class="stretched-link">Más información</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php
        global $post;
        $args = array( 'post_type'=>'noticias', 'posts_per_page' => 8, 'offset'=> 3, 'order'=> 'DEC', 'orderby' => '' );
        $postslist = get_posts( $args );
        foreach ( $postslist as $post ) :
        setup_postdata( $post ); ?>
        <div class="col">
            <div class="card rounded-3 h-100 efecto-shadow">
                <a class="text-decoration-none" aria-label="<?php the_title(); ?>" href="<?php the_permalink($post->ID) ?>">
                    <img src="<?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail_url();
                    } ?>" class="card-img-top" alt="<?php the_title(); ?>">
                    <div class="card-body position-relative">
                        <h4 class="h6 card-title mb-0"><?php the_title(); ?></h4>
                        <svg width="2em" height="2em" viewBox="0 0 16 16" class="position-absolute top-0 start-50 translate-middle bi bi-caret-up-fill" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/></svg>
                    </div>
                </a>
            </div>
        </div>
        <?php
        endforeach; 
        wp_reset_postdata();
        ?>
    </div>
</div>
<div class="d-grid gap-2 col-6 mx-auto mt-3">
    <a class="btn btn-outline-primary" href="/publicaciones-noticias/" role="button">Ver todas las publicaciones</a>
</div>
<div class="container my-3">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card rounded-3 mb-3 d-block tarjeta-info-blog">
                <div class="card-body">
                    <div class="card-title h4">Somos tu portal de noticias de climatización</div>
                    <!--<h2 class="h4">Somos tu portal de noticias de climatización</h2>-->
                    <p><strong>Somos la revista digital de noticias ideal</strong> para clientes profesionales y comerciales, para todos los temas relacionados con la climatización.</p>
                    <p>En cooperación con varios profesionales del sector, publicamos excelentes <strong>noticias y artículos de interés para el profesional.</strong></p>
                    <p>Además, puedes descubrir muchas marcas, modelos y tendencias del sector, <strong>¡siempre a la última!</strong>.</p>
                    <p>Te invitamos a navegar a través de nuestras publicaciones.</p>
                    <!--<p class="h5">¡Esperamos que disfrutes leyéndonos!</p>-->
                    <div class="card-subtitle"><strong>¡Esperamos que disfrutes leyéndonos!</strong></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card bg-primario text-light rounded-3 mb-3 d-block tarjeta-newsletter">
                <div class="card-body">
                    <span class="h3 mb-2 d-block"><i class="bi bi-envelope-open"></i> ¡No te pierdas nada!</span>
                    <small class="mb-2 d-block">Suscríbete a nuestro Newsletter y entérate de nuestras nuevas publicaciones. ¡Es gratis!</small>
                    <div class="card-text">
                        <?php echo do_shortcode('[contact-form-7 id="7226" title="Newsletter"]'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
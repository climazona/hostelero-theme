<?php get_header(); ?>
<div class="container mt-5">
    <div class="row">
        <?php if(is_woocommerce() || is_product()){ ?>
        <div class="col-12 text-center">
            <?php if (have_posts()) {
                while (have_posts()) {
                    the_post(); ?>
                    <?php the_content(); ?>
                <?php }
            } ?>
        <?php } else { ?>
        <div class="col-12 col-md-8 pe-xxl-5">
            <h1 class="h2"><?php the_title(); ?></h1>
            <div class="mt-3">
                <small>Tiempo de lectura de </small> <span class="badge bg-success"><?php echo reading_time(); ?></span>
            </div>    
            <div>
                <a href="<?php the_permalink($post->ID) ?>">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail('lebianch', [ 'class' => 'img-fluid border rounded-3 my-3' , 'alt' => esc_html ( get_the_title() ) ]);
                    }
                    ?>
                </a>
            </div>
            <div class="mb-3">
                <small>Actualizado el </small> <span class="badge bg-success mx-1"><?php echo get_the_modified_date('j \d\e F \d\e Y'); ?></span><small> por <?php echo get_the_author_meta('nickname'); ?></small> <img src="https://tiendadelaire.com/wp-content/uploads/2021/11/usuario-34.webp" alt="mdo" width="45" height="45" class="rounded-circle border">
            </div>            
            <div id="single-content" class="single_contenido">
                <?php if (have_posts()) {
                    while (have_posts()) {
                        the_post(); ?>
                        <?php the_content(); ?>
                    <?php }
                } ?> 
            </div>
        </div> 
        <div class="col-12 col-md-4 mt-5 my-md-0">
            <div class="row my-3">
                <div class="col-12">
                    <div class="card mb-3">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banners/banner-promo-1.webp" class="card-img-top" alt="Beretta">
                        <div class="card-footer py-0 px-2 d-flex justify-content-between align-items-center">
                            <i class="bi bi-badge-ad me-2"></i>
                            <small class="text-dark">
                                Más información en <a rel="nofollow" href="http://www.berettaheating.com/spain/" class="stretched-link">BerettaHeating.com</a>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-12">
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
            <p>Artículos recientes <i class="bi bi-chevron-down"></i></p>
            <hr>
            <div class="row row-cols-1 g-3">
                <?php								
                $post_typer     =   get_field('tipo_de_most_a_mostar');
                $id             =   get_the_ID();									
                global $post;
                $args           =   array( 'posts_per_page' => 3, 'order'=> 'DEC', 'post_type' => 'noticias', 'orderby' => '' , 'post__not_in' => array($id) );
                $postslist      =   get_posts( $args );
                foreach ( $postslist as $post ) :
                setup_postdata( $post ); ?>
                <div class="col">
                    <div class="card h-100 efecto-shadow">
                        <a class="text-decoration-none" aria-label="<?php the_title(); ?>" href="<?php the_permalink($post->ID) ?>">
                            <img src="<?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail_url();
                            } ?>" class="card-img-top" alt="<?php the_title(); ?>">
                            <div class="card-body position-relative">
                                <div class="h6 card-title mb-0"><?php the_title(); ?></div>
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
    </div>
    <?php } ?>
</div>
<?php get_footer(); ?>
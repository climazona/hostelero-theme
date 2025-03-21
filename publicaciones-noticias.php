<?php /* Template Name: Listado de noticias */ ?>
<?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
      'post_type'       => 'noticias',
      'posts_per_page'  => 8,
      'paged'           => $paged,
      'orderby'         => 'DESC',
      'orderby'         => ''
    );
    $wp_query = new WP_Query($args);
    
    global $publicacionesCount;
    $publicacionesCount = $wp_query->max_num_pages;
    
    get_header();
?>
<div class="py-5 bg-secundario">
    <div class="container">
        <h1 class="d-block">Noticias</h1>
        <p>Ofertas y promociones de nuestros proveedores.</p>
    </div>
    <div class="container">
        <div class="row mt-3">
            <span class="mb-3">Página <?php echo $paged; ?> de <?php echo $wp_query->max_num_pages; ?></span>
            <?php
            if ($wp_query->have_posts()) {
              while ($wp_query->have_posts()) : $wp_query->the_post();
              ?>

                <div class="col-12 col-sm-6 col-md-6 col-xl-3 my-2 text-center">
                  <div class="border rounded-3 bg-white efecto-shadow">
                      <div class="carrousel-posts justify-content-center">
                          <a aria-label="<?php the_title(); ?>" href="<?php the_permalink($post->ID) ?>">
                              <?php
                                  $r=get_the_post_thumbnail();
                                  if (empty($r)){
                                      if (empty(get_field('imagen_destacada'))){
                                          echo ' <img src="'.get_theme_file_uri().'/assets/img/1080x1080-post.jpg"'.'	class="border img-fluid wp-post-image" alt="Logo-Web-Site" >' ;
                                      } else {
                                          echo get_field('imagen_destacada');
                                      }
                                  }
                                  if ( has_post_thumbnail() ) {
                                      the_post_thumbnail('seothemeimg');
                                  }
                              ?>
                          </a>
                      </div>
                      <div class="p-3">
                          <a class="text-decoration-none" aria-label="<?php the_title(); ?>" href="<?php the_permalink($post->ID) ?>"><?php the_title(); ?></a>
                          <p class="mb-0 figure-caption lh-base">
                              <?php echo excerpt(8);?>
                          </p>
                      </div>
                  </div>
                </div>

              <?php
              endwhile;

                $total = $wp_query->max_num_pages;
                if ($total > 1){
                    $current = get_query_var('paged');
                    $base =  get_pagenum_link(1) . '%_%';
                    $format = 'page/%#%/';
                    
                    echo '<div class="container"> <nav class="woocommerce-pagination">';
                    
                    $paginacionArgs = array(
                        'base'      => $base,
                        'format'    => $format,
                        'total'     => $total,
                        'current'   => $paged,
                        'prev_text' => is_rtl() ? 'Siguiente' : 'Anterior',
                        'next_text' => is_rtl() ? 'Anterior' : 'Siguiente',
                        'type'      => 'list',
                        'end_size'  => 3,
                        'mid_size'  => 3,
                        'add_args'  => false,
                    );
                    
                    echo '<div class="container"> <nav class="woocommerce-pagination">' . paginate_links($paginacionArgs) . '</nav> </div>';
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<div class="container my-3">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card border-secondary mb-3">
                <a class="text-decoration-none" rel="nofollow" href="https://www.aircon.panasonic.eu/ES_es/ranges/aquarea/">
                    <img src="/wp-content/themes/climazona/assets/img/Publicidad/publicidad-panasonic-1.gif" class="card-img-top" alt="Publicidad">
                    <div class="card-footer py-0"><small class="text-muted"><i class="bi bi-badge-ad"></i> Publicidad</small></div>
                </a>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card border-secondary mb-3">
                <div class="card-body text-center">
                    <p class="card-title h5 text-primary"><i class="bi bi-megaphone"></i> ¡Anúnciate aquí!</p>
                    <small>Consulta las ventajas. <a rel="nofollow" href="#" class="stretched-link">Más información</a></small>
                </div>
                <div class="card-footer py-0"><small class="text-muted"><i class="bi bi-badge-ad"></i> Publicidad</small></div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
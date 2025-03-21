<div class="container homepage-new-products">
    <div class="row my-4 my-md-5">
        <div class="text-center mb-3">
            <p class="h5"><i class="bi bi-patch-exclamation text-theme-primary"></i> Novedades</p>
            <span class="small">Productos agregados recientemente <i class="bi bi-chevron-down"></i></span>
        </div>
        <?php
            /** Ordenar por ventas
            *   $args = array(
            *       'posts_per_page'    =>  6,
            *       'post_type'         =>  'product',
            *       'meta_key'          =>  'total_sales',
            *       'orderby'           =>  'meta_value_num'
            *   );
            */
            $args = array(
                'posts_per_page'    =>  6,
                'post_type'         =>  'product',
                'orderby'           =>  'DESC',
                'tax_query'         =>  array(
                    array(
                        'taxonomy'      =>  'product_visibility',
                        'field'         =>  'name',
                        'terms'         =>  'exclude-from-catalog',
                        'operator'      =>  'NOT IN'
                    ),
                ),
            );
            $loop = new WP_Query( $args );
            while (
                $loop->have_posts()
            ) :
            $loop->the_post();
            global $product;
        ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-2 my-2 text-center">
            <div class="border rounded-4 bg-white p-2">
                <a class="text-decoration-none" href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                    <?php
                    woocommerce_show_product_sale_flash( $post, $product );
                    if (has_post_thumbnail( $loop->post->ID )) {
                        echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog', array('class' => 'img-fluid'));
                    } else {
                        echo '<img class="img-fluid" src="'.woocommerce_placeholder_img_src().'" width="300px" height="300px" />';
                    } ?>
                    <p class="h5 text-theme-secondary"><?php the_title(); ?></p>
                    <span class="price"><?php echo $product->get_price_html(); ?></span>         
                </a>
            </div>
        </div>
        <?php
            endwhile;
            wp_reset_query();
        ?>
    </div>
</div>
<div class="container homepage-section-posts">
    <div class="row">
        <div class="col-12">
            <div class="bg-theme-secondary rounded-4 px-3 pb-3 pt-4 my-3">
                <div class="text-center">
                    <h3 class="h5"><?php echo get_bloginfo( 'name' ); ?> <span class="text-theme-primary">/ Noticias</span></h3>
                    <p class="mb-0">Noticias y promociones.</p>
                    <span class="small">Publicaciones recientes <i class="bi bi-chevron-down"></i></span>
                </div>
                <div class="row mt-3">
                    <?php
                        if (empty(get_field('9-C-post'))){
                            $a=5;
                        }
                        else
                            $a                      =   get_field('9-C-post');
                            $post_typer             =   get_field('tipo_de_contenido_1');
                            global $post;
                            $args                   =   array(
                                'post_type'         =>  $post_typer,
                                'posts_per_page'    =>  $a,
                                'order'             =>  'DESC', 'orderby'
                            );
                            $postslist      =   get_posts( $args );
                        foreach ( $postslist as $post ) :
                            setup_postdata( $post ); 
                    ?>
                    <div class="col-12 col-md-6 my-2 text-center">
                        <div class="rounded-3 bg-white">
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
                                <p class="mb-0 small lh-base">
                                    <?php echo excerpt(10);?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                        endforeach;
                        wp_reset_postdata();
                    ?>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <a class="btn btn-outline-theme-primary" href="/noticias/" role="button">Más publicaciones</a>
                </div>
            </div>
            <div class="bg-theme-secondary rounded-4 px-3 pb-3 pt-4 my-3">
                <div class="text-center">
                    <h3 class="h5"><?php echo get_bloginfo( 'name' ); ?> <span class="text-theme-primary">/ Blog</span></h3>
                    <p class="mb-0">Artículos y publicaciones de interés.</p>
                    <span class="small">Artículos recientes <i class="bi bi-chevron-down"></i></span>
                    
                </div>
                <div class="row mt-3">
                    <?php
                        if (empty(get_field('19-C-post'))) {
                            $a=4;
                        }
                        else
                            $a                      =   get_field('19-C-post');
                            $post_typer             =   get_field('tipo_de_contenido_12');
                            global $post;
                            $args = array(
                                'post_type'         =>  $post_typer,
                                'posts_per_page'    =>  $a,
                                'order'             => 'DESC', 'orderby'
                            );
                            $postslist              =   get_posts( $args );
                        foreach ( $postslist as $post ) : setup_postdata( $post ); 
                    ?>
                    <div class="col-12 col-sm-6 col-md-6 col-xl-3 my-2 text-center">
                        <div class="rounded-3 bg-white">
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
                                <p class="mb-0 small lh-base">
                                    <?php echo excerpt(10);?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                        endforeach;
                        wp_reset_postdata();
                    ?>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <a class="btn btn-outline-theme-primary" href="/blog/" role="button">Más publicaciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
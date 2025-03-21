<?php get_header(); ?>

<section id="single-contenido" class="my-3">
    <div class="container">
        <?php if (is_woocommerce() || is_cart() || is_shop()) : ?>
            <div id="loop-prod-lb" class="col-12">
                <h1 class="mt-5 mb-4 text-capitalize"><?php the_title(); ?></h1>
                <?php woocommerce_breadcrumb(); ?>
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
        <?php else : ?>
                <h1 class="mt-5 mb-4 text-capitalize"><?php the_title(); ?></h1>
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
<section class="homepage-hero">
    <?php $image = get_field('imagen1'); ?>
    <div class="container-fluid position-relative px-0">
        <div class="overflow-hidden position-absolute w-100 bottom-0">
            <img draggable="false" class="imagen-home position-relative" width="440" height="465" alt="<?php echo wp_title(); ?>" src="/wp-content/themes/climazona/assets/img/climazona-home.webp">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3 d-none d-lg-block pt-3 my-auto">
                    <?php /* echo get_field('2-p'); */ ?>
                    
                    <div class="row">
                    </div>
                    
                </div>
                <div class="col-12 col-md-7 col-lg-5 ps-lg-5 py-4">
                    <div class="px-2 mb-5 mt-3 mt-md-5">
                        <h1 class="fw-bold">
                            <?php echo get_field('1-h1'); ?>
                        </h1>
                        <span class="h4 mt-4 fw-bold">
                            <span class="text-primario">+1.000</span> productos en stock
                        </span>
                        <p>Entregas inmediatas de 24 a 48 horas</p>
                    </div>
                    <?php  echo get_field('3-p'); ?>
                </div>
                <div class="col-12 col-md-5 col-lg-4 position-relative pt-2 pt-md-4">
                    <div class="overflow-hidden" style="height:600px;">
                        <div class="valoraciones">
                            <?php
                                echo do_shortcode('[cusrev_reviews_grid count="3" sort_by="date" color_ex_brdr="transparent" count_shop_reviews="0"]');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
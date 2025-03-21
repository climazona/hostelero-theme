<div class="container-fluid homepage-categories bg-theme-secondary py-3 py-md-5">
    <section class="float-none">
        <div class="container">
            <div class="row row-cols-auto justify-content-center">
                <?php
                while( have_rows('seccion_3') ): the_row(); 
                    $cat1           =   get_sub_field('cat_1');
                foreach($cat1 as $cats) {
                    $thumbnail_id1  =   get_term_meta( $cats, 'thumbnail_id', true );
                    $url1           =   wp_get_attachment_image_src( $thumbnail_id1, 'square' );
                    $term           =   get_term_by( 'id', $cats, 'product_cat' );
                ?>
                    <div class="col">
                        <a class="text-decoration-none text-center" href="<?php echo get_category_link($cats); ?>">
                            <figure class="position-relative">
                                <img
                                    width="200"
                                    height="200"
                                    class="img-fluid rounded-3"
                                    src="<?php echo $url1[0]; ?>"
                                    alt="<?php echo $term->name; ?>"
                                />
                                <span class="position-absolute top-0 end-0 badge rounded-3 bg-theme-primary mt-1 me-1">
                                    <?php echo $term->count; ?>
                                    <span class="visually-hidden">Productos</span>
                                </span>
                                <h3 class="h6 text-secondary mt-3">
                                    <?php echo $term->name; ?>
                                </h2>
                            </figure>
                        </a>
                    </div>
                <?php
                }
                endwhile;
                ?>
            </div>
        </div>
    </section>
</div>
<div class="container-fluid homepage-read-more bg-theme-primary-light py-2">
    <div class="text-center my-3">
        <h2 class="h6 m-0">
            <?php echo get_field('4-h3'); ?>
        </h2>
        <button
            class="btn btn-sm btn-outline-theme-primary mt-3"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#openContent"
            aria-expanded="false"
            aria-controls="openContent"
        >
            Leer m&#225;s
        </button>
    </div>
    <div class="collapse container float-none" id="openContent">
        <div class="rounded-4 bg-white mb-3">
            <div class="p-4">
                <?php echo get_field('5-p'); ?>
            </div>
        </div>
    </div>
</div>
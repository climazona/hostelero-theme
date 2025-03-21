<style>
    .stick-prod{
        position:sticky;
        top:0;
        z-index:99
    }
    @media (min-width:783px){
        .stick-prod{
            position:sticky;
            <?php if ( is_user_logged_in() ) {
                echo 'top:32px';
            }else{
                echo 'top:0';
            }?>;
            z-index:99
        }
    }
</style>
<section id="menu-prod" class="stick-prod py-1 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <!-- START Menú Productos -->
                    
            <div class="col-12 col-md-3 col-lg-3 order-2 order-lg-1 col-filtro px-0 py-2 py-lg-0">
                <button class="btn btn-light border bg-white ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <i class="bi bi-list"></i> Productos
                </button>
            </div>
            
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h4 class="offcanvas-title h5" id="offcanvasExampleLabel">Productos</h4>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <?php
                    $menu_name = 'header-menu';
                    $locations = get_nav_menu_locations();
                    $menu_id   = $locations[ $menu_name ] ;
                    $menufo=wp_get_nav_menu_object($menu_id); while( have_rows('menu_prod', $menufo) ): the_row(); 
                    $cat=array();
                    for($i=1; $i<=10; $i++){
                        $catop=get_sub_field('link_categoria_'.$i);
                        array_push($cat, $catop);
                    }
                    $icoico=array();
                    for($g=1; $g<=10; $g++){
                        $icp=get_sub_field('icono_categoria_'.$g);
                        array_push($icoico, $icp);
                    } ?>
                    <style>
                        <?php
                        $y=1;
                        $l=1;
                        foreach($icoico as $ecole){
                            echo '.icoico'.$y++.'{
                                background:url('.$ecole.')no-repeat center center;
                                width:25px;
                                height:25px;
                                padding-left:25px;
                                margin-right:15px
                            }		
                            ';	
                        }?>
                        .icoico{
                        padding-left:20px
                        }
                    </style>
                    
                    <div class="accordion accordion-flush mb-4" id="accordionFlush">
                        
                        <?php
                        $i  =   0;
                        $j  =   0;
                        $n  =   1;
                        $t  =   1;
                        $p  =   1;
                        $tt =   array();
                        foreach($cat as $catego){
                            $cate=get_term_by('term_id', $catego, 'product_cat');
                            array_push($tt, $cate);
                            ?>
                            <?php
                            if (!empty($catego)) {
                                ?>
                                <div class="accordion-item">
                                    <div class="accordion-header align-items-center d-flex align-items-center" id="flush-headingOne">
                                            <i class="icoico<?php echo $p++; ?>"></i>
                                            <a title="<?php echo $tt[$j++]->name; ?>" href="<?php echo get_term_link( $catego ,'product_cat'); ?>" class="w-100 btn btn-primary menu-filt item-filt">
                                                <?php echo $tt[$i++]->name; ?>
                                            </a>
                                        <div class="p-2 flex-shrink-1">
                                            <button class="accordion-button collapsed w-auto p-3 border rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $catego; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $catego; ?>">
                                            </button>
                                        </div>
                                    </div>
                                    <?php $catop2=get_sub_field('link_subcategoria_'.$n++); 
                                    if(!empty($catop2)){ ?>
                                        <div id="flush-collapse<?php echo $catego; ?>" class="accordion-collapse collapse mb-2" aria-labelledby="flush-heading<?php echo $catego; ?>" data-bs-parent="#accordionFlush">
                                            <?php
                                            foreach($catop2 as $op){
                                                $ss=get_term_by('term_id', $op, 'product_cat');
                                                ?>
                                                <div class="accordion-body py-0">
                                                    <a class="dropdown-item rounded-3 p-3" href="<?php echo get_term_link( $op ,'product_cat') ?>"><?php echo $ss->name; ?> </a>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                        }
                        
                        $pu=get_sub_field('presupuesto_urgente');
                        if ( !empty($pu) ) { ?>
                            <div class="d-grid mt-4">
                                <a class="btn btn-outline-theme-primary" href="<?php echo $pu['url']; ?>"><?php echo $pu['title']; ?></a>
                            </div>
                        <?php }
                        
                        endwhile;
                        ?>
                    </div>
                    
                </div>
            </div>
            
            <!-- END Menú Productos -->
            <div class="col-12 col-lg-6 d-none d-lg-block order-1 order-lg-2 py-2">
                <div>
                    <?php echo get_product_search_form(); ?>
                </div>
            </div>
            <div class="col-10 col-lg-3 d-none d-lg-block text-end order-3 col-filtro py-2">
                <div class="d-flex justify-content-end">
                    
                    <?php if ( is_user_logged_in() ) { ?>
                        <a href="/mi-cuenta/" rel="nofollow" class="btn btn-outline-theme-primary ms-auto me-1 position-relative">
                            <i class="bi bi-person me-1"></i> Mi cuenta
                        </a>
                    <?php } else { ?>
                        <a href="/mi-cuenta/" rel="nofollow" class="btn btn-outline-theme-primary ms-auto me-1 position-relative">
                            Iniciar sesión
                        </a>
                    <?php } ?>
                    
                    <?php global $woocommerce; ?>
                    <?php $woocommerce = $woocommerce->cart->get_cart_contents_count(); ?>
                    
                    <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-light border bg-white ms-auto me-1 position-relative">
                        <i class="bi bi-cart3 me-1"></i> Carrito 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo json_encode($woocommerce); ?>
                            <span class="visually-hidden">Carrito</span>
                        </span>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    @media (max-width:992px){
        .nav-lebianch-seo{
            text-align:left !important
        }
        #navcol-1 li, #navcol-1 li:focus, #navcol-1 li:active, #navcol-1 li:hover, #navcol-prod li, #navcol-prod li:focus, #navcol-prod li:active, #navcol-prod li:hover{
            background:#007bff;
            border-bottom:1px solid #fff;
            opacity:1 !important
        }
        #navcol-1 li, #navcol-1 li:focus, #navcol-1 li:active, #navcol-1 li:hover, #navcol-prod li, #navcol-prod li:focus, #navcol-prod li:active, #navcol-prod li:hover{
            opacity:1 !important
        }
        #ul-lb li, #ul-lb li:focus, #ul-lb li:active, #ul-lb li:hover{
            background:white !important;
            border-bottom:1px solid #fff;
            opacity:1 !important
        }
        #ul-lb{
            max-height:250px;
            padding-left:0;
            list-style:none;
            overflow:scroll
        }
        #collapseOne99 li, #collapseOne99 li:focus, #collapseOne99 li:active, #collapseOne99 li:hover, #collapseOne199 li, #collapseOne199 li:focus, #collapseOne199 li:active, #collapseOne199 li:hover{
            background:#eee;
            border-bottom:1px solid #fff;
            opacity:1 !important
        }
        .link-lb{
            border:none !important;
            color:#007bff !important
        }
        .link-lb.principal, .icono-cat-princ{
            color:#124d8c !important
        }
    }
    @media(max-width:782px){
        .menu-recopado{
            position: fixed;
            left: 0;
            bottom: <?php if ( is_user_logged_in() ){
                    echo '8.6%';  
                }else{
                    echo '0';
                } ?>;
            z-index: 90;
            width: 100%;
        }
    }
    @media(min-width:783px){
        .menu-recopado{
            position:fixed;
            left:0;
            top:
                <?php if ( is_user_logged_in() ){
                    echo '4%';
                }else{
                    echo '0';
                } ?>;
            z-index:10;
            width:100%;"
        }
    }
    .fila {
        z-index:95;
        width:100%;
        bottom:0;
        position:fixed;
        display:-ms-flexbox;
        display:flex;
        -ms-flex-wrap:wrap;
        flex-wrap:wrap
    }
    .cincocolumnas {
        box-sizing:border-box;
        position:relative;
        width:100%;
        -ms-flex:0 0 20%;
        flex:0 0 20%;
        max-width:20%
    }
    .pepe{
        font-size:calc(60% - -.25rem);
        max-width:100%;
        text-align:center;
        margin-bottom:0
    }
    .fila a {
        text-decoration:none
    }
    .btn-lb{
        display:inline-flex;
        flex-direction:column;
        max-width:100%;
        align-items:center;
        background:#f1f3f6;
        border:0px;
        color:#000;
        width:100%;
        padding:0.5rem
    }
    .dropup .dropdown-toggle::after{
        display:none
    }
    .btn-lb:hover, .btn-lb:focus, .btn-lb:active, .show > .btn-primary.dropdown-toggle{
        box-shadow:none;
        background-color:#007bff;
        color:white;
        border:none;
        outline:none
    }
    #navcol-2 .form-control{
        width:80%;
        margin-left:5px
    }
    #navcol-2 button{
        background: white;
        margin-left: 5px;
        order:2
    }
    #navcol-2{
        padding:.5rem
    }
</style>

<div class="fila d-flex d-lg-none">
    <div class="cincocolumnas text-center">
        <a class="btn-lb" role="button" href="<?php echo home_url('/'); ?>">
            <i class="bi bi-house fs-5"></i>
            Inicio
        </a>
    </div>
    <div class="cincocolumnas text-center">
        <button class="btn-lb" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottomSearch" aria-controls="offcanvasBottomSearch">
            <i class="bi bi-search fs-5"></i>
            Buscar
        </button>
    </div>
    <div class="cincocolumnas text-center">
        <?php
            global $woocommerce;
            $woocommerce = count( WC()->cart->get_cart() );
        ?>
        <a style="position:relative" class="btn-lb" role="button" href="<?php echo home_url('carrito/'); ?>">
            <i class="bi bi-cart fs-5 position-relative"></i>
            <span style="left: 50px;z-index: 1;" class="badge bg-danger position-absolute top-0">
                <?php echo json_encode($woocommerce); ?>
            </span>
            Carrito
        </a>
    </div>
    <div class="cincocolumnas text-center">
        <a class="btn-lb" role="button" href="<?php echo home_url('mi-cuenta/'); ?>">
            <i class="bi bi-person fs-5"></i>
            Cuenta
        </a>
    </div>
    <div class="cincocolumnas text-center">
        <button class="btn-lb" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottomMenu" aria-controls="offcanvasBottomMenu">
            <i class="bi bi-list fs-5"></i>
            Menú
        </button>
    </div>

    <div class="offcanvas offcanvas-bottom" style="height:40vh;" tabindex="-1" id="offcanvasBottomMenu" aria-labelledby="offcanvasBottomLabelMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabelMenu">Menú</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small text-center">
            <ul class="list-unstyled fs-6">
                <?php wp_nav_menu_no_ul(); ?>
            </ul>
        </div>
    </div>
    
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottomSearch" aria-labelledby="offcanvasBottomLabelSearch">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabelSearch">Buscar</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small text-center">
            <?php echo get_product_search_form(); ?>
        </div>
    </div>
</div>
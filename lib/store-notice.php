<?php
// Desactiva el banner nativo de WooCommerce
add_filter( 'woocommerce_demo_store', '__return_false' );

// Función para mostrar el aviso de la tienda
function display_store_notice() {
    if ( get_option( 'woocommerce_demo_store' ) === 'yes' ) { // Comprueba si el aviso de la tienda está activado
        $notice = get_option( 'woocommerce_demo_store_notice' ); // Obtiene el texto del aviso
        if ( ! empty( $notice ) ) {
            echo '<div class="alert alert-warning text-center w-100 my-3 mx-0 small" role="alert">' . $notice . '</div>'; // Muestra el aviso en un alert de Bootstrap
        }
    }
}

add_action( 'woocommerce_before_cart_table', 'display_store_notice' );
add_action( 'wp_footer', 'display_store_notice' );
?>
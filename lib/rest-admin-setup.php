<?php

if (!defined('ABSPATH')) exit;

add_filter( 'rest_authentication_errors', function( $result ) {
    // Si ya hay un error, devolverlo.
    if ( ! empty( $result ) ) {
        return $result;
    }

    // Permitir acceso público a los endpoints específicos de Contact Form 7.
    $allowed_endpoints = [
        '/wp-json/contact-form-7/v1/contact-forms',
    ];

    $request_uri = $_SERVER['REQUEST_URI'];
    foreach ( $allowed_endpoints as $endpoint ) {
        if ( strpos( $request_uri, $endpoint ) !== false ) {
            return $result; // Permitir acceso.
        }
    }

    // Bloquear a usuarios no autenticados.
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_not_logged_in', 'No estas logueado.', array( 'status' => 401 ) );
    }

    // Bloquear a usuarios que no son administradores.
    if ( ! current_user_can( 'administrator' ) ) {
        return new WP_Error( 'rest_not_admin', 'Solo administradores pueden acceder a la api.', array( 'status' => 401 ) );
    }

    return $result;
});
<?php

add_action( 'customize_register', 'theme_customize_register' );

function theme_customize_register( $wp_customize ) {
    
    // Ajustes generales de 'Admin > Apariencia > Personalizar'
    // Categoría
    $wp_customize->add_panel( 'climazona_theme', array(
    'title'         => __( 'Ajustes generales', 'textdomain' ),
    'description'   => __( 'Ajustes generales de integración a <a href="https://climazona.com">Grupo ClimaZona</a>', 'textdomain' ),
    'priority'      => 0,
    'capability'    => 'edit_theme_options',
    ));
    
        // Sub-Categoría 1
        $wp_customize->add_section( 'header_footer' , array(
        'title'         => __( 'Integración de Google Tag Manager', 'textdomain' ),
        'panel'         => 'climazona_theme',
        'priority'      => 1,
        'capability'    => 'edit_theme_options',
        
        ));
        
            // Sub-Categoría 1.1
            $wp_customize->add_setting('campo_header', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            ));
            $wp_customize->add_control('campo_header', array(
            'label'         => __( 'Snippet 1 Google Tag Manager', 'textdomain' ),
            'description'   => __( 'Integrar código después de la etiqueta Head de apertura.', 'textdomain' ),
            'section'       => 'header_footer',
            'priority'      => 1,
            'type'          => 'textarea',
            ));
            
            // Sub-Categoría 1.2
            $wp_customize->add_setting('campo_body', array(
            'type'          => 'theme_mod',
            'capability'    => 'edit_theme_options',
            ));
            $wp_customize->add_control('campo_body', array(
            'label'         => __( 'Snippet 2 Google Tag Manager', 'textdomain' ),
            'description'   => __( 'Integrar código después de la etiqueta Body de apertura.', 'textdomain' ),
            'section'       => 'header_footer',
            'priority'      => 2,
            'type'          => 'textarea',
            ));
        
        // Sub-Categoría 2
        $wp_customize->add_section( 'rrss_footer' , array(
        'title'         => __( 'Definir redes sociales', 'textdomain' ),
        'panel'         => 'climazona_theme',
        'priority'      => 2,
        'capability'    => 'edit_theme_options',
        
        ));
        
            // Sub-Categoría 2.1
                $wp_customize->add_setting('rrss_instagram', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                ));
                $wp_customize->add_control('rrss_instagram', array(
                'label'         => __( 'Instagram', 'textdomain' ),
                'section'       => 'rrss_footer',
                'priority'      => 1,
                'type'          => 'text',
            ));
            
            // Sub-Categoría 2.2
                $wp_customize->add_setting('rrss_facebook', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                ));
                $wp_customize->add_control('rrss_facebook', array(
                'label'         => __( 'Facebook', 'textdomain' ),
                'section'       => 'rrss_footer',
                'priority'      => 1,
                'type'          => 'text',
            ));
            
            // Sub-Categoría 2.3
                $wp_customize->add_setting('rrss_twitter', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                ));
                $wp_customize->add_control('rrss_twitter', array(
                'label'         => __( 'Twitter', 'textdomain' ),
                'section'       => 'rrss_footer',
                'priority'      => 1,
                'type'          => 'text',
            ));
            
            // Sub-Categoría 2.4
                $wp_customize->add_setting('rrss_youtube', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                ));
                $wp_customize->add_control('rrss_youtube', array(
                'label'         => __( 'YouTube', 'textdomain' ),
                'section'       => 'rrss_footer',
                'priority'      => 1,
                'type'          => 'text',
            ));
            
            // Sub-Categoría 2.5
                $wp_customize->add_setting('rrss_linkedin', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                ));
                $wp_customize->add_control('rrss_linkedin', array(
                'label'         => __( 'LinkedIn', 'textdomain' ),
                'section'       => 'rrss_footer',
                'priority'      => 1,
                'type'          => 'text',
            ));
            
}
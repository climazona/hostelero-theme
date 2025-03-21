<?php

// Tiempo estimado de lectura (Blog y Noticias)
function reading_time()
{
    global $post;
    if (!isset($post)) return '';

    $post_content       = $post->post_content;
    $num_words          = str_word_count(strip_tags($post_content));
    $estimated_reading_time = round($num_words / 300);
    $reading_time_unit  = $estimated_reading_time <= 1 ? " minuto" : " minutos";
    $total_reading_time = $estimated_reading_time . $reading_time_unit;

    return $total_reading_time;
}

// Devuelve array de las otras 2 tiendas de Cimazona
function getArrayFromOtherShops() {
    $current_blog_name = get_bloginfo( 'name' );
    
    $shops = [
    	'Tienda del Aire' => 'tiendadelaire',
	    'Tienda del Electro' => 'tiendadelelectro',
	    'Tienda del Hostelero' => 'tiendadelhostelero'
    ];
    
    $other_shops = array_filter($shops, function($name) use ($current_blog_name) {
        return $name !== $current_blog_name;
    }, ARRAY_FILTER_USE_KEY);
	
	return $other_shops;
}

function excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`[[^]]*]`', '', $excerpt);

    return $excerpt;
}

function content($limit)
{
    $content = explode(' ', get_the_content(), $limit);
    if (count($content) >= $limit) {
        array_pop($content);
        $content = implode(" ", $content) . '...';
    } else {
        $content = implode(" ", $content);
    }
    $content = preg_replace('/[.+]/', '', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]>', $content);

    return $content;
}

function fechaCastellano($fecha)
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $nombredia . ", " . $numeroDia . " de " . $nombreMes;
}

function wp_nav_menu_no_ul()
{
    $options = array(
        'echo' => false,
        'container' => false,
        'theme_location' => 'header-menu',
        'walker' => new wp_bootstrap_navwalker(),
        'fallback_cb' => 'fall_back_menu'
    );

    $menu = wp_nav_menu($options);

    echo preg_replace(array(
        '#^<ul[^>]*>#',
        '#</ul>$#'
    ), '', $menu);
}

function fall_back_menu()
{
    return;
}
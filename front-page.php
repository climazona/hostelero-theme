<?php

get_header();

if ( function_exists( 'get_field' ) ) {

    get_template_part('template-parts/homepage/section','hero');
    
    get_template_part('template-parts/homepage/section','categories');
    
    get_template_part('template-parts/homepage/section','content');

}

get_footer();
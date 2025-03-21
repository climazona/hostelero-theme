<?php

class SEOSEU_Theme {	
		
	function __construct() { }
	
	function init() {         
      define( 'SEOSEO_THEME_ASSETS_PATH', get_template_directory() . '/theme/'. SEOSEO_THEME . '/assets' );
      define( 'SEOSEO_THEME_ASSETS_URL', get_theme_file_uri() . '/theme/'. SEOSEO_THEME . '/assets' );    
	}

  function loadCss() {
    $cssPath = SEOSEO_THEME_ASSETS_PATH ."/css";    
    $css = glob("{$cssPath}/*.css");    
    
    foreach($css as $filePath){
      $id = basename($filePath, '.css');      
      wp_enqueue_style("seoseu-theme-" . trim($id), SEOSEO_THEME_ASSETS_URL . "/css/{$id}.css", [], '1.0.0');
    }
  }  

  function loadJs() {    
    $jsPath = SEOSEO_THEME_ASSETS_PATH ."/js";
    $js = glob("{$jsPath}/*.js");
    
    foreach($js as $filePath){      
      $id = basename($filePath,'.js');
      wp_enqueue_script("seoseu-theme-" . trim($id), SEOSEO_THEME_ASSETS_URL . "/js/{$id}.js", [], '1.0.0', true);
    }
  }
}
	
function seoseu_theme() {
	global $seoseuTheme;  
	if( !isset($seoseuTheme) ) {
		$seoseuTheme = new SEOSEU_Theme();
		$seoseuTheme->init();
	}

	return $seoseuTheme;
}

if( defined( 'SEOSEO_THEME' ) ) {
    seoseu_theme();
    
    add_action( 'wp_enqueue_scripts', 'load_theme_scripts', 11 );
    function load_theme_scripts() {
        global $seoseuTheme;
        if (isset($seoseuTheme)) {
            $seoseuTheme->loadCss();
            $seoseuTheme->loadJs();
        }    
    }
}
<?php
add_action('init', 'seothemelebianch_noticias_post_type', 0);
add_action('init', 'seothemelebianch_blog_taxonomia', 0);

// Añadir tipo noticias en los tipos post
function seothemelebianch_noticias_post_type()
{
	global $titulo_global;
	$titulo_global = 'noticias';

	$labels = [
		'name'                  => _x('Noticias', 'Post Type General Name', 'seothemelebianch'),
		'singular_name'         => _x('Noticia', 'Post Type Singular Name', 'seothemelebianch'),
		'menu_name'             => __('Noticias', 'seothemelebianch'),
		'name_admin_bar'        => __('Noticia', 'seothemelebianch'),
		'archives'              => __('Archivo', 'seothemelebianch'),
		'attributes'            => __('Atributos', 'seothemelebianch'),
		'parent_item_colon'     => __('Noticia Padre', 'seothemelebianch'),
		'all_items'             => __('Todas Las Noticias', 'seothemelebianch'),
		'add_new_item'          => __('Agregar Noticia', 'seothemelebianch'),
		'add_new'               => __('Agregar Noticia', 'seothemelebianch'),
		'new_item'              => __('Nueva Noticia', 'seothemelebianch'),
		'edit_item'             => __('Editar Noticia', 'seothemelebianch'),
		'update_item'           => __('Actualizar Noticia', 'seothemelebianch'),
		'view_item'             => __('Ver Noticia', 'seothemelebianch'),
		'view_items'            => __('Ver Noticias', 'seothemelebianch'),
		'search_items'          => __('Buscar Noticia', 'seothemelebianch'),
		'not_found'             => __('No Encontrado', 'seothemelebianch'),
		'not_found_in_trash'    => __('No Encontrado en Papelera', 'seothemelebianch'),
		'featured_image'        => __('Imagen Destacada', 'seothemelebianch'),
		'set_featured_image'    => __('Guardar Imagen destacada', 'seothemelebianch'),
		'remove_featured_image' => __('Eliminar Imagen destacada', 'seothemelebianch'),
		'use_featured_image'    => __('Utilizar como Imagen Destacada', 'seothemelebianch'),
		'insert_into_item'      => __('Insertar en Noticia', 'seothemelebianch'),
		'uploaded_to_this_item' => __('Agregado en Noticia', 'seothemelebianch'),
		'items_list'            => __('Lista de Noticias', 'seothemelebianch'),
		'items_list_navigation' => __('Navegación de Noticias', 'seothemelebianch'),
		'filter_items_list'     => __('Filtrar Noticias', 'seothemelebianch'),
	];

	$args = [
		'label'                 => __('Noticia', 'seothemelebianch'),
		'description'           => __('Noticias para el Sitio Web', 'seothemelebianch'),
		'rewrite' => array('slug' => $titulo_global, 'with_front' => false),
		'labels'                => $labels,
		'hierarchical'          => true, //true = posts, false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-megaphone',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'supports'              => array('title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'post-formats', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes',)
	];

	register_post_type('noticias', $args);
}

// Registrar una Taxonomia para el tipo de noticias
function seothemelebianch_blog_taxonomia()
{
	$labels = [
		'name'              => _x('Categoria Noticias', 'taxonomy general name', 'seothemelebianch'),
		'singular_name'     => _x('Categoria Noticias', 'taxonomy singular name', 'seothemelebianch'),
		'search_items'      => __('Buscar Categoria Noticias', 'seothemelebianch'),
		'all_items'         => __('Todas Categorias Noticias', 'seothemelebianch'),
		'parent_item'       => __('Categoria Noticias Padre', 'seothemelebianch'),
		'parent_item_colon' => __('Categoria Noticias:', 'seothemelebianch'),
		'edit_item'         => __('Editar Categoria Noticias', 'seothemelebianch'),
		'update_item'       => __('Actualizar Categoria Noticias', 'seothemelebianch'),
		'add_new_item'      => __('Agregar Categoria Noticias', 'seothemelebianch'),
		'new_item_name'     => __('Nueva Categoria Noticias ', 'seothemelebianch'),
		'menu_name'         => __('Categoria Noticias', 'seothemelebianch'),
	];

	$args = [
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('with_front' => false, 'slug' => 'noticias'),
		'show_in_rest'	    => true,
		'rest-base'	        => 'noticias'
	];

	register_taxonomy('noticias', array('noticias'), $args);
}

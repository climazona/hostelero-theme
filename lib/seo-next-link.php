<?php

add_filter('wpseo_head', 'custom_change_wpseo_next');

/*
 * Añadir links al header en las páginas de publicaciones noticias y blog
 */
function custom_change_wpseo_next($link)
{
	if (is_page_template(['publicaciones-noticias.php', 'publicaciones-blog.php'])) {
		add_filter('wpseo_canonical', '__return_false', 10);
		if (class_exists('WPSEO_Frontend')) {
			global $publicacionesCount;

			if (get_query_var('paged')) {
				$paged = get_query_var('paged');
			} elseif (get_query_var('page')) {
				$paged = get_query_var('page');
			} else {
				$paged = 1;
				if ($publicacionesCount > 1) {
					echo '<link rel="next" href="' . get_pagenum_link($paged + 1) . '" />' . PHP_EOL;
				}
			}

			if ($paged > 1) {
				echo '<link rel="prev" href="' . get_pagenum_link($paged - 1) . '" />' . PHP_EOL;
				if ($publicacionesCount > $paged) {
					echo '<link rel="next" href="' . get_pagenum_link($paged + 1) . '" />' . PHP_EOL;
				}
			}
		}
	}

	echo $link;
}

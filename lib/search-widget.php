<?php

add_filter('get_product_search_form', 'lb_custom_product_searchform');

/* Filter WooCommerce  Search Field */
function lb_custom_product_searchform($form)
{
  $form = '
  <form class="form-inline my-2 my-lg-0" role="search" method="get" id="searchform" action="' . esc_url(home_url('/')) . '">
        <label class="screen-reader-text" for="s">' . __('Search for:', 'woocommerce') . '</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                type="text"
                value="' . get_search_query() . '"
                name="s"
                id="s"
                placeholder="Producto, marca, modelo..."
                aria-label="Producto, marca, modelo..."
                aria-describedby="search-form"
            />
            <input type="hidden" name="post_type" value="product" />
            <button
                class="btn btn-outline-light border bg-white"
                type="submit"
                id="searchsubmit"
            >
                <i class="bi bi-search text-dark"></i>
            </button>
        </div>
  </form>
 
  ';

  return $form;
}
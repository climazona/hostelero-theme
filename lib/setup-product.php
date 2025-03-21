<?php

add_filter('woocommerce_duplicate_product_capability', 'wc_duplicate_product_cap', 10, 1);

/* Añadir etiquetas al archive y a productos relacionados  */
add_action('woocommerce_before_shop_loop_item_title', 'mostrar_etiquetas_catalogo', 40);

/* Cambiar texto filtro productos exclude backorder */
add_filter('woof_ext_custom_title_by_backorder', 'woof_ext_custom_title_by_backorder');

function wc_duplicate_product_cap($cap)
{
    $cap = 'edit_products';
    return $cap;
}

function mostrar_etiquetas_catalogo()
{
    global $product;
    $atributos      = $product->get_attributes();
    $disponibilidad = $product->get_stock_quantity();
    // Stock
    if ($disponibilidad == 1) {
        echo "<div><span class='badge bg-success position-absolute top-0 start-0 m-2'> ¡1 en stock! </span></div>";
    }
    if ($disponibilidad > 1) {
        echo "<div><span class='badge bg-success position-absolute top-0 start-0 m-2'><i class='bi bi-check-lg'></i> En stock </span></div>";
    }

    // Atributos
    if (!empty($atributos)) {
        echo '<ul class="list-group list-group-flush px-2 my-3">';
        foreach ($atributos as $attr_name => $attr) {
            foreach ($attr->get_terms() as $term) {
                $atributo   = $term->taxonomy;
                $atributo_energy = array('pa_a-g', 'pa_aa-f', 'pa_aaa-g', 'pa_aaaa-d'); // Añadir aquí los atributos que corresponden al etiquetado
                $termino    = $term->name;
                $attribute_label_name = wc_attribute_label($attr_name);

                echo '
                <li class="align-items-center d-flex list-group-item px-0 lh-base">
                ';
                if (wc_attribute_label($attr_name)) {
                    if (in_array($atributo, $atributo_energy)) {
                        echo '
                            <span class="me-auto producto-variables--description"> Eficiencia energética </span>
                            <span class="ms-1 badge bg-success">' . $termino . '</span>
                        ';
                    } else {
                        echo '
                            <span class="me-auto producto-variables--description text-start">' . $attribute_label_name . '</span>
                            <span class="ms-1 producto-variables--description text-end">' . $termino . '</span>
                        ';
                    }
                }
                $product = wc_get_product(get_the_ID());
                echo '</li>';
            }
        }
        echo '</ul>';
    }
}

function woof_ext_custom_title_by_backorder($title)
{
    return 'Entrega inmediata <span class="badge bg-success">En stock</span>';
}

function mostrar_etiqueta_producto()
{
    global $product;
    $product_id = $product->get_id();
    
    // Verificar si el SKU tiene un formato válido
    $sku = $product->get_sku();
    if (strlen($sku) !== 6 || !ctype_digit($sku)) {
        return;
    }

    $attribute_taxonomies = array('pa_a-g', 'pa_aa-f', 'pa_aaa-g', 'pa_aaaa-d'); // Añadir aquí los atributos que corresponden al etiquetado

    foreach ($attribute_taxonomies as $attribute) {
        $term_names = wp_get_post_terms($product_id, $attribute, ['fields' => 'names']);
        $term_all_values = wc_get_product_terms($product_id, $attribute, ['fields' =>  'all']);

        if (isset($term_names->errors)) break;

        $term = implode(', ', $term_names);

        if (!empty($term_names)) {
            $sku = $product->get_sku();
            $sku_part1 = substr($sku, -3);
            $sku_part2 = substr($sku, 0, -3);
            $energy_label_path = 'https://climazona.com/assets/energy-labels/full-labels/energy-label-' . $sku_part1 . '-' . $sku_part2 . '.webp';
            $class_icon_path = 'https://climazona.com/assets/energy-labels/class-icons/' . $attribute . '/' . $term . '.webp';
            
            $site_url = get_site_url();
            $domain = parse_url($site_url, PHP_URL_HOST);
            $background_image_filename = "energy-label-background-banner-" . $domain . ".webp";
            $background_image_url = "https://climazona.com/assets/energy-labels/" . $background_image_filename;

            echo '
            <div class="card mb-3"style="background-image: url(' . $background_image_url . '); background-position: left top; background-repeat: no-repeat; background-size: auto 100%;">
                <div class="card-body align-self-end">
                    <div class="d-flex">
                        <img src="' . $class_icon_path . '" class="etiqueta-energetica img-fluid" alt="' . $term . '" height="35">
            ';
            if ($term_all_values) {
                foreach ($term_all_values as $term) {
                    echo '
                    <span class="lh-base producto-variables--description text-muted ms-2"> ' . wp_strip_all_tags(term_description($term->term_id)) . '
                        <br>
                        <a href="#" class="text-link stretched-link" data-bs-toggle="modal" data-bs-target="#energyModal" data-energy-label="' . $energy_label_path . '">
                            Ver etiqueta
                        </a>
                    </span>
                    ';
                }
            }
            echo '
                    </div>
                </div>
            </div>
            ';
            
            $modal_html = '
            <div class="modal fade" id="energyModal" tabindex="-1" aria-labelledby="energyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title fs-5" id="energyModalLabel">Etiqueta energética ' . $product->get_name() . '</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body align-self-center">
                            <img id="energyLabelImage" src="" alt="Etiqueta energética" class="img-fluid">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>';
            
            echo $modal_html;
            
            echo '
            <script>
            document.addEventListener("DOMContentLoaded", function() {
              var energyModal = document.getElementById("energyModal");
              var energyLabelImage = document.getElementById("energyLabelImage");
              var energyLabelLinks = document.querySelectorAll("[data-energy-label]");
            
              energyLabelLinks.forEach(function(link) {
                link.addEventListener("click", function() {
                  var energyLabelPath = this.getAttribute("data-energy-label");
                  energyLabelImage.setAttribute("src", energyLabelPath);
                });
              });
            
              energyModal.addEventListener("hidden.bs.modal", function() {
                energyLabelImage.setAttribute("src", "");
              });
            });
            </script>
            ';
        }
    }
}

add_filter('woocommerce_structured_data_product', 'add_energy_efficiency_to_structured_data', 10, 2);

function add_energy_efficiency_to_structured_data($markup, $product)
{
    // Define los atributos del producto y su correspondiente clasificación de eficiencia energética
    $attribute_taxonomies = array(
        'pa_a-g' => array('max' => 'A', 'min' => 'G'),
        'pa_aa-f' => array('max' => 'A+', 'min' => 'F'),
        'pa_aaa-g' => array('max' => 'A++', 'min' => 'G'),
        'pa_aaaa-d' => array('max' => 'A+++', 'min' => 'D')
    );

    $product_id = $product->get_id();

    foreach ($attribute_taxonomies as $attribute => $values) {
        $term_names = wp_get_post_terms($product_id, $attribute, ['fields' => 'names']);

        // Comprueba si hay errores o si no hay términos
        if (isset($term_names->errors) || empty($term_names)) continue;

        // Añade la clasificación de eficiencia energética a los datos estructurados del producto
        $markup['energyEfficiencyClass'] = $term_names[0]; // Asumiendo que el primer término es la clase de eficiencia energética
        $markup['minEnergyEfficiencyClass'] = $values['min'];
        $markup['maxEnergyEfficiencyClass'] = $values['max'];

        // Interrumpe el bucle una vez que se ha encontrado un atributo válido
        break;
    }

    return $markup;
}
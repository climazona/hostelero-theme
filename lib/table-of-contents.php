<?php

// Hook the function to 'the_content' filter.
add_filter('the_content', 'toc_create');

/**
 * Create a table of contents for the post content.
 *
 * @param string $content The post content.
 * @return string Modified post content with table of contents.
 */
function toc_create($content) {
    if (!is_singular(array('noticias', 'post')) || empty($content)) {
        return $content;
    }

    $dom = toc_load_html($content);
    $headers = toc_get_headers($dom);

    if (!$headers) {
        return $content;
    }

    $table_of_contents = toc_generate_toc($headers);

    return $table_of_contents . $dom->saveHTML();
}

/**
 * Load the HTML content into a DOMDocument.
 *
 * @param string $html The HTML content.
 * @return DOMDocument The loaded DOMDocument.
 */
function toc_load_html($html) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    libxml_clear_errors();

    return $dom;
}

/**
 * Get headers from the DOMDocument.
 *
 * @param DOMDocument $dom The DOMDocument.
 * @return DOMNodeList List of headers.
 */
function toc_get_headers($dom) {
    $xpath = new DOMXPath($dom);
    return $xpath->query('//h2 | //h3');
}

/**
 * Generate the table of contents HTML.
 *
 * @param DOMNodeList $headers List of headers.
 * @return string The table of contents HTML.
 */
function toc_generate_toc($headers) {
    $toc = '<div class="table-of-contents card rounded-3 mb-3">
        <div class="card-body">
            <small class="mb-2 d-block">Tabla de contenidos</small>
            <ul class="m-0 list-unstyled">';

    $i = 1;
    foreach ($headers as $header) {
        $toc .= toc_generate_toc_item($header, $i);
        $header->setAttribute('id', 'table-of-contents-' . $i);
        $i++;
    }

    $toc .= '</ul></div></div>';

    return $toc;
}

/**
 * Generate a table of contents item.
 *
 * @param DOMElement $header The header element.
 * @param int $i The index of the header.
 * @return string The table of contents item HTML.
 */
function toc_generate_toc_item($header, $i) {
    $arrow = $header->tagName == 'h2' ? 'bi-arrow-right' : 'bi-arrow-return-right';
    $indent = $header->tagName == 'h3' ? ' ms-5' : '';

    return sprintf(
        '<li class="%s"><i class="bi %s"></i> <a href="%s#table-of-contents-%d">%s</a></li>',
        esc_attr($indent),
        esc_attr($arrow),
        esc_url(get_the_permalink()),
        $i,
        esc_html($header->textContent)
    );
}
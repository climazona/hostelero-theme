<?php
// Ruta: ./inc/social-share.php

function generate_social_share_component() {
    global $post;
    $url = get_permalink($post->ID);
    $title = get_the_title($post->ID);
    $encoded_url = urlencode($url);
    $encoded_title = urlencode($title);

    // Prepara la URL con metadato personalizado para Google Analytics 4
    $ga_url = $encoded_url . '?utm_source=social_share';

    // Mensaje personalizado para compartir
    $custom_message = "Mira lo que he encontrado en " . get_bloginfo('name') . ": " . $title . "! Echa un vistazo: ";
    $encoded_message = urlencode($custom_message);

    ob_start();
    ?>
    <div class="social-share-component mt-3">
        <span class="small">Compartir en:</span>
        <a rel="nofollow noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $ga_url; ?>" target="_blank" class="btn btn-light btn-sm">
            <i class="bi bi-facebook"></i>
        </a>
        <a rel="nofollow noopener noreferrer" href="https://twitter.com/intent/tweet?url=<?php echo $ga_url; ?>&text=<?php echo $encoded_message; ?>" target="_blank" class="btn btn-light btn-sm">
            <i class="bi bi-twitter"></i>
        </a>
        <a rel="nofollow noopener noreferrer" href="https://api.whatsapp.com/send?text=<?php echo $encoded_message . $ga_url; ?>" target="_blank" class="btn btn-light btn-sm">
            <i class="bi bi-whatsapp"></i>
        </a>
        <button id="copyButton" onclick="copyToClipboard('<?php echo $url; ?>', this)" class="btn btn-light btn-sm" data-original-text="Copiar enlace">
            <i class="bi bi-clipboard"></i> <span>Copiar enlace</span>
        </button>
        <!-- ... otros botones de redes sociales ... -->
    </div>
    <script type="text/javascript">
        function copyToClipboard(text, button) {
            var textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            
            button.innerHTML = '<i class="bi bi-clipboard-check"></i> <span>¡Copiado!</span>';
            
            setTimeout(function() {
                button.innerHTML = '<i class="bi bi-clipboard"></i> <span>' + button.getAttribute('data-original-text') + '</span>';
            }, 3000); // 3 segundos
        }
    </script>
    <?php
    return ob_get_clean();
}
?>
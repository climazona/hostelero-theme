<?php

function get_gases_fluorados_cnf() {
  return  [
    'title' => 'Normativa Gases Fluorados',
    'description' =>
    '
    <div class="h4 my-3">Despreocúpate, nos ocupamos de todo</div>
    <div class="alert alert-success my-4" role="alert">
        <i class="bi bi-check-square me-2"></i> Al aceptar nuestros 
        <a href="/terminos-y-condiciones#gases-fluorados" target="_blank" rel="noreferrer noopener nofollow" class="alert-link">
            términos y condiciones
        </a>, te aseguramos total transparencia y facilidad en el proceso de cumplimiento del «Real Decreto 115/2017, de 17 de Febrero, Anexo VI – Parte A».
        <hr>
        <i class="bi bi-envelope-paper me-2"></i> Te enviaremos el documento directamente a tu correo electrónico. <strong>¡Sin papeleo y sin complicaciones!</strong>
    </div>
    
    <div class="alert alert-info my-4" role="alert">
        <i class="bi bi-cursor me-2"></i> <strong>¡Facilidad desde cualquier dispositivo!</strong> Recibe y firma el documento cómodamente desde tu móvil u ordenador. <strong>¡No necesitarás imprimir ni escanear nada!</strong> Hacemos que el proceso sea lo más sencillo y conveniente.</p>
    </div>
    
    <p>Estás adquiriendo un equipo no herméticamente sellado, cargado con gas fluorado de efecto invernadero, pero no te preocupes, te asistimos en cada paso para asegurar su instalación adecuada por profesionales certificados.</p>
    <p>Más información: <a href="/terminos-y-condiciones#gases-fluorados" target="_blank" rel="noreferrer noopener nofollow">Términos y condiciones de compra</a>.</p>
    '
  ];
}

function add_field_gases_fluorados() {
	$config = get_gases_fluorados_cnf();
	echo '<div class="tab-pane fade" id="pills-gases" role="tabpanel" aria-labelledby="pills-gases-tab">' . $config['description'] . '</div>';
}
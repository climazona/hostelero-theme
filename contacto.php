<?php /* Template Name: Página de contacto */ ?>
<?php get_header(); ?>
<section id="single-contenido" class="my-3" >
    <div class="container">
        <h1 style="text-transform:capitalize" class="mt-5 mb-4"><?php the_title() ?></h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            <div class="col mb-4">
                <div class="border rounded-3 p-3">
                    <h2 class="h6"><i class="bi bi-shop me-2"></i> Tienda</h2>
                    <small class="text-muted">Consultas comerciales.</small>
                    <div class="d-grid">
                        <a class="btn btn-outline-primary btn-sm mt-2" href="tel:+34910600508" role="button"><i class="bi bi-telephone-outbound me-2"></i> 910 600 508 (Ext. 1)</a>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="border rounded-3 p-3">
                    <h2 class="h6"><i class="bi bi-gear me-2"></i> Dpto. Técnico</h2>
                    <small class="text-muted">Consultas técnicas.</small>
                    <div class="d-grid">
                        <a class="btn btn-outline-primary btn-sm mt-2" href="tel:+34910600508" role="button"><i class="bi bi-telephone-outbound me-2"></i> 910 600 508 (Ext. 2)</a>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="border rounded-3 p-3">
                    <h2 class="h6"><i class="bi bi-shield-check me-2"></i> Dpto. Reclamaciones</h2>
                    <small class="text-muted">Garantías y devoluciones.</small>
                    <div class="d-grid">
                        <a class="btn btn-outline-primary btn-sm mt-2" href="tel:+34910600508" role="button"><i class="bi bi-telephone-outbound me-2"></i> 910 600 508 (Ext. 3)</a>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="border rounded-3 p-3">
                    <h2 class="h6"><i class="bi bi-receipt-cutoff me-2"></i> Dpto. Administración</h2>
                    <small class="text-muted">Consultas administrativas.</small>
                    <div class="d-grid">
                        <a class="btn btn-outline-primary btn-sm mt-2" href="tel:+34910600508" role="button"><i class="bi bi-telephone-outbound me-2"></i> 910 600 508 (Ext. 4)</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="border rounded-3 mb-3 py-4">
                    <div class="px-4 pb-4">
                        <h5 class="card-title mb-3"><i class="bi bi-clock text-primario me-2"></i> Horario telefónico</h5>
                        <?php $post_date = date( 'l' ); ?>
                        <ul class="list-group">
                            <li <?php if ( "Monday" == $post_date) { echo 'class="list-group-item d-flex justify-content-between align-items-start bg-theme-primary text-white rounded-3" aria-current="true" style="width: 104%; right: 2%;"'; } else { echo 'class="list-group-item d-flex justify-content-between"'; }?> >
                                <div class="me-auto">Lunes</div>
                                <div>De 15:00 a 18:00</div>
                            </li>
                            <li <?php if ( "Tuesday" == $post_date) { echo 'class="list-group-item d-flex justify-content-between align-items-start bg-theme-primary text-white rounded-3" aria-current="true" style="width: 104%; right: 2%;"'; } else { echo 'class="list-group-item d-flex justify-content-between"'; }?> >
                                <div class="me-auto">Martes</div>
                                <div>De 15:00 a 18:00</div>
                            </li>
                            <li <?php if ( "Wednesday" == $post_date) { echo 'class="list-group-item d-flex justify-content-between align-items-start bg-theme-primary text-white rounded-3" aria-current="true" style="width: 104%; right: 2%;"'; } else { echo 'class="list-group-item d-flex justify-content-between"'; }?> >
                                <div class="me-auto">Miércoles</div>
                                <div>De 15:00 a 18:00</div>
                            </li>
                            <li <?php if ( "Thursday" == $post_date) { echo 'class="list-group-item d-flex justify-content-between align-items-start bg-theme-primary text-white rounded-3" aria-current="true" style="width: 104%; right: 2%;"'; } else { echo 'class="list-group-item d-flex justify-content-between"'; }?> >
                                <div class="me-auto">Jueves</div>
                                <div>De 15:00 a 18:00</div>
                            </li>
                            <li <?php if ( "Friday" == $post_date) { echo 'class="list-group-item d-flex justify-content-between align-items-start bg-theme-primary text-white rounded-3" aria-current="true" style="width: 104%; right: 2%;"'; } else { echo 'class="list-group-item d-flex justify-content-between"'; }?> >
                                <div class="me-auto">Viernes</div>
                                <div>De 15:00 a 18:00</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between disabled" aria-disabled="true">
                                <div class="me-auto">Sábado</div>
                                <div>Cerrado</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between disabled" aria-disabled="true">
                                <div class="me-auto">Domingo</div>
                                <div>Cerrado</div>
                            </li>
                        </ul>
                    </div>
                    <div class="px-4">
                        <p>O si lo prefieres, puedes contactar con nosotros mediante <strong>Whatsapp</strong> al <strong>910 600 508</strong>.</p>
                        <a href="https://wa.me/+34910600508/" class="btn btn-success"><i class="bi bi-whatsapp"></i> Abrir chat</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <p>Si necesitas contactar con nosotros mediante correo electrónico, puedes hacerlo rellenando el siguiente formulario:</p>
                <p>Horario de atención al cliente (por correo):<br>De 8:00 a 13:00 y de 15:00 a 18:00 (de lunes a viernes).</p>
                <?php echo do_shortcode('[contact-form-7 id="69" title="Contacto"]'); ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
<?php get_header();?>
<div class="container my-5">
    <div class="row">
        <div class="col text-center">
			<h1 class="fw-bolder"><i class="bi bi-exclamation-square me-2"></i> Error 404</h2>
			<p class="mb-5">
				<strong>¡Ups!</strong> La página solicitada no ha sido encontrada...
			</p>
			<hr>
			<input type="button" onclick="window.history.back();" value="Volver atrás" name="button" class="btn btn-lg btn-primary mt-4">
        </div>
   </div>
</div>
<?php get_footer(); ?>
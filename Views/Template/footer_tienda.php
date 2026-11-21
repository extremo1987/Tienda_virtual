	<?php 
		$catFotter = getCatFooter();
	 ?>
	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categorías
					</h4>
					<?php if(count($catFotter) > 0){ ?>
					<ul>
						<?php foreach ($catFotter as $cat) { ?>
						<li class="p-b-10">
							<a href="<?= base_url() ?>/tienda/categoria/<?= escapar($cat['idcategoria'].'/'.$cat['ruta']) ?>" class="stext-107 cl7 hov-cl1 trans-04">
								<?= escapar($cat['nombre']) ?>
							</a>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Contacto
					</h4>

					<p class="stext-107 cl7 size-201">
						<?= escapar(DIRECCION) ?> <br>
						Tel: <a class="linkFooter" href="tel:<?= escapar(TELEMPRESA) ?>"><?= escapar(TELEMPRESA) ?></a><br>
						Email: <a class="linkFooter" href="mailto:<?= escapar(EMAIL_EMPRESA) ?>"><?= escapar(EMAIL_EMPRESA) ?></a>
					</p>

					<div class="p-t-27">
						<a href="<?= escapar(FACEBOOK) ?>" target="_blank" rel="noopener" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="<?= escapar(INSTAGRAM) ?>" target="_blank" rel="noopener"  class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="https://wa.me/<?= escapar(preg_replace('/\D/', '', WHATSAPP)) ?>" target="_blank" rel="noopener"  class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fab fa-whatsapp"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Suscríbete
					</h4>

					<form id="frmSuscripcion" name="frmSuscripcion">
						<input type="hidden" name="ft" value="<?= formToken() ?>">
					<div style="position:absolute;left:-9999px;top:-9999px" aria-hidden="true"><input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></div>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" id="nombreSuscripcion" name="nombreSuscripcion" placeholder="Nombre completo" required>
							<div class="focus-input1 trans-04"></div>
						</div>
						<br>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="email" id="emailSuscripcion" name="emailSuscripcion" placeholder="email@example.com" required >
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Suscribirme
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<p class="stext-107 cl6 txt-center">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					<?= escapar(NOMBRE_EMPESA); ?> | <?= escapar(WEB_EMPRESA); ?> | <a href="https://colorlib.com" target="_blank">Colorlib</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
			</div>
		</div>
	</footer>
	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>
	<script>
	    const base_url = "<?= base_url(); ?>";
		const smony = "<?= escapar(SMONEY); ?>";
	</script>
<!--===============================================================================================-->	
	<!--	<script src="<?= media() ?>/tienda/vendor/jquery/jquery-3.6.0.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/slick/slick.min.js"></script>
	<script src="<?= media() ?>/tienda/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/parallax100/parallax100.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/sweetalert/sweetalert.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media();?>/js/fontawesome.js"></script>
	<script src="<?= media() ?>/tienda/js/main.js"></script>
	<script src="<?= media();?>/js/functions_admin.js"></script>
	<script src="<?= media() ?>/js/functions_login.js"></script>
	<script src="<?= media() ?>/tienda/js/functions.js"></script>
	<script src="<?= media() ?>/tienda/js/tactil-carrusel.js?v=<?= (int)@filemtime('Assets/tienda/js/tactil-carrusel.js') ?>"></script>
	<script src="<?= media() ?>/tienda/js/banner-puntos.js?v=<?= (int)@filemtime('Assets/tienda/js/banner-puntos.js') ?>"></script>
	
<!-- Ícono de WhatsApp con texto -->
<?php $waNumero = preg_replace('/\D/', '', WHATSAPP); if(strlen($waNumero) >= 8){ // el número sale de Configuración; si está vacío, el botón no se muestra ?>
<a href="https://wa.me/<?= escapar($waNumero) ?>" class="whatsapp-button" target="_blank" rel="noopener">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/WhatsApp_icon.png" alt="WhatsApp" />
    <span>¿Necesitas ayuda?</span>
</a>
<?php } ?>

<!-- Estilos para el ícono y texto -->
<style>
    .whatsapp-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 10px;
        color: white;
        font-weight: bold;
        background-color: transparent;
        flex-direction: column; /* Texto encima del ícono */
    }

    .whatsapp-button img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-bottom: 10px;
        background-color: #25D366; /* Color de fondo verde para el ícono */
        padding: 10px; /* Espaciado interno para dar efecto de fondo */
    }

    .whatsapp-button span {
        color: #25D366; /* Color verde para el texto */
        display: none;
    }

    .whatsapp-button:hover span {
        display: block; /* Muestra el texto al pasar el mouse */
    }

    .whatsapp-button:hover img {
        background-color: #128C7E; /* Cambia el color de fondo al pasar el mouse */
    }

    /* Ajustes para pantallas más pequeñas */
    @media (max-width: 768px) {
        .whatsapp-button {
            bottom: 10px;
            right: 10px;
            padding: 8px;
        }

        .whatsapp-button img {
            width: 40px;
            height: 40px;
            padding: 8px;
        }

        .whatsapp-button span {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .whatsapp-button {
            bottom: 5px;
            right: 5px;
            padding: 6px;
        }

        .whatsapp-button img {
            width: 35px;
            height: 35px;
            padding: 6px;
        }

        .whatsapp-button span {
            font-size: 12px;
        }
    }
</style>





</body>
</html>
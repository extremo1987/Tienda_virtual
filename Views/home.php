<?php 
	headerTienda($data);
	$arrSlider = $data['slider'];
	$arrBanner = $data['banner'];
	$arrProductos = $data['productos'];

	$contentPage = "";
	if(!empty($data['page'])){
		$contentPage = $data['page']['contenido'];
	}

 ?>
	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
			<?php 
			for ($i=0; $i < count($arrSlider) ; $i++) { 
				$ruta = $arrSlider[$i]['ruta'];
			 ?>
				<div class="item-slick1" style="background-image: url(<?= escapar($arrSlider[$i]['portada']) ?>);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									<?= $arrSlider[$i]['descripcion'] ?>
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									<?= escapar($arrSlider[$i]['nombre']) ?>
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="<?= base_url().'/tienda/categoria/'.$arrSlider[$i]['idcategoria'].'/'.$ruta; ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Ver productos
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php 
			}
			?>
			</div>
		</div>
	</section>

	<!-- Banner -->
	<div class="sec-banner bg0 p-t-80 p-b-50">
		<div class="container">
			<div class="mg-seccion-titulo">
				<div>
					<h3>Compra por categoría</h3>
					<p>Encuentra lo que buscas más rápido.</p>
				</div>
				<a class="mg-ver-todo" href="<?= base_url() ?>/tienda">Ver toda la tienda →</a>
			</div>
			<div class="row">
				<?php
				for ($j=0; $j < count($arrBanner); $j++) {
					$ruta = $arrBanner[$j]['ruta']; 
				 ?>
				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
						<img src="<?= escapar($arrBanner[$j]['portada']) ?>" alt="<?= escapar($arrBanner[$j]['nombre']) ?>">

						<a href="<?= base_url().'/tienda/categoria/'.$arrBanner[$j]['idcategoria'].'/'.$ruta; ?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									<?= escapar($arrBanner[$j]['nombre']) ?>
								</span>
								<!-- <span class="block1-info stext-102 trans-04">
									Spring 2018
								</span> -->
							</div>
							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver productos
								</div>
							</div>
						</a>
					</div>
				</div>
				<?php 
				}
				 ?>
			</div>
		</div>
	</div>

	<!-- Product -->
	<section class="bg0 p-t-23 p-b-80 sec-producto-home">
		<div class="container">
			<div class="mg-seccion-titulo">
				<div>
					<h3>Productos nuevos</h3>
					<p>Lo más reciente de la tienda.</p>
				</div>
				<a class="mg-ver-todo" href="<?= base_url() ?>/tienda">Ver todos →</a>
			</div>
			<div class="row isotope-grid">
			<?php 
				$varInfo = infoVariantesLote(array_column($arrProductos, 'idproducto'));
				for ($p=0; $p < count($arrProductos) ; $p++) {
					$rutaProducto = $arrProductos[$p]['ruta']; 
					if(count($arrProductos[$p]['images']) > 0 ){
						$portada = $arrProductos[$p]['images'][0]['url_image'];
					}else{
						$portada = media().'/images/uploads/product.png';
					}
			 ?>
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
							<div class="mg-etiquetas">
								<?php if((int)$arrProductos[$p]['stock'] === 1){ ?><span class="mg-etiqueta mg-etiqueta--ultimas">¡Última unidad!</span><?php } ?>
								<?php if(!empty($varInfo[(int)$arrProductos[$p]['idproducto']])){ ?><span class="mg-etiqueta mg-etiqueta--opciones">Varias opciones</span><?php } ?>
							</div>
							<img src="<?= escapar($portada) ?>" alt="<?= escapar($arrProductos[$p]['nombre']) ?>">
							<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								Ver producto
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									<?= escapar($arrProductos[$p]['nombre']) ?>
								</a>

								<span class="stext-105 cl3">
									<?= escapar(SMONEY).formatMoney($arrProductos[$p]['precio']); ?>
								</span>
							</div>

							<div class="block2-txt-child2 flex-r p-t-3">
								<?php if(!empty($varInfo[(int)$arrProductos[$p]['idproducto']])){ ?>
<a href="<?= base_url().'/tienda/producto/'.(int)$arrProductos[$p]['idproducto'].'/'.escapar($arrProductos[$p]['ruta']) ?>" class="btn-addwish-b2 dis-block pos-relative icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11" title="Elegir opciones (color, talla…)"><i class="zmdi zmdi-shopping-cart"></i></a>
<?php }else{ ?>
<a href="#" id="<?= tokenItem((int)$arrProductos[$p]['idproducto']) ?>" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 js-addcart-detail icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11"><i class="zmdi zmdi-shopping-cart"></i></a>
<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="<?= base_url() ?>/tienda" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Ver más
				</a>
			</div>
		</div>

		<div class="container text-center p-t-80">
			<hr>
			<?= $contentPage ?>
		</div>
	</section>
<!-- Franja de confianza -->
	<section class="mg-confianza">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-4"><div class="mg-conf-item"><div class="mg-conf-ico"><i class="fas fa-credit-card"></i></div><div><b>Paga como prefieras</b><span class="mg-conf-txt">Efectivo, transferencia o PayPal.</span></div></div></div>
				<div class="col-12 col-md-4"><div class="mg-conf-item"><div class="mg-conf-ico"><i class="fas fa-tags"></i></div><div><b>Elige tu talla y color</b><span class="mg-conf-txt">Cada producto muestra sus opciones disponibles.</span></div></div></div>
				<div class="col-12 col-md-4"><div class="mg-conf-item"><div class="mg-conf-ico"><i class="fab fa-whatsapp"></i></div><div><b>Atención por WhatsApp</b><span class="mg-conf-txt">Escríbenos y te ayudamos con tu pedido.</span></div></div></div>
			</div>
		</div>
	</section>
<?php 
	footerTienda($data);
 ?>


<?php 
	$cliente = $data['cliente'];
	$orden = $data['orden'];
	$detalle = $data['detalle'];
 ?>
<!DOCTYPE html>
<html lang="es">
<head> 
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Factura</title>
	<style>
		table{
			width: 100%;
		}
		table td, table th{
			font-size: 12px;
		}
		h4{
			margin-bottom: 0px;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.wd33{
			width: 33.33%;
		}
		.tbl-cliente{
			border: 1px solid #CCC;
			border-radius: 10px;
			padding: 5px;
		}
		.wd10{
			width: 10%;
		}
		.wd15{
			width: 15%;
		}
		.wd40{
			width: 40%;
		}
		.wd55{
			width: 55%;
		}
		.tbl-detalle{
			border-collapse: collapse;
		}
		.tbl-detalle thead th{
			padding: 5px;
			background-color: #787a7a;
			color: #FFF;
		}
		.tbl-detalle tbody td{
			border-bottom: 1px solid #CCC;
			padding: 5px;
		}
		.tbl-detalle tfoot td{
			padding: 5px;
		}
	</style>
</head>
<body>
	<table class="tbl-hader">
		<tbody>
			<tr>
				<td class="wd33">
					<img src="data:image/png;base64,<?= base64_encode((string)@file_get_contents('Assets/tienda/images/logo.png')) ?>" alt="Logo">
				</td>
				<td class="text-center wd33">
					<h4><strong><?= escapar(NOMBRE_EMPESA) ?></strong></h4>
					<p><?= escapar(DIRECCION) ?> <br>
					Teléfono: <?= escapar(TELEMPRESA) ?> <br>
					Email: <?= escapar(EMAIL_EMPRESA)  ?></p>
				</td>
				<td class="text-right wd33">
					<p>No. Orden <strong><?= escapar($orden['idpedido']) ?></strong><br>
						Fecha: <?= escapar($orden['fecha']) ?>  <br>
						<?php 
							if($orden['tipopagoid'] == 1){
						 ?>
						Método Pago: <?= escapar($orden['tipopago']) ?> <br>
						Transacción: <?= escapar($orden['idtransaccionpaypal']) ?>
						<?php }else{ ?>
						Método Pago: Pago contra entrega <br>
						Tipo Pago: <?= escapar($orden['tipopago']) ?>
						<?php } ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<table class="tbl-cliente">
		<tbody>
			<tr>
				<td class="wd10">NIT:</td>
				<td class="wd40"><?= escapar($cliente['nit']) ?></td>
				<td class="wd10">Teléfono:</td>
				<td class="wd40"><?= escapar($cliente['telefono']) ?></td>
			</tr>
			<tr>
				<td>Nombre:</td>
				<td><?= escapar($cliente['nombres'].' '.$cliente['apellidos']) ?></td>
				<td>Dirección:</td>
				<td><?= escapar($cliente['direccionfiscal']) ?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table class="tbl-detalle">
		<thead>
			<tr>
				<th class="wd55">Descripción</th>
				<th class="wd15 text-right">Precio</th>
				<th class="wd15 text-center">Cantidad</th>
				<th class="wd15 text-right">Importe</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$subtotal = 0;
				foreach ($detalle as $producto) {
					$importe = $producto['precio'] * $producto['cantidad'];
					$subtotal = $subtotal + $importe;
			 ?>
			<tr>
				<td><?= nombreItem($producto) ?></td>
				<td class="text-right"><?= escapar(SMONEY).' '.formatMoney($producto['precio']) ?></td>
				<td class="text-center"><?= escapar($producto['cantidad']) ?></td>
				<td class="text-right"><?= escapar(SMONEY).' '.formatMoney($importe) ?></td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" class="text-right">Subtotal:</td>
				<td class="text-right"><?= escapar(SMONEY).' '.formatMoney($subtotal) ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">Envío:</td>
				<td class="text-right"><?= escapar(SMONEY).' '.formatMoney($orden['costo_envio']); ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">Total:</td>
				<td class="text-right"><?= escapar(SMONEY).' '.formatMoney($orden['monto']); ?></td>
			</tr>
		</tfoot>
	</table>
	<div class="text-center">
		<p>Si tienes preguntas sobre tu pedido, <br> pongase en contacto con nombre, teléfono y Email</p>
		<h4>¡Gracias por tu compra!</h4>
	</div>
</body>
</html>
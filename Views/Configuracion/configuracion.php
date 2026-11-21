<?php
	headerAdmin($data);
	$campos = $data['campos']; $valores = $data['valores']; $editar = $data['puedeEditar'];
	$dis = $editar ? '' : ' disabled';
?>
<style>
	.cfg-card .tile-title { display:flex; align-items:center; gap:10px; margin-bottom:4px; }
	.cfg-card .tile-title i { color:#009688; }
	.cfg-ayuda-grupo { color:#7a7f93; font-size:13.5px; margin:-4px 0 16px; }
	.cfg-card .form-group small { display:block; color:#8a8fa3; margin-top:3px; }
	.cfg-error { color:#d9534f; font-size:13px; margin-top:3px; display:none; }
	.is-invalid + .cfg-error, .cfg-error.visible { display:block; }
	.cfg-cats { display:flex; flex-wrap:wrap; gap:8px 18px; }
	.cfg-cats label { margin:0; font-weight:400; cursor:pointer; user-select:none; }
	.cfg-barra { position:sticky; bottom:0; background:rgba(255,255,255,.96); border-top:1px solid #e3e6ea; padding:12px 18px; margin:10px -15px -15px; display:flex; gap:12px; align-items:center; justify-content:flex-end; z-index:10; }
	.cfg-secreto-ok { display:inline-block; font-size:12px; background:#e3f6ec; color:#1c7c4f; border-radius:999px; padding:2px 10px; margin-left:6px; }
</style>
<main class="app-content">
	<div class="app-title">
		<div><h1><i class="fas fa-cogs"></i> <?= $data['page_title'] ?></h1></div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>/configuracion">Configuración</a></li>
		</ul>
	</div>

	<?php if(!empty($data['fijosEnArchivo'])){ ?>
	<div class="alert alert-warning">
		<b>Atención:</b> estos ajustes siguen escritos dentro de <code>Config/Config.php</code> y por eso lo que cambies aquí no tendrá efecto:
		<?= escapar(implode(', ', $data['fijosEnArchivo'])) ?>. Pídele a quien instaló el sistema que ejecute la migración
		<code>php database/migraciones/002_configuracion.php</code>.
	</div>
	<?php } ?>
	<?php if(!$editar){ ?><div class="alert alert-info">Tu rol puede ver la configuración, pero no modificarla.</div><?php } ?>

	<form id="formConfig" autocomplete="off" novalidate>
	<?php foreach($data['grupos'] as $gid => $g){ ?>
		<div class="tile cfg-card" id="grupo-<?= escapar($gid) ?>">
			<h3 class="tile-title"><i class="<?= escapar($g[1]) ?>"></i> <?= escapar($g[0]) ?></h3>
			<p class="cfg-ayuda-grupo"><?= escapar($g[2]) ?></p>
			<div class="row">
			<?php foreach($campos as $k => [$grupo, $etiqueta, $tipo, $defecto, $ayuda, $op]){ if($grupo !== $gid){ continue; }
				$ancho = in_array($tipo, ['texto_largo', 'categorias'], true) ? 'col-12' : 'col-md-6'; ?>
				<div class="<?= $ancho ?>">
					<div class="form-group">
						<label class="control-label" for="aj_<?= escapar($k) ?>"><?= escapar($etiqueta) ?><?= !empty($op['req']) ? ' <span class="required">*</span>' : '' ?>
							<?php if($tipo === 'secreto' && !empty($valores[$k]['tiene'])){ ?><span class="cfg-secreto-ok"><i class="fas fa-lock"></i> guardada</span><?php } ?></label>
						<?php if($tipo === 'texto_largo'){ ?>
							<textarea class="form-control" id="aj_<?= escapar($k) ?>" name="ajustes[<?= escapar($k) ?>]" rows="2" maxlength="<?= (int)($op['max'] ?? 300) ?>"<?= $dis ?>><?= escapar($valores[$k]) ?></textarea>
						<?php } elseif($tipo === 'select'){ ?>
							<select class="form-control" id="aj_<?= escapar($k) ?>" name="ajustes[<?= escapar($k) ?>]"<?= $dis ?>>
								<?php foreach($op['opciones'] as $val => $txt){ ?><option value="<?= escapar($val) ?>"<?= (string)$valores[$k] === (string)$val ? ' selected' : '' ?>><?= escapar($txt) ?></option><?php } ?>
							</select>
						<?php } elseif($tipo === 'secreto'){ ?>
							<input class="form-control" type="password" id="aj_<?= escapar($k) ?>" name="ajustes[<?= escapar($k) ?>]" autocomplete="new-password" placeholder="<?= !empty($valores[$k]['tiene']) ? '•••••••• (déjalo vacío para no cambiarlo)' : 'Escríbela aquí' ?>"<?= $dis ?>>
						<?php } elseif($tipo === 'categorias'){ $marcadas = array_map('intval', explode(',', (string)$valores[$k])); ?>
							<div class="cfg-cats" id="aj_<?= escapar($k) ?>">
								<?php foreach($data['categorias'] as $c){ ?>
									<label><input type="checkbox" name="ajustes[<?= escapar($k) ?>][]" value="<?= (int)$c['idcategoria'] ?>"<?= in_array((int)$c['idcategoria'], $marcadas, true) ? ' checked' : '' ?><?= $dis ?>> <?= escapar($c['nombre']) ?></label>
								<?php } ?>
							</div>
						<?php } else {
							$inputTipo = in_array($tipo, ['entero', 'decimal'], true) ? 'number' : ($tipo === 'email' ? 'email' : 'text');
							$extra = $tipo === 'entero' ? ' step="1" min="'.(int)$op['min'].'" max="'.(int)$op['max'].'"' : ($tipo === 'decimal' ? ' step="0.01" min="'.$op['min'].'" max="'.$op['max'].'"' : ' maxlength="'.(int)($op['max'] ?? 120).'"'); ?>
							<input class="form-control" type="<?= $inputTipo ?>" id="aj_<?= escapar($k) ?>" name="ajustes[<?= escapar($k) ?>]" value="<?= escapar($valores[$k]) ?>"<?= $extra ?><?= $dis ?>>
						<?php } ?>
						<div class="cfg-error" data-error-de="<?= escapar($k) ?>"></div>
						<?php if($ayuda !== ''){ ?><small><?= escapar($ayuda) ?></small><?php } ?>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php if($gid === 'correo' && $editar){ ?>
				<hr>
				<div class="form-row align-items-end">
					<div class="col-md-5">
						<label class="control-label" for="destinoPrueba">Enviar un correo de prueba a</label>
						<input class="form-control" type="email" id="destinoPrueba" placeholder="tu-correo@ejemplo.com">
					</div>
					<div class="col-auto">
						<button type="button" class="btn btn-outline-primary" id="btnProbarCorreo"><i class="fas fa-paper-plane"></i> Enviar prueba</button>
					</div>
				</div>
				<small class="text-muted">La prueba usa lo que ya está <b>guardado</b>: primero pulsa «Guardar cambios».</small>
			<?php } ?>
		</div>
	<?php } ?>
		<?php if($editar){ ?>
		<div class="cfg-barra">
			<span id="cfgEstado" class="text-muted"></span>
			<button type="submit" class="btn btn-primary btn-lg" id="btnGuardarConfig"><i class="fas fa-save"></i> Guardar cambios</button>
		</div>
		<?php } ?>
	</form>
</main>
<?php footerAdmin($data); ?>

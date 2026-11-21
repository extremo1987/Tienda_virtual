<?php
	// Solo nombres simples: evita cargar archivos fuera de Controllers/ o llamar métodos internos
	$nombreValido = '/^[A-Za-z][A-Za-z0-9_]*$/';
	$controller = ucwords($controller);
	$controllerFile = "Controllers/".$controller.".php";
	if(preg_match($nombreValido, $controller) && preg_match($nombreValido, $method) && file_exists($controllerFile))
	{
		require_once($controllerFile);
		$controller = new $controller();
		if($method !== 'loadModel' && is_callable([$controller, $method]))
		{
			// Si el método espera un número (ej. un id) y la dirección trae otra cosa, no se ejecuta: es una dirección inválida
			$parametros = (new ReflectionMethod($controller, $method))->getParameters();
			$tipo = $parametros ? $parametros[0]->getType() : null;
			if($tipo instanceof ReflectionNamedType && $tipo->getName() === 'int' && !preg_match('/^\d+$/', (string)$params)){
				require_once("Controllers/Error.php");
			}else{
				$controller->{$method}($params);
			}
		}else{
			require_once("Controllers/Error.php");
		}
	}else{
		require_once("Controllers/Error.php");
	}

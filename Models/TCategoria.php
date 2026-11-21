<?php 
require_once("Libraries/Core/Mysql.php");
trait TCategoria{
	private $con;

	public function getCategoriasT(string $categorias){
		$this->con = new Mysql();
		$ids = array_values(array_filter(array_map('intval', explode(',', $categorias))));
		if (!$ids) { return []; }
		$sql = "SELECT idcategoria, nombre, descripcion, portada, ruta
				 FROM categoria WHERE status != 0 AND idcategoria IN (".implode(',', array_fill(0, count($ids), '?')).")";
		$request = $this->con->select_all($sql, $ids);
		if(count($request) > 0){
			for ($c=0; $c < count($request) ; $c++) { 
				$request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada'];		
			}
		}
		return $request;
	}

	public function getCategorias(){
		$this->con = new Mysql();
		$sql = "SELECT c.idcategoria, c.nombre, c.portada, c.ruta, count(p.categoriaid) AS cantidad
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE c.status = 1
				GROUP BY p.categoriaid, c.idcategoria";
		$request = $this->con->select_all($sql);
		if(count($request) > 0){
			for ($c=0; $c < count($request) ; $c++) { 
				$request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada'];		
			}
		}
		return $request;
	}
}

 ?>
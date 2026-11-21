<?php 

	class ProductosModel extends Mysql
	{
		private $intIdProducto;
		private $strNombre;
		private $strDescripcion;
		private $intCodigo;
		private $intCategoriaId;
		private $strCompra;
		private $strPrecio;
		private $intStock;
		private $intStatus;
		private $strRuta;
		private $strImagen;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectProductos(){
			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.categoriaid,
							c.nombre as categoria,
							p.compra,
							p.precio,
							p.stock,
							p.status 
					FROM producto p 
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE p.status != 0 ";
					$request = $this->select_all($sql);
			return $request;
		}	

public function insertProducto(string $nombre, string $descripcion, string $codigo, int $categoriaid, string $compra, string $precio, int $stock, string $ruta, int $status){
    $this->strNombre = $nombre;
    $this->strDescripcion = $descripcion;
    $this->intCodigo = $codigo; // Ahora es tratado como string
    $this->intCategoriaId = $categoriaid;
    $this->strCompra = $compra;
    $this->strPrecio = $precio;
    $this->intStock = $stock;
    $this->strRuta = $ruta;
    $this->intStatus = $status;
    $return = 0;
    $sql = "SELECT * FROM producto WHERE codigo = ?"; $request = $this->select_all($sql, [$this->intCodigo]);

    if(empty($request))
    {
        $query_insert  = "INSERT INTO producto(categoriaid,
                                                codigo,
                                                nombre,
                                                descripcion,
                                                compra,
                                                precio,
                                                stock,
                                                ruta,
                                                status) 
                          VALUES(?,?,?,?,?,?,?,?,?)";
        $arrData = array($this->intCategoriaId,
                        $this->intCodigo, // Sin cambios aquí, solo se asegura que se trata como string
                        $this->strNombre,
                        $this->strDescripcion,
                        $this->strCompra,
                        $this->strPrecio,
                        $this->intStock,
                        $this->strRuta,
                        $this->intStatus);
        $request_insert = $this->insert($query_insert,$arrData);
        $return = $request_insert;
    }else{
        $return = "exist";
    }
    return $return;
}


		public function updateProducto(int $idproducto, string $nombre, string $descripcion, string $codigo, int $categoriaid, string $compra, string $precio, int $stock, string $ruta, int $status){
			$this->intIdProducto = $idproducto;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCodigo = $codigo;
			$this->intCategoriaId = $categoriaid;
			$this->strCompra = $compra;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
			$return = 0;
			$sql = "SELECT * FROM producto WHERE codigo = ? AND idproducto != ? "; $request = $this->select_all($sql, [$this->intCodigo, $this->intIdProducto]);
			if(empty($request))
			{
				$sql = "UPDATE producto 
						SET categoriaid=?,
							codigo=?,
							nombre=?,
							descripcion=?,
							compra=?,
							precio=?,
							stock=?,
							ruta=?,
							status=? 
						WHERE idproducto = $this->intIdProducto ";
				$arrData = array($this->intCategoriaId,
        						$this->intCodigo,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strCompra,
        						$this->strPrecio,
        						$this->intStock,
        						$this->strRuta,
        						$this->intStatus);

	        	$request = $this->update($sql,$arrData);
	        	if($request){ $this->sincronizarStock($this->intIdProducto); } // con variantes, el stock es la suma de ellas
	        	$return = $request;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function selectProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.compra,
							p.precio,
							p.stock,
							p.categoriaid,
							c.nombre as categoria,
							p.status
					FROM producto p
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE idproducto = $this->intIdProducto";
			$request = $this->select($sql);
			return $request;

		}

		public function insertImage(int $idproducto, string $imagen){
			$this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
			$query_insert  = "INSERT INTO imagen(productoid,img) VALUES(?,?)";
	        $arrData = array($this->intIdProducto,
        					$this->strImagen);
	        $request_insert = $this->insert($query_insert,$arrData);
	        return $request_insert;
		}

		public function selectImages(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "SELECT productoid,img
					FROM imagen
					WHERE productoid = $this->intIdProducto";
			$request = $this->select_all($sql);
			return $request;
		}

		public function deleteImage(int $idproducto, string $imagen){
			$this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
			$query  = "DELETE FROM imagen 
						WHERE productoid = ? AND img = ?"; $request_delete = $this->delete($query, [$this->intIdProducto, $this->strImagen]);
	        return $request_delete;
		}

		public function deleteProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}
		//---------- Variantes de producto (color, talla, medidas...) ----------
		public function selectVariantes(int $idproducto){
			$rows = $this->select_all("SELECT idvariante, atributos, etiqueta, codigo, precio, stock, status FROM variante WHERE productoid = ? ORDER BY idvariante", [$idproducto]);
			foreach($rows as $i => $r){ $rows[$i]['atributos'] = json_decode($r['atributos'], true) ?: []; }
			return $rows;
		}
		public function tieneVariantes(int $idproducto){
			$r = $this->select("SELECT COUNT(*) AS n FROM variante WHERE productoid = ?", [$idproducto]);
			return (int)($r['n'] ?? 0) > 0;
		}
		//El stock del producto es la suma del stock de sus variantes activas
		public function sincronizarStock(int $idproducto){
			if(!$this->tieneVariantes($idproducto)){ return false; }
			return $this->update("UPDATE producto SET stock = (SELECT COALESCE(SUM(stock),0) FROM variante WHERE productoid = ? AND status = 1) WHERE idproducto = ?", [$idproducto, $idproducto]);
		}
		//Guarda la lista completa de variantes: crea las nuevas, actualiza las que ya existen y elimina las que ya no vienen. Todo o nada.
		public function saveVariantes(int $idproducto, array $items){
			$existentes = array_map('intval', array_column($this->select_all("SELECT idvariante FROM variante WHERE productoid = ?", [$idproducto]), 'idvariante'));
			$this->beginTransaction();
			try{
				$conservar = [];
				foreach($items as $it){
					$vals = [json_encode($it['atributos'], JSON_UNESCAPED_UNICODE), $it['etiqueta'], $it['codigo'], $it['precio'], $it['stock'], $it['status']];
					if($it['id'] > 0 && in_array($it['id'], $existentes, true)){
						$this->update("UPDATE variante SET atributos=?, etiqueta=?, codigo=?, precio=?, stock=?, status=? WHERE idvariante=? AND productoid=?", array_merge($vals, [$it['id'], $idproducto]));
						$conservar[] = $it['id'];
					}else{
						$conservar[] = (int)$this->insert("INSERT INTO variante(atributos,etiqueta,codigo,precio,stock,status,productoid) VALUES(?,?,?,?,?,?,?)", array_merge($vals, [$idproducto]));
					}
				}
				$sobran = array_values(array_diff($existentes, $conservar));
				if($sobran){
					$this->delete("DELETE FROM variante WHERE productoid = ? AND idvariante IN (".implode(',', array_fill(0, count($sobran), '?')).")", array_merge([$idproducto], $sobran));
				}
				$this->sincronizarStock($idproducto);
				$this->commit();
				return true;
			}catch(Throwable $e){
				$this->rollBack();
				error_log('saveVariantes: '.$e->getMessage());
				return false;
			}
		}
	}
 ?>
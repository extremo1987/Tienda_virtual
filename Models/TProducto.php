<?php 
//se modificaron todos donde se puso condicion si no hay stock no se muestra en la web y si estan desactivados igual
require_once("Libraries/Core/Mysql.php");
trait TProducto{
    private $con;
    private $strCategoria;
    private $intIdcategoria;
    private $intIdProducto;
    private $strProducto;
    private $cant;
    private $option;
    private $strRuta;
    private $strRutaCategoria;
    
    public function getProductosT(){
        $this->con = new Mysql();
        // Asegura que solo se seleccionen productos con estatus 1 (activos) y que tengan stock disponible
        $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        p.ruta,
                        p.stock
                FROM producto p 
                INNER JOIN categoria c ON p.categoriaid = c.idcategoria
                WHERE p.status = 1 AND p.stock > 0
                ORDER BY p.idproducto DESC LIMIT ".CANTPORDHOME;
                
        $request = $this->con->select_all($sql);
        
        if(count($request) > 0){
            for ($c=0; $c < count($request); $c++) { 
                $intIdProducto = $request[$c]['idproducto'];
                $sqlImg = "SELECT img FROM imagen WHERE productoid = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                
                if(count($arrImg) > 0){
                    for ($i=0; $i < count($arrImg); $i++) { 
                        $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                    }
                }
                $request[$c]['images'] = $arrImg;
            }
        }
        return $request;
    }



public function getProductosPage($desde, $porpagina){
    $this->con = new Mysql();
    $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    p.precio,
                    p.ruta,
                    p.stock
            FROM producto p 
            INNER JOIN categoria c
            ON p.categoriaid = c.idcategoria
            WHERE p.status = 1 AND p.stock > 0 ORDER BY p.idproducto DESC LIMIT ".(int)$desde.",".(int)$porpagina;
    $request = $this->con->select_all($sql);
    if(count($request) > 0){
        for ($c=0; $c < count($request); $c++) { 
            $intIdProducto = $request[$c]['idproducto'];
            $sqlImg = "SELECT img
                    FROM imagen
                    WHERE productoid = $intIdProducto";
            $arrImg = $this->con->select_all($sqlImg);
            if(count($arrImg) > 0){
                for ($i=0; $i < count($arrImg); $i++) { 
                    $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                }
            }
            $request[$c]['images'] = $arrImg;
        }
    }
    return $request;
}

        //se modifica cual se va mostrar en pagina web si es 1 status activo si esta inactivo 2 y si no tiene stock 0 no se va mostrar tampoco 
	public function getProductosCategoriaT(int $idcategoria, string $ruta, $desde = null, $porpagina = null){
    $this->intIdcategoria = $idcategoria;
    $this->strRuta = $ruta;
    $where = "";
    if(is_numeric($desde) AND is_numeric($porpagina)){
        $where = " LIMIT ".$desde.",".$porpagina;
    }

    $this->con = new Mysql();
    $sql_cat = "SELECT idcategoria,nombre,ruta FROM categoria WHERE idcategoria = '{$this->intIdcategoria}'";
    $request = $this->con->select($sql_cat);

    if(!empty($request)){
        $this->strCategoria = $request['nombre'];
        $this->strRutaCategoria = $request['ruta'];
        $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        p.ruta,
                        p.stock
                FROM producto p 
                INNER JOIN categoria c
                ON p.categoriaid = c.idcategoria
                WHERE p.status = 1 AND p.categoriaid = $this->intIdcategoria AND c.ruta = ? AND p.stock > 0
                ORDER BY p.idproducto DESC ".$where;
                $request = $this->con->select_all($sql, [$this->strRuta]);
                if(count($request) > 0){
                    for ($c=0; $c < count($request) ; $c++) { 
                        $intIdProducto = $request[$c]['idproducto'];
                        $sqlImg = "SELECT img
                                FROM imagen
                                WHERE productoid = $intIdProducto";
                        $arrImg = $this->con->select_all($sqlImg);
                        if(count($arrImg) > 0){
                            for ($i=0; $i < count($arrImg); $i++) { 
                                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                            }
                        }
                        $request[$c]['images'] = $arrImg;
                    }
                }
        $request = array('idcategoria' => $this->intIdcategoria,
                            'ruta' => $this->strRutaCategoria,
                            'categoria' => $this->strCategoria,
                            'productos' => $request
                        );

    }
    return $request;
}


public function getProductoT(int $idproducto, string $ruta){
    $this->con = new Mysql();
    $this->intIdProducto = $idproducto;
    $this->strRuta = $ruta;
    $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    c.ruta as ruta_categoria,
                    p.precio,
                    p.ruta,
                    p.stock
            FROM producto p 
            INNER JOIN categoria c
            ON p.categoriaid = c.idcategoria
            WHERE p.status = 1 AND p.idproducto = ? AND p.ruta = ? AND p.stock > 0";
    $request = $this->con->select($sql, [$this->intIdProducto, $this->strRuta]);
    if(!empty($request)){
        $intIdProducto = $request['idproducto'];
        $sqlImg = "SELECT img
                FROM imagen
                WHERE productoid = $intIdProducto";
        $arrImg = $this->con->select_all($sqlImg);
        if(count($arrImg) > 0){
            for ($i=0; $i < count($arrImg); $i++) { 
                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
            }
        }else{
            $arrImg[0]['url_image'] = media().'/images/uploads/product.png'; // Asegura tener una imagen por defecto si no hay imágenes.
        }
        $request['images'] = $arrImg;
    }
    return $request;
}


public function getProductosRandom(int $idcategoria, int $cant, string $option){
    $this->intIdcategoria = $idcategoria;
    $this->cant = $cant;
    $this->option = $option;

    if($option == "r"){
        $this->option = " RAND() ";
    } else if($option == "a"){
        $this->option = " idproducto ASC ";
    } else {
        $this->option = " idproducto DESC ";
    }

    $this->con = new Mysql();
    $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    p.precio,
                    p.ruta,
                    p.stock
            FROM producto p 
            INNER JOIN categoria c
            ON p.categoriaid = c.idcategoria
            WHERE p.status = 1 AND p.categoriaid = $idcategoria AND p.stock > 0
            ORDER BY {$this->option} LIMIT {$this->cant}";
    
    $request = $this->con->select_all($sql);
    
    // Verificar si $request es un arreglo válido antes de proceder
    if(is_array($request) && count($request) > 0){
        foreach ($request as &$producto) { 
            $intIdProducto = $producto['idproducto'];
            $sqlImg = "SELECT img
                       FROM imagen
                       WHERE productoid = $intIdProducto";
            $arrImg = $this->con->select_all($sqlImg);
            if(is_array($arrImg) && count($arrImg) > 0){
                foreach ($arrImg as &$img) { 
                    $img['url_image'] = media().'/images/uploads/'.$img['img'];
                }
            }
            $producto['images'] = $arrImg;
        }
    } else {
        // Manejar caso de que no se encontraron productos
        $request = [];
    }
    
    return $request;
}



public function getProductoIDT(int $idproducto){
    $this->con = new Mysql();
    $this->intIdProducto = $idproducto;
    $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    p.precio,
                    p.ruta,
                    p.stock
            FROM producto p 
            INNER JOIN categoria c
            ON p.categoriaid = c.idcategoria
            WHERE p.status = 1 AND p.idproducto = '{$this->intIdProducto}' AND p.stock > 0";
    $request = $this->con->select($sql);
    if(!empty($request)){
        $intIdProducto = $request['idproducto'];
        $sqlImg = "SELECT img
                   FROM imagen
                   WHERE productoid = $intIdProducto";
        $arrImg = $this->con->select_all($sqlImg);
        if(count($arrImg) > 0){
            for ($i=0; $i < count($arrImg); $i++) { 
                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
            }
        }else{
            $arrImg[0]['url_image'] = media().'/images/uploads/product.png';
        }
        $request['images'] = $arrImg;
    }
    return $request;
}

	public function cantProductos($categoria = null){
		$where = "";
		if($categoria != null){
			$where = " AND categoriaid = ".(int)$categoria;
		}
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM producto WHERE status = 1 AND stock > 0".$where;
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;

	}

	public function cantProdSearch($busqueda){
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM producto WHERE nombre LIKE ? AND status = 1 AND stock > 0 ";
		$result_register = $this->con->select($sql, ['%'.$busqueda.'%']);
		$total_registro = $result_register;
		return $total_registro;
	}
	
	public function getProdSearch($busqueda, $desde, $porpagina){
    $this->con = new Mysql();
    // Agregar condición de stock a la consulta SQL
    $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    p.precio,
                    p.ruta,
                    p.stock
            FROM producto p 
            INNER JOIN categoria c ON p.categoriaid = c.idcategoria
            WHERE p.status = 1 AND p.nombre LIKE ? AND p.stock > 0 
            ORDER BY p.idproducto DESC LIMIT ".(int)$desde.",".(int)$porpagina;
    $request = $this->con->select_all($sql, ['%'.$busqueda.'%']);
    if(count($request) > 0){
        for ($c=0; $c < count($request); $c++) { 
            $intIdProducto = $request[$c]['idproducto'];
            $sqlImg = "SELECT img
                       FROM imagen
                       WHERE productoid = $intIdProducto";
            $arrImg = $this->con->select_all($sqlImg);
            if(count($arrImg) > 0){
                for ($i=0; $i < count($arrImg); $i++) { 
                    $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                }
            }
            $request[$c]['images'] = $arrImg;
        }
    }
    return $request;
}

	//---------- Variantes (color, talla, medidas...) ----------
	//Variantes activas de un producto (con o sin stock; las agotadas se muestran tachadas), listas para la ficha (cada una trae su código cifrado para el carrito)
	public function getVariantesT(int $idproducto){
		$this->con = new Mysql();
		$rows = $this->con->select_all("SELECT idvariante, atributos, etiqueta, precio, stock FROM variante WHERE productoid = ? AND status = 1 ORDER BY idvariante", [$idproducto]);
		foreach($rows as $i => $r){
			$rows[$i]['atributos'] = json_decode($r['atributos'], true) ?: [];
			$rows[$i]['idvariante'] = (int)$r['idvariante'];
			$rows[$i]['stock'] = (int)$r['stock'];
			$rows[$i]['precio'] = $r['precio'] === null ? null : (float)$r['precio'];
			$rows[$i]['token'] = tokenItem($idproducto, (int)$r['idvariante']);
		}
		return $rows;
	}
	//Una variante activa de ese producto (o vacío)
	public function getVarianteT(int $idvariante, int $idproducto){
		$this->con = new Mysql();
		$r = $this->con->select("SELECT idvariante, etiqueta, precio, stock FROM variante WHERE idvariante = ? AND productoid = ? AND status = 1", [$idvariante, $idproducto]);
		return $r ?: [];
	}
	//¿El producto maneja variantes? (si es así, hay que elegir una para comprarlo)
	public function tieneVariantesT(int $idproducto){
		$this->con = new Mysql();
		$r = $this->con->select("SELECT COUNT(*) AS n FROM variante WHERE productoid = ?", [$idproducto]);
		return (int)($r['n'] ?? 0) > 0;
	}
}

 ?>
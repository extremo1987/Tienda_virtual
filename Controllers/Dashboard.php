<?php 

	class Dashboard extends Controllers{
		public function __construct()
		{
			parent::__construct();
			startSecureSession();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MDASHBOARD);
		}

		public function dashboard()
		{
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard - M&G Store";
			$data['page_title'] = "Dashboard - M&G Store";
			$data['page_name'] = "dashboard";
			$data['page_functions_js'] = "functions_dashboard.js";
			$data['usuarios'] = $this->model->cantUsuarios();
			$data['clientes'] = $this->model->cantClientes();
			$data['productos'] = $this->model->cantProductos();
			$data['pedidos'] = $this->model->cantPedidos();
			$data['pedidos'] = $this->model->cantPedidos();
			$data['lastOrders'] = $this->model->lastOrders();
			$data['productosTen'] = $this->model->productosTen();

			$anio = date('Y');
			$mes = date('m');
			$data['pagosMes'] = $this->model->selectPagosMes($anio,$mes);
			//dep($data['pagosMes']);exit;
			$data['ventasMDia'] = $this->model->selectVentasMes($anio,$mes);
			//dep($data['ventasMDia']);exit;
			$data['ventasAnio'] = $this->model->selectVentasAnio($anio);
			//dep($data['ventasAnio']);exit;
			if( $_SESSION['userData']['idrol'] == RCLIENTES ){
				$this->views->getView($this,"dashboardCliente",$data);
			}else{
				$this->views->getView($this,"dashboard",$data);
			}
		}

		//Valida "mes-año" (ej. 11-2026): mes 1-12 y año 2000-2100. Devuelve [mes, año] o responde con error.
		private function mesAnioValido(){
			$nFecha = str_replace(" ", "", (string)($_POST['fecha'] ?? ''));
			if(!preg_match('/^(\d{1,2})-(\d{4})$/', $nFecha, $m) || (int)$m[1] < 1 || (int)$m[1] > 12 || (int)$m[2] < 2000 || (int)$m[2] > 2100){
				http_response_code(400); echo json_encode(array('status' => false, 'msg' => 'Fecha no válida.'), JSON_UNESCAPED_UNICODE); die();
			}
			return array((int)$m[1], (int)$m[2]);
		}
		public function tipoPagoMes(){ if($_POST){ $grafica = "tipoPagoMes"; list($mes, $anio) = $this->mesAnioValido();
				$pagos = $this->model->selectPagosMes($anio,$mes);
				$script = getFile("Template/Modals/graficas",$pagos);
				echo $script;
				die();
			}
		}
		public function ventasMes(){ if($_POST){ $grafica = "ventasMes"; list($mes, $anio) = $this->mesAnioValido();
				$pagos = $this->model->selectVentasMes($anio,$mes);
				$script = getFile("Template/Modals/graficas",$pagos);
				echo $script;
				die();
			}
		}
		public function ventasAnio(){
			if($_POST){
				$grafica = "ventasAnio";
				$anio = intval($_POST['anio'] ?? 0); if($anio < 2000 || $anio > 2100){ http_response_code(400); echo json_encode(array('status' => false, 'msg' => 'Año no válido.'), JSON_UNESCAPED_UNICODE); die(); } $pagos = $this->model->selectVentasAnio($anio);
				$script = getFile("Template/Modals/graficas",$pagos);
				echo $script;
				die();
			}
		}

	}
 ?>
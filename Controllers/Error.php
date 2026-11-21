<?php 

	class Errors extends Controllers{
		public function __construct()
		{
			parent::__construct();
		}

		public function notFound()
		{
			http_response_code(404); // página no encontrada: el código HTTP debe ser 404 (antes respondía 200)
			$pageContent = getPageRout('not-found');
			if(empty($pageContent)){
				header("Location: ".base_url());
			}else{
				$data['page_tag'] = NOMBRE_EMPESA;
				$data['page_title'] = NOMBRE_EMPESA." - ".$pageContent['titulo'];
				$data['page_name'] = $pageContent['titulo'];
				$data['page'] = $pageContent;
				$this->views->getView($this,"error",$data);
			}
		}
	}


	$notFound = new Errors();
	$notFound->notFound();
 ?>
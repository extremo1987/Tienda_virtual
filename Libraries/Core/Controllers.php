<?php 
	
	class Controllers
	{
		// Declaradas: PHP 8.2+ marca como obsoleta la creación dinámica de propiedades
		public $views;
		public $model;

		public function __construct()
		{
			$this->views = new Views();
			$this->loadModel();
		}

		public function loadModel()
		{
			//HomeModel.php
			$model = get_class($this)."Model";
			$routClass = "Models/".$model.".php";
			if(file_exists($routClass)){
				require_once($routClass);
				$this->model = new $model();
			}
		}
	}

 ?>
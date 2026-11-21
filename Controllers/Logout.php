<?php
	class Logout
	{
		public function __construct()
		{
			startSecureSession();
			session_unset();
			session_destroy();
			header('location: '.base_url().'/tienda');
			die();
		}
	}
 ?>
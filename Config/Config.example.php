<?php
	// COPIA este archivo como Config.php y pon los datos técnicos de tu servidor. Config.php NO se sube a ningún repositorio.
	// Nombre de la tienda, contacto, redes, correo, PayPal, moneda y portada se editan en el panel: Configuración.

	const BASE_URL = "http://localhost/mgstorehn";

	//Zona horaria
	date_default_timezone_set('America/Tegucigalpa');

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "tienda_virtual";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "utf8";

	const ENVIRONMENT = 1; // Local: 0, Producción: 1;

	//Clave para cifrar (carrito y contraseñas guardadas en el panel). Cámbiala ANTES de instalar y no la cambies después:
	//las contraseñas de correo/PayPal ya guardadas dejarían de poder leerse (habría que escribirlas otra vez en el panel).
	const KEY = "CAMBIA-ESTA-CLAVE";
	const METHODENCRIPT = "AES-128-ECB";

	//Módulos
	const MDASHBOARD = 1;
	const MUSUARIOS = 2;
	const MCLIENTES = 3;
	const MPRODUCTOS = 4;
	const MPEDIDOS = 5;
	const MCATEGORIAS = 6;
	const MSUSCRIPTORES = 7;
	const MDCONTACTOS = 8;
	const MDPAGINAS = 9;
	const MCONFIGURACION = 10;

	//Páginas
	const PINICIO = 1;
	const PTIENDA = 2;
	const PCARRITO = 3;
	const PNOSOTROS = 4;
	const PCONTACTO = 5;
	const PPREGUNTAS = 6;
	const PTERMINOS = 7;
	const PSUCURSALES = 8;
	const PERROR = 9;

	//Roles
	const RADMINISTRADOR = 1;
	const RSUPERVISOR = 2;
	const RCLIENTES = 3;

	const STATUS = array('Completo','Aprobado','Cancelado','Reembolsado','Pendiente','Entregado');

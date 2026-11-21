
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `idcategoria` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `portada` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ruta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Hombre','Artículos de moda','img_b368bb7b227c9e5f7fb9f2e079d16b9f.jpg','2021-08-20 03:04:04','hombre',1),(2,'Audio y Videojuegos','Lo mejor en tecnología','img_df2e12f4e57c86cb7ed96dd83506fa22.jpg','2021-08-21 00:47:10','audio-y-videojuegos',0),(3,'Mujer','Artículos de moda','img_7d22e728e004253c4a2057fd300065ae.jpg','2023-05-24 23:02:00','mujer',1),(4,'Herramientas y Accesorios','Lo mejor en herramientas y accesorios','img_112434babed3c324cc651427f307cca4.jpg','2024-03-23 18:11:43','herramientas-y-accesorios',1),(5,'Tecnologia y Accesorios','Lo mejor en tecnología','img_021809d8ad0c6284565ac32c795cec68.jpg','2024-03-23 18:52:27','tecnologia-y-accesorios',1),(6,'Hogar','Lo mejor para el hogar','img_46814b8e0c9ea8e35b08f9183c7131b7.jpg','2024-03-23 21:26:28','hogar',1),(7,'Cocina','Lo mejor para la cocina','img_3a10926b9c15c5ddce1065801584f431.jpg','2024-03-23 21:29:19','cocina',1),(8,'Juegos y accesorios','Lo mejor para el entretenimiento','img_0052f2aa8c92a972bf57bd47c71b5956.jpg','2024-03-27 13:12:40','juegos-y-accesorios',1),(9,'Moda Infantil','Lo mejor para los pequeños del hogar.','img_a398011daef3f6b85d794e12fe8d1188.jpg','2024-03-31 18:47:51','moda-infantil',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion` (
  `clave` varchar(60) NOT NULL,
  `valor` text,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacto` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `dispositivo` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `useragent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
INSERT INTO `contacto` VALUES (64,'Ana Martínez','ana.martinez@ejemplo.com','Hola, ¿tienen la camiseta rosa en talla M? ¿Hacen envíos a San Pedro Sula?','203.0.113.10','Movil','Ejemplo','2026-11-18 09:09:47'),(65,'Carlos Mejía','carlos.mejia@ejemplo.com','Buenas tardes, quisiera saber si puedo pagar por transferencia y a qué cuenta.','203.0.113.11','PC','Ejemplo','2026-11-13 09:09:47'),(66,'Lucía Fernández','lucia.fernandez@ejemplo.com','Compré la semana pasada y quiero cambiar la talla de una camiseta. ¿Cómo hago?','203.0.113.12','Movil','Ejemplo','2026-11-07 09:09:47'),(67,'Marcos Villeda','marcos.villeda@ejemplo.com','¿Van a volver a tener las chanclas talla 42? Gracias.','203.0.113.13','PC','Ejemplo','2026-11-01 09:09:47');
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `detalle_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_pedido` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pedidoid` bigint NOT NULL,
  `productoid` bigint NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `cantidad` int NOT NULL,
  `varianteid` bigint DEFAULT NULL,
  `variante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidoid` (`pedidoid`),
  KEY `productoid` (`productoid`),
  CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedidoid`) REFERENCES `pedido` (`idpedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`productoid`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=588 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `detalle_pedido` WRITE;
/*!40000 ALTER TABLE `detalle_pedido` DISABLE KEYS */;
INSERT INTO `detalle_pedido` VALUES (572,359,383,250.00,1,112,'Negro / M'),(573,360,381,220.00,1,145,'Gris / 10'),(574,361,382,250.00,1,166,'Blanco / S'),(575,362,384,220.00,2,124,'Gris / M'),(576,363,250,250.00,1,177,'L'),(577,363,125,250.00,1,171,'M'),(578,364,414,200.00,1,NULL,NULL),(579,365,382,250.00,1,164,'Negro / L'),(580,365,381,220.00,2,154,'Blanco / 8'),(581,366,262,250.00,1,181,'M'),(582,367,218,160.00,1,197,'40-41'),(583,368,383,250.00,2,115,'Rosa / S'),(584,369,39,300.00,1,186,'M'),(585,370,384,220.00,1,141,'Verde menta / L'),(586,370,185,35.00,2,NULL,NULL),(587,371,125,250.00,2,172,'L');
/*!40000 ALTER TABLE `detalle_pedido` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `detalle_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_temp` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `personaid` bigint NOT NULL,
  `productoid` bigint NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `cantidad` int NOT NULL,
  `transaccionid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `varianteid` bigint DEFAULT NULL,
  `variante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productoid` (`productoid`),
  KEY `personaid` (`personaid`),
  CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`productoid`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `detalle_temp` WRITE;
/*!40000 ALTER TABLE `detalle_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_temp` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `entradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entradas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idproducto` bigint NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cantidad` int NOT NULL,
  `compra` decimal(11,2) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `entradas` WRITE;
/*!40000 ALTER TABLE `entradas` DISABLE KEYS */;
/*!40000 ALTER TABLE `entradas` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagen` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `productoid` bigint NOT NULL,
  `img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productoid` (`productoid`),
  CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`productoid`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `imagen` WRITE;
/*!40000 ALTER TABLE `imagen` DISABLE KEYS */;
INSERT INTO `imagen` VALUES (86,19,'pro_77d73cacfb06370002f6865d0471767f.jpg'),(87,19,'pro_39cff0cf086c3f466a7847c23495cdf7.jpg'),(88,19,'pro_bcebabcd505575b3f5e25b1bb7d25230.jpg'),(89,19,'pro_8764cd61259279423c9eb551ea913931.jpg'),(90,19,'pro_41b52813b08cabe9d4f1e12f3af1d94c.jpg'),(91,19,'pro_6614258f556b6ac02479ee28eff87a13.jpg'),(165,39,'pro_3c203da0062ea2f3916072f471ab6882.jpg'),(166,39,'pro_626af5d6252c1098ea2a836654a13aeb.jpg'),(167,39,'pro_45ecb7d1ccc91e231595b46a6f43ea64.jpg'),(168,39,'pro_32b03ebcc13b584bc951c87720e5f496.jpg'),(169,39,'pro_beef3314f43dad61df02e52d66a4dfcb.jpg'),(381,86,'pro_479a59f00c7e047069a28c44dec2b976.jpg'),(382,86,'pro_29fdd1869098c327ee0325edb57759a6.jpg'),(383,86,'pro_fd6a546d8b167a8b2c5d51a7dde974fc.jpg'),(384,86,'pro_6ac00a622f4f8fb98df27c827e3f3c59.jpg'),(385,86,'pro_825bb001c06810db49503d171ceed268.jpg'),(462,106,'pro_20d573715e678c054146f0dd3f94ce0a.jpg'),(463,106,'pro_1d77316d88553120236c7bcf626bbe3d.jpg'),(464,106,'pro_bae48b41113bf45f0332a92fa5706ac5.jpg'),(465,106,'pro_6e8ff8d1e084415ca5157aa6a2e1769f.jpg'),(617,142,'pro_bab06a27f942e2ae9f2ba8ba75bb692b.jpg'),(618,142,'pro_04c72855cef0c88b22f1de046daea5dd.jpg'),(619,142,'pro_c32c51736308c8f568a0280b50f513cb.jpg'),(620,142,'pro_9974c9fcdfcf842bc0e9cd34675ae858.jpg'),(621,142,'pro_86b212809eb35e3b1c2a31a77c92ba0e.jpg'),(837,185,'pro_55f7c3cf9d96687a8aec294073cc09fd.jpg'),(838,185,'pro_4be3fcfb4c789e17ab384a3312453479.jpg'),(839,185,'pro_5dd11e63b56515cc04d37b61ba350a20.jpg'),(840,185,'pro_c714618a69d1478f628fc1523e94f7c8.jpg'),(841,185,'pro_84ed477e53ef371618d0740488380e73.jpg'),(997,218,'pro_8824400cd540dba614b680821d9b9b4f.jpg'),(998,218,'pro_3247605a3e9130888c6b7f3b88e4d2fd.jpg'),(1025,225,'pro_5fc7a424ec703f8f9890ea288ffe80dd.jpg'),(1026,225,'pro_9f288cc77786b1229e438019c1b99021.jpg'),(1027,225,'pro_f656b706ab4b3c0d1b760165a4ab727b.jpg'),(1028,225,'pro_de0306da3eb92c72e3c0144e3bf33969.jpg'),(1029,225,'pro_cefe08f088b67162f834640440b9a90b.jpg'),(1030,225,'pro_d280f5a545772980d7a3dc16bf1908f7.jpg'),(1038,227,'pro_e45c693951858104cb94b37c1d492c6a.jpg'),(1039,227,'pro_215a522094e2de20a5211d71457779b0.jpg'),(1040,227,'pro_957b2a22af135c41a83efce3428abbf9.jpg'),(1041,227,'pro_6cdec9eb2e8646cc7d85371f8d4c2303.jpg'),(1042,227,'pro_618f46abd9ab02dd698eb0500ab23c3b.jpg'),(1043,228,'pro_645bd9eff018b443d653efcac4a765a9.jpg'),(1044,228,'pro_79e8349a8fe3f517f74a9122b9327326.jpg'),(1045,228,'pro_aad92e8e3e927d973dd6e55314bc93cd.jpg'),(1046,228,'pro_a0761e48acbd43845e47b86d1bff3583.jpg'),(1047,228,'pro_2b148cfe74b11994230a4c10e131ffc5.jpg'),(1048,228,'pro_acaae93c16ee67bd353a3eb238233bb0.jpg'),(1069,233,'pro_bb38817a754681c3a7838074bc4ccd59.jpg'),(1070,233,'pro_8a450051688abf6229bb24088bf78739.jpg'),(1072,233,'pro_cf7ddcee5a9eb4c594f9a3161c332a20.jpg'),(1094,237,'pro_437f1335343dd9117852248906ffa38f.jpg'),(1095,237,'pro_bae8b5cd5a74a519ec75eb1378495dea.jpg'),(1096,237,'pro_6e647ff1011c81352e0bc7e200d2faf6.jpg'),(1097,237,'pro_495ef6cad3367b3d3ea7aac59ee7b468.jpg'),(1098,237,'pro_d770f2a217e8102d2aacd7c09fe704fe.jpg'),(1099,237,'pro_4b9f7bd4b09ad97fb65582e4b9eb2d2c.jpg'),(1100,237,'pro_913420789a01f36da7300a7ae16a2d11.jpg'),(1109,233,'pro_d0efe7894d04962794d63dfa71329935.jpg'),(1110,233,'pro_b341269a40a9fd26501d61974f64aff1.jpg'),(1195,250,'pro_8793967c6da473ba62ce8ae2c3cda55d.jpg'),(1196,250,'pro_5140c78f4cf40992a8460aa3f32f836d.jpg'),(1197,250,'pro_0e0841617da4ced7bf0e8613907340be.jpg'),(1198,250,'pro_2d908cebdf44c29a13996abf271ad1c7.jpg'),(1199,250,'pro_0b050229cf317364a79cdc7e658278d5.jpg'),(1218,254,'pro_eec3e94d2b80e84035b516216099df50.jpg'),(1219,254,'pro_78fadcd7806f35abf87f763c7686ed4b.jpg'),(1220,254,'pro_d94137c0fd6cb64d1f73cf84e12cd934.jpg'),(1221,254,'pro_c973a285afd0c87eba3bd7ee95f3aa24.jpg'),(1222,254,'pro_40c1f67036775ec14606c1a93fd25879.jpg'),(1266,262,'pro_79896c08b067b691b7b69bd638314d5b.jpg'),(1267,262,'pro_78ff436ca328dcf1b755d4bfc552fe74.jpg'),(1268,262,'pro_79249d17da75993cc60ce7d7f8c97fc6.jpg'),(1269,262,'pro_4e54f83c0cdc1ec2cc90c21c3bc199fb.jpg'),(1346,280,'pro_3e4cd82aab4b7280ffb254a1b8c136db.jpg'),(1347,280,'pro_b8612130aec36d1192e5ab8b68693c5f.jpg'),(1348,280,'pro_67a244a7079576f42e46f5e1ea53c96f.jpg'),(1349,280,'pro_c764f3cfc5540d6eeae21482a2c1b4fe.jpg'),(1417,293,'pro_3188bc927c079b037fe726b9a0c3f733.jpg'),(1418,293,'pro_d1f02909252fc19013e05cf3ee6dc05a.jpg'),(1419,293,'pro_d5e8d9d591863a29968c6a655af99ca9.jpg'),(1420,293,'pro_3bac5c53b7a67884c15ca92f982c0dc8.jpg'),(1421,293,'pro_d80017c028d9d51353353465b3157ce8.jpg'),(1422,293,'pro_56438f7eb0338bfcd6d22643e01562b6.jpg'),(1423,293,'pro_b408db345aab0e0f33b7a8765284e9fc.jpg'),(1424,293,'pro_3e0dba46b8ec62f02a299609f5cd67e0.jpg'),(1451,125,'pro_38797773b3c05c89a7bfd41e30836e8c.jpg'),(1458,125,'pro_a830ad464ab789b931984318d70825bb.jpg'),(1459,125,'pro_06483b677f9a7279ca7b64fc5ff197fd.jpg'),(1514,302,'pro_40ff22674d5ee9132b7c682940a88298.jpg'),(1515,302,'pro_7cd895f90c5fdc42bc6b6d5078791575.jpg'),(1516,302,'pro_0615260c07904b674740d5c4c1fc17a8.jpg'),(1517,302,'pro_5778ec3cba60a7d85edcd63dc2d44fef.jpg'),(1518,302,'pro_7f7ae551933c858d8423691a362c3ca6.jpg'),(1519,303,'pro_fad6003db46080971c9cb17dfe3495f3.jpg'),(1520,303,'pro_9978a4554c7647b06bfe08a3dec3b8d2.jpg'),(1521,303,'pro_b6fd9bf9e4f71267adae1cc6c260d170.jpg'),(1522,303,'pro_07e0786ebe328cce8ff365a778e5f89b.jpg'),(1523,303,'pro_e1fb44e3a9a62e2877d10583fb232dc0.jpg'),(1524,303,'pro_e4a3f9090027058b614413c838212732.jpg'),(1868,364,'pro_5a4cf7eeb19d9c3721b663fb3c083506.jpg'),(1869,364,'pro_c12d7c4d2d53608ae089703eab5464f3.jpg'),(1870,364,'pro_f67dc468c60a121918bff1f1ebefefd1.jpg'),(1871,364,'pro_ccca37066bdf82338792f15cde1a6c7f.jpg'),(1904,371,'pro_2d47276bc05a6ffe2c9b2fcd898cb9f7.jpg'),(1905,371,'pro_d8e1e764a52024aa1eb4e5c3949f264a.jpg'),(1906,371,'pro_7371f9074a3f143c75f1b5088a926025.jpg'),(1907,371,'pro_c3725bc4133d9490b9b0e68dc7399df9.jpg'),(1908,371,'pro_a1925dbdfa6ca3c8009caf6017ae3bae.jpg'),(1909,371,'pro_7248127032433dae716f4a067bdbe71a.jpg'),(1910,371,'pro_5d19b2ab7a4252755faa412003d833ca.jpg'),(1911,371,'pro_3c27811dfd0cdefb3d26d5b2a0882fdc.jpg'),(1912,372,'pro_9a0306f5ecf19c918b3a9b779389870c.jpg'),(1913,372,'pro_4433163e822d92716d8e4a64a779debf.jpg'),(1914,372,'pro_f40db9cbe23cd783f0164c3696253c1c.jpg'),(1915,372,'pro_be8b4cfdf55dfb3ec0da73b4277dee5e.jpg'),(1916,372,'pro_b2c66485992f2cab77593950f1b6bec7.jpg'),(1917,372,'pro_54f615f64490c1fb34ce56f018a4c13f.jpg'),(1964,381,'pro_23611b5c859094516f97638439f84e4b.jpg'),(1965,381,'pro_b94337672fd92aca3d6165c6f46bbac7.jpg'),(1966,381,'pro_f7993709120f93531601bd865048f959.jpg'),(1967,381,'pro_7cd4ccdcc028060b8eae68851b2a6619.jpg'),(1968,382,'pro_0181ed6e564381a83cf56478dfa9c219.jpg'),(1969,382,'pro_d2318f6843cad398ec52a1087eaccf69.jpg'),(1970,382,'pro_df8040b16983823c602286921d8af6b8.jpg'),(1971,382,'pro_a0f9d3962aa0c688d75d7004248e854a.jpg'),(1972,382,'pro_9318182313dce494b8526766afb5447a.jpg'),(1973,383,'pro_8aa028ca3eb153cd657cd110a631f105.jpg'),(1974,383,'pro_089b4bd3123b7d7a540995396a6ac04a.jpg'),(1975,383,'pro_595763b92553ade679ad2bdb90024122.jpg'),(1976,383,'pro_e138670f7760af521a15e8287a3c34d0.jpg'),(1977,383,'pro_c81f572f548244e12e0e50c6daaf967e.jpg'),(1978,384,'pro_e8ea3a2b7adfa0d9fdf6e484bae87c63.jpg'),(1979,384,'pro_472b85b6d7b00549bf350d902ab8156f.jpg'),(1980,384,'pro_a0361ee50bbe6fcef1f741be8f4ae6e0.jpg'),(1981,384,'pro_383f7f251f26ad6b5d2c74dc2485fe9f.jpg'),(1982,384,'pro_69913d340b65e54bbb36d21628c2f640.jpg'),(1988,386,'pro_7ae2ccdb78a555634e35927ad93f2328.jpg'),(1989,386,'pro_cce3419862be38bc75a857169bcc3009.jpg'),(1990,386,'pro_e620aec66272fbb1d24f5adcb16fb7eb.jpg'),(1991,386,'pro_d7c239b8ef1ac43c31bd3061f782b5e9.jpg'),(2005,389,'pro_fa22f08a6501d6df4e92490d36b6ce59.jpg'),(2006,389,'pro_7129694327d269a098e8b532682c7e11.jpg'),(2007,389,'pro_c5fb9071696946321b58201682957951.jpg'),(2008,389,'pro_2c433068a4bf4ee87b58878f93faa2f1.jpg'),(2009,389,'pro_ab32ca1b8f47c20cc6bbcd623b1f56e7.jpg'),(2010,389,'pro_0b50b7f082e461d506c67ead4f3e5a3f.jpg'),(2011,390,'pro_0e7f35a9b9cda154bd7bd6242547fd25.jpg'),(2012,390,'pro_c6ade784f786f42fa27cc8137f53044a.jpg'),(2013,390,'pro_3576ebc31f88c22abec4199536973fe6.jpg'),(2014,391,'pro_24f0b3892d3923c3cbae21b6f296da98.jpg'),(2015,391,'pro_88cc2b89b1a486559523753a4a51ddbe.jpg'),(2016,391,'pro_4d38b77148206ad9bedd472e1cacaa93.jpg'),(2017,391,'pro_6291730c7b8695b3be1d40286d7199a0.jpg'),(2018,391,'pro_6f067f74097a0ae0479de897828a67a7.jpg'),(2019,391,'pro_9bb0dd80e8fb817295ff28ce8a03f811.jpg'),(2020,391,'pro_a0bf5a408df2b05c1434d3a9f53095ad.jpg'),(2036,394,'pro_45ba05c756c6312135732f6300971994.jpg'),(2037,394,'pro_74d75d48e455444cba871026ab473665.jpg'),(2038,394,'pro_4873cc41c6b34c96d4debaaff08c692b.jpg'),(2039,394,'pro_196bcfcbbfb426123096386eba474f03.jpg'),(2040,394,'pro_c2e167a18cb7aec91327aaaf66d8a688.jpg'),(2041,394,'pro_758105bde9e0a50efa97dc5741330a74.jpg'),(2065,399,'pro_39931a692d1f8a1d68e4c5a3e661c014.jpg'),(2066,399,'pro_eefd957dd302bad8ce4681efd3964503.jpg'),(2067,399,'pro_d9029c451eb46bf76bb912951850a4e2.jpg'),(2068,399,'pro_11ba5ec8c2edf596ad31c2e757894c98.jpg'),(2069,399,'pro_541bf9c0dda8737b7fffb3614469eef9.jpg'),(2070,399,'pro_925cb174d5a9eff9ae32dcd2b23b74d2.jpg'),(2107,407,'pro_3bc4e56a81b2713843e44adaea8f00e3.jpg'),(2108,407,'pro_f8d202e9252eb931c98bebde203522c5.jpg'),(2109,407,'pro_10bdc2703ca6c95f76f7b9779dd33178.jpg'),(2110,407,'pro_b8989c115baddd3d0225df14ce652f5b.jpg'),(2111,407,'pro_5855f875a4d221eb1cf3891e8a13879b.jpg'),(2127,410,'pro_f162662614b63eb1da9ac360ff61407a.jpg'),(2128,410,'pro_78c90d97903f1a111e6aaba82c14f9ae.jpg'),(2129,410,'pro_f48da673effbe062a575ff8305f0ce51.jpg'),(2130,410,'pro_a07a21c3d57027aa6e03a7026b34496a.jpg'),(2131,410,'pro_0ef68b20aa6ac876bb0fe460aab2cf45.jpg'),(2132,410,'pro_48d6161980e2d7c55d6cf815ca6a8d9b.jpg'),(2133,410,'pro_3b66d66162d5b748f1606c4f0d753a15.jpg'),(2134,411,'pro_1dd73481f640b00021d6386a43679c17.jpg'),(2135,411,'pro_0d71806cc722d511d3b2cebaeeb55494.jpg'),(2136,411,'pro_6d239ae7444e6ec6b3b33c8014d43777.jpg'),(2137,411,'pro_c79f13df7c1bede9317b93ce3d37ca9c.jpg'),(2138,411,'pro_3ba5c1f4c09532e4f8193ef4608f4a8a.jpg'),(2139,411,'pro_59174b4928308edc2a5dc4bc38f626c3.jpg'),(2140,411,'pro_7804bb2b0475b90b5e0f2845db8aa7e4.jpg'),(2153,414,'pro_eb3f92677d9c9e0b2e8ae5b2c4f33feb.jpg'),(2154,414,'pro_6022362b14936785e0a4125751077c3e.jpg'),(2155,414,'pro_7e7a829657604d21958f43c2b47801a9.jpg'),(2156,414,'pro_dd57eef783575ed610fc82d0b05a924d.jpg'),(2157,414,'pro_b50d38633ac9196f42d7fb0b3a931fc9.jpg'),(2158,414,'pro_7d9045fbd4113f979960a18a2c39d654.jpg'),(2159,414,'pro_878c75195f59591aff52f9629cf61678.jpg');
/*!40000 ALTER TABLE `imagen` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulo` (
  `idmodulo` bigint NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idmodulo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `modulo` WRITE;
/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` VALUES (1,'Dashboard','Dashboard',1),(2,'Usuarios','Usuarios del sistema',1),(3,'Clientes','Clientes de tienda',1),(4,'Productos','Todos los productos',1),(5,'Pedidos','Pedidos',1),(6,'Caterogías','Caterogías Productos',1),(7,'Suscriptores','Suscriptores del sitio web',1),(8,'Contactos','Mensajes del formulario contacto',1),(9,'Páginas','Páginas del sitio web',1),(10,'Configuración','Ajustes de la tienda',1);
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `idpedido` bigint NOT NULL AUTO_INCREMENT,
  `referenciacobro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `idtransaccionpaypal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `datospaypal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci,
  `personaid` bigint NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `costo_envio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `monto` decimal(11,2) NOT NULL,
  `tipopagoid` bigint NOT NULL,
  `direccion_envio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`idpedido`),
  KEY `personaid` (`personaid`),
  KEY `tipopagoid` (`tipopagoid`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`personaid`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`tipopagoid`) REFERENCES `tipopago` (`idtipopago`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=372 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (359,NULL,NULL,NULL,31,'2026-11-21 09:09:47',0.00,250.00,2,'Col. Las Colinas, casa 12, Tegucigalpa','Pendiente'),(360,NULL,NULL,NULL,32,'2026-11-20 08:32:47',0.00,220.00,3,'Barrio El Centro, calle 3, Tegucigalpa','Aprobado'),(361,NULL,NULL,NULL,34,'2026-11-19 07:55:47',0.00,250.00,2,'Col. Kennedy, sector 2, Tegucigalpa','Pendiente'),(362,NULL,NULL,NULL,32,'2026-11-17 07:18:47',0.00,440.00,3,'Barrio El Centro, calle 3, Tegucigalpa','Completo'),(363,NULL,NULL,NULL,33,'2026-11-15 06:41:47',0.00,500.00,2,'Res. Los Pinos, bloque B, Tegucigalpa','Entregado'),(364,NULL,NULL,NULL,34,'2026-11-12 06:04:47',0.00,200.00,2,'Col. Kennedy, sector 2, Tegucigalpa','Completo'),(365,NULL,NULL,NULL,35,'2026-11-09 05:27:47',0.00,690.00,3,'Bo. Guamilito, av. 5, Tegucigalpa','Completo'),(366,NULL,NULL,NULL,36,'2026-11-06 04:50:47',0.00,250.00,2,'Col. Miraflores, casa 7, Tegucigalpa','Cancelado'),(367,NULL,NULL,NULL,32,'2026-10-24 03:36:47',0.00,160.00,3,'Barrio El Centro, calle 3, Tegucigalpa','Reembolsado'),(368,NULL,NULL,NULL,33,'2026-10-17 02:59:47',0.00,500.00,2,'Res. Los Pinos, bloque B, Tegucigalpa','Completo'),(369,NULL,NULL,NULL,34,'2026-10-08 02:22:47',0.00,300.00,3,'Col. Kennedy, sector 2, Tegucigalpa','Completo'),(370,NULL,NULL,NULL,35,'2026-09-30 01:45:47',0.00,290.00,2,'Bo. Guamilito, av. 5, Tegucigalpa','Entregado'),(371,NULL,NULL,NULL,31,'2026-09-07 00:31:47',0.00,500.00,3,'Col. Las Colinas, casa 12, Tegucigalpa','Completo');
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `ActualizarStock` AFTER UPDATE ON `pedido` FOR EACH ROW BEGIN
    IF NEW.status = 'completo' AND OLD.status <> 'completo' THEN
        UPDATE producto p
        JOIN (SELECT productoid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido GROUP BY productoid) AS dp
          ON p.idproducto = dp.productoid
        SET p.stock = p.stock - dp.total_cantidad;
        UPDATE variante v
        JOIN (SELECT varianteid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido AND varianteid IS NOT NULL GROUP BY varianteid) AS dv
          ON v.idvariante = dv.varianteid
        SET v.stock = v.stock - dv.total_cantidad;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `DevolverStock` AFTER UPDATE ON `pedido` FOR EACH ROW BEGIN
    IF NEW.status = 'Reembolsado' AND OLD.status <> 'Reembolsado' THEN
        UPDATE producto p
        JOIN (SELECT productoid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido GROUP BY productoid) AS dp
          ON p.idproducto = dp.productoid
        SET p.stock = p.stock + dp.total_cantidad;
        UPDATE variante v
        JOIN (SELECT varianteid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido AND varianteid IS NOT NULL GROUP BY varianteid) AS dv
          ON v.idvariante = dv.varianteid
        SET v.stock = v.stock + dv.total_cantidad;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `idpermiso` bigint NOT NULL AUTO_INCREMENT,
  `rolid` bigint NOT NULL,
  `moduloid` bigint NOT NULL,
  `r` int NOT NULL DEFAULT '0',
  `w` int NOT NULL DEFAULT '0',
  `u` int NOT NULL DEFAULT '0',
  `d` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idpermiso`),
  KEY `rolid` (`rolid`),
  KEY `moduloid` (`moduloid`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`moduloid`) REFERENCES `modulo` (`idmodulo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (12,2,1,1,1,1,1),(13,2,2,0,0,0,0),(14,2,3,1,1,1,0),(15,2,4,1,1,1,0),(16,2,5,1,1,1,0),(17,2,6,1,1,1,0),(18,2,7,1,0,0,0),(19,2,8,1,0,0,0),(20,2,9,1,1,1,1),(21,3,1,0,0,0,0),(22,3,2,0,0,0,0),(23,3,3,0,0,0,0),(24,3,4,0,0,0,0),(25,3,5,1,0,0,0),(26,3,6,0,0,0,0),(27,3,7,0,0,0,0),(28,3,8,0,0,0,0),(29,3,9,0,0,0,0),(30,4,1,1,0,0,0),(31,4,2,0,0,0,0),(32,4,3,1,1,1,0),(33,4,4,1,0,0,0),(34,4,5,1,0,1,0),(35,4,6,0,0,0,0),(36,4,7,1,0,0,0),(37,4,8,1,0,0,0),(38,4,9,0,0,0,0),(48,1,1,1,1,1,1),(49,1,2,1,1,1,1),(50,1,3,1,1,1,1),(51,1,4,1,1,1,1),(52,1,5,1,1,1,1),(53,1,6,1,1,1,1),(54,1,7,1,1,1,1),(55,1,8,1,1,1,1),(56,1,9,1,1,1,1),(57,1,10,1,1,1,1);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `idpersona` bigint NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `nombres` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `telefono` bigint NOT NULL,
  `email_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `nit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `nombrefiscal` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `direccionfiscal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `rolid` bigint NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idpersona`),
  KEY `rolid` (`rolid`),
  CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (24,'0000','Admin','Local',0,'admin@local.test','$2y$10$.bAgnbWADCaglsEIcig19OWdjUEINhxFIu74oZ7A5RKgOkReiEJbG',NULL,NULL,NULL,NULL,1,'2026-11-21 03:03:36',1),(31,'0801-0000-99990001','Ana','Martínez',99990001,'ana.martinez@ejemplo.com','$2y$10$R5BhHju/0vFdWOSajJiITOAuhjPECTyYY2D/79RoRAK8myaMgV3dy','CF','Ana Martínez','Col. Las Colinas, casa 12',NULL,3,'2026-11-21 09:09:47',1),(32,'0801-0000-99990002','Carlos','Mejía',99990002,'carlos.mejia@ejemplo.com','$2y$10$R5BhHju/0vFdWOSajJiITOAuhjPECTyYY2D/79RoRAK8myaMgV3dy','CF','Carlos Mejía','Barrio El Centro, calle 3',NULL,3,'2026-11-21 09:09:47',1),(33,'0801-0000-99990003','Lucía','Fernández',99990003,'lucia.fernandez@ejemplo.com','$2y$10$R5BhHju/0vFdWOSajJiITOAuhjPECTyYY2D/79RoRAK8myaMgV3dy','CF','Lucía Fernández','Res. Los Pinos, bloque B',NULL,3,'2026-11-21 09:09:47',1),(34,'0801-0000-99990004','José','Ramírez',99990004,'jose.ramirez@ejemplo.com','$2y$10$R5BhHju/0vFdWOSajJiITOAuhjPECTyYY2D/79RoRAK8myaMgV3dy','CF','José Ramírez','Col. Kennedy, sector 2',NULL,3,'2026-11-21 09:09:47',1),(35,'0801-0000-99990005','Daniela','Castro',99990005,'daniela.castro@ejemplo.com','$2y$10$R5BhHju/0vFdWOSajJiITOAuhjPECTyYY2D/79RoRAK8myaMgV3dy','CF','Daniela Castro','Bo. Guamilito, av. 5',NULL,3,'2026-11-21 09:09:47',1),(36,'0801-0000-99990006','Marcos','Villeda',99990006,'marcos.villeda@ejemplo.com','$2y$10$R5BhHju/0vFdWOSajJiITOAuhjPECTyYY2D/79RoRAK8myaMgV3dy','CF','Marcos Villeda','Col. Miraflores, casa 7',NULL,3,'2026-11-21 09:09:47',1);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `idpost` bigint NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `contenido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `portada` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `datecreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ruta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idpost`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'Inicio','<div class=\"p-t-80\"> <h3 class=\"ltext-103 cl5\">Nuestros Mejores Productos</h3> </div> <div> <p>Trabajamos con las mejores marcas del mundo ...</p> </div> <div class=\"row\"> <div class=\"col-md-3\">&nbsp;</div> <div class=\"col-md-3\">&nbsp;</div> <div class=\"col-md-3\">&nbsp;</div> <div class=\"col-md-3\">&nbsp;</div> </div>','','2021-07-20 02:40:15','inicio',1),(2,'Tienda','<p>Contenido p&aacute;gina!</p>','','2021-08-06 01:21:27','tienda',1),(3,'Carrito','<p>Contenido p&aacute;gina!</p>','','2021-08-06 01:21:52','carrito',1),(4,'Nosotros','<section class=\"bg0 p-t-75 p-b-120\"> <div class=\"container\"> <div class=\"row p-b-148\"> <div class=\"col-md-7 col-lg-8\"> <div class=\"p-t-7 p-r-85 p-r-15-lg p-r-0-md\"> <h1 class=\"mtext-111 cl2 p-b-16\"><span style=\"color: #3598db;\">Historia</span></h1> <p>En el coraz&oacute;n de la ciudad que nunca duerme, naci&oacute; un concepto revolucionario que transformar&iacute;a la manera en que las personas compran tecnolog&iacute;a, art&iacute;culos para el hogar, herramientas y moda. Esta es la historia de M&amp;G Store - un emporio digital donde la innovaci&oacute;n y la calidad se encuentran al alcance de todos.</p> <p>Desde su creaci&oacute;n, M&amp;G Store se ha dedicado a democratizar el acceso a los productos m&aacute;s innovadores del mercado. Con un enfoque en la excelencia, cada art&iacute;culo en nuestro cat&aacute;logo ha sido cuidadosamente seleccionado para asegurar que cumple con nuestros altos est&aacute;ndares de calidad, funcionalidad y dise&ntilde;o.</p> <p>La clave de nuestro &eacute;xito ha sido siempre escuchar a nuestros clientes. Entendemos que detr&aacute;s de cada b&uacute;squeda hay una necesidad, una aspiraci&oacute;n o un sue&ntilde;o esperando ser cumplido. Por eso, en M&amp;G Store, cada opini&oacute;n cuenta y cada sugerencia es una oportunidad para mejorar y expandir nuestro horizonte.</p> <p>Nuestra promesa es mantenernos siempre a la vanguardia, anticipando las tendencias y evolucionando con el mercado para traer a tu hogar lo &uacute;ltimo y lo mejor. Estamos comprometidos a ser tu primera opci&oacute;n, garantizando una selecci&oacute;n de productos que no solo cumplan con tus expectativas sino que las superen.</p> <p>&iquest;Tienes preguntas o necesitas asesoramiento? estamos aqu&iacute; para ayudarte a descubrir, explorar y disfrutar del mundo moderno. Bienvenido a la revoluci&oacute;n de la compra inteligente. Bienvenido a M&amp;G Store.</p> </div> </div> <div class=\"col-11 col-md-5 col-lg-4 m-lr-auto\"> <div class=\"how-bor1 \"> <div class=\"hov-img0\"><img src=\"https://cdn.pixabay.com/photo/2015/07/17/22/43/student-849825_1280.jpg\" alt=\"IMG\" width=\"500\" height=\"333\" /></div> </div> </div> </div> <div class=\"row\"> <div class=\"order-md-2 col-md-7 col-lg-8 p-b-30\"> <div class=\"p-t-7 p-l-85 p-l-15-lg p-l-0-md\"> <h2 class=\"mtext-111 cl2 p-b-16\"><span style=\"color: #236fa1;\">Nuestra Misi&oacute;n</span></h2> <p class=\"stext-113 cl6 p-b-26\">En M&amp;G Store, nuestra misi&oacute;n es simplificar tu vida a trav&eacute;s de la innovaci&oacute;n y la calidad. Nos esforzamos por ser el puente que conecta tus necesidades diarias con soluciones tecnol&oacute;gicas, art&iacute;culos para el hogar, herramientas esenciales y moda vanguardista, todo en un solo lugar. Nos dedicamos a ofrecerte una experiencia de compra excepcional, donde la excelencia y la satisfacci&oacute;n del cliente son nuestro norte. En cada producto que seleccionamos y en cada servicio que ofrecemos, buscamos enriquecer tu vida, facilitar tus d&iacute;as y empoderarte para que vivas tu mejor versi&oacute;n. Esta es nuestra misi&oacute;n, tu bienestar es nuestra pasi&oacute;n.</p> </div> </div> <div class=\"order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30\"> <div class=\"how-bor2\"> <div class=\"hov-img0\"><img src=\"https://cdn.pixabay.com/photo/2015/07/17/22/43/student-849822_1280.jpg\" alt=\"IMG\" width=\"500\" height=\"333\" /></div> </div> </div> </div> </div> </section>','img_2f644b056a9fd3624c7595d24b1d9273.jpg','2021-08-09 03:09:44','nosotros',1),(5,'Contacto','<div class=\"map\"><iframe style=\"border: 0;\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7739.161634949614!2d-87.17606630165281!3d14.101904909878845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f6fa33ebbcd59a3%3A0xdec406e209c1c049!2sColonia%20San%20Miguel%2C%20Tegucigalpa%2C%20Francisco%20Moraz%C3%A1n!5e0!3m2!1ses-419!2shn!4v1723143671353!5m2!1ses-419!2shn\" width=\"100%\" height=\"600\" allowfullscreen=\"allowfullscreen\" loading=\"lazy\"></iframe></div>','img_c32b365fd8eadee8f8cf55714d6729f8.jpg','2021-08-09 03:11:08','contacto',1),(6,'Preguntas frecuentes','<p><strong>&iquest;Cu&aacute;l es el tiempo de entrega de los productos?</strong></p> <p>En M&amp;G Store, nos comprometemos a ofrecer un servicio de entrega eficiente y confiable. El tiempo de entrega estimado para nuestros productos var&iacute;a seg&uacute;n la ubicaci&oacute;n geogr&aacute;fica del destinatario y la disponibilidad del producto. En general, el proceso de entrega puede tomar entre 3 a 5 d&iacute;as h&aacute;biles para destinos locales y hasta 15 d&iacute;as h&aacute;biles para env&iacute;os internacionales. Nos esforzamos por garantizar que cada paquete llegue a su destino en perfectas condiciones y en el menor tiempo posible, manteni&eacute;ndote informado durante todo el proceso de env&iacute;o.</p> <p><strong>&iquest;C&oacute;mo es la forma de env&iacute;o de los productos?</strong></p> <p>En M&amp;G Store utilizamos m&eacute;todos de env&iacute;o que garantizan la seguridad y la rapidez en la entrega. Colaboramos con empresas de mensajer&iacute;a y paqueter&iacute;a de renombre para asegurar que tu pedido llegue de forma segura a tu puerta o a la direcci&oacute;n que nos indiques. Al momento de realizar tu pedido, podr&aacute;s seleccionar la opci&oacute;n de env&iacute;o que mejor se ajuste a tus necesidades, incluyendo env&iacute;o est&aacute;ndar, expr&eacute;s o ecol&oacute;gico, cada uno con un costo y tiempo de entrega espec&iacute;fico. Adem&aacute;s, recibir&aacute;s un c&oacute;digo de seguimiento para que puedas monitorear el estado de tu pedido en tiempo real.</p> <p><strong>&iquest;Cu&aacute;l es el tiempo m&aacute;ximo para solicitar un reembolso?</strong></p> <p>Entendemos que en ocasiones, es posible que desees devolver un producto. En M&amp;G Store, puedes solicitar un reembolso dentro de los primeros 30 d&iacute;as despu&eacute;s de haber recibido tu pedido. Para que el reembolso sea procesado, el producto debe estar en su estado original, sin haber sido utilizado y con todos sus accesorios y empaques intactos. Una vez que recibamos el producto y verifiquemos su estado, procederemos a realizar el reembolso mediante el mismo m&eacute;todo de pago utilizado en la compra. Queremos que tu experiencia de compra sea satisfactoria, por lo que nos esforzamos por hacer este proceso lo m&aacute;s simple y r&aacute;pido posible.</p> <h3>Otras preguntas</h3> <p><strong>&iquest;Qu&eacute; formas de pago aceptan?</strong></p> <p>En M&amp;G Store, queremos facilitarte el proceso de compra, por lo que ofrecemos diversas formas de pago. Aceptamos tarjetas de cr&eacute;dito y d&eacute;bito, pagos a trav&eacute;s de plataformas de pago electr&oacute;nico, transferencias bancarias y, en algunos casos, pago contra entrega. Nuestro sitio web utiliza tecnolog&iacute;a de cifrado para garantizar que tus transacciones sean seguras y tu informaci&oacute;n financiera est&eacute; protegida. Independientemente del m&eacute;todo de pago que elijas, recibir&aacute;s una confirmaci&oacute;n de tu compra y todos los detalles de tu pedido por correo electr&oacute;nico.</p>','','2021-08-11 01:24:19','preguntas-frecuentes',1),(7,'Términos y Condiciones','<p><strong>T&eacute;rminos y Condiciones de Inversiones N&amp;G</strong></p> <p>Bienvenido a la Tienda M&amp;G Store. Al utilizar nuestros servicios, usted acepta estar vinculado por los siguientes t&eacute;rminos y condiciones. Lea cuidadosamente antes de hacer uso de nuestros servicios.</p> <p><strong>Pol&iacute;tica Uno: Uso Aceptable</strong></p> <ul> <li>El usuario se compromete a utilizar los servicios de M&amp;G Store de manera responsable y conforme a las leyes aplicables, as&iacute; como a respetar los derechos de terceros. Queda estrictamente prohibido el uso de los servicios para actividades il&iacute;citas, enga&ntilde;osas, malintencionadas o discriminatorias.</li> </ul> <p><strong>T&eacute;rmino Dos: Privacidad y Protecci&oacute;n de Datos</strong></p> <ul> <li>M&amp;G Store se compromete a proteger la privacidad y los datos personales de sus usuarios. Toda la informaci&oacute;n personal recabada ser&aacute; tratada con estricta confidencialidad, de acuerdo con nuestra pol&iacute;tica de privacidad y la legislaci&oacute;n vigente sobre protecci&oacute;n de datos.</li> </ul> <p><strong>Condici&oacute;n Tres: Modificaciones de los Servicios</strong></p> <ul> <li>M&amp;G Store se reserva el derecho de modificar, suspender o discontinuar cualquiera de sus servicios en cualquier momento, con o sin previo aviso. Esto incluye cambios en la disponibilidad de ciertas caracter&iacute;sticas, funcionalidades o contenidos. El usuario reconoce y acepta que M&amp;G Storeno ser&aacute; responsable ante el usuario ni ante terceros por cualquier modificaci&oacute;n, suspensi&oacute;n o interrupci&oacute;n de los servicios.</li> </ul> <p><strong>Resoluci&oacute;n de Disputas</strong></p> <ul> <li>Cualquier disputa relacionada con los t&eacute;rminos, condiciones o servicios de M&amp;G Store ser&aacute; resuelta mediante arbitraje, de acuerdo con las reglas de arbitraje del estado o pa&iacute;s de registro de M&amp;G Store. Ambas partes acuerdan someterse a la jurisdicci&oacute;n exclusiva de dichos arbitrajes.</li> </ul> <p><strong>Limitaci&oacute;n de Responsabilidad</strong></p> <ul> <li>En ning&uacute;n caso M&amp;G Store ser&aacute; responsable de da&ntilde;os directos, indirectos, incidentales, especiales o consecuentes que resulten del uso o la incapacidad de usar nuestros servicios, incluso si M&amp;G Store ha sido advertido de la posibilidad de tales da&ntilde;os.</li> </ul> <p><strong>Aceptaci&oacute;n de los T&eacute;rminos</strong></p> <ul> <li>El uso continuado de los servicios de M&amp;G Store tras la publicaci&oacute;n de cambios o actualizaciones a estos t&eacute;rminos implica la aceptaci&oacute;n de los mismos. Si el usuario no est&aacute; de acuerdo con los t&eacute;rminos y condiciones revisados, su &uacute;nico recurso es dejar de utilizar los servicios de M&amp;G Store.</li> </ul> <p>Estos t&eacute;rminos y condiciones son efectivos hasta que sean reemplazados o modificados por otros nuevos. Agradecemos su elecci&oacute;n de M&amp;G Store para sus necesidades y esperamos brindarle un servicio excepcional.</p>','','2021-08-11 01:51:06','terminos-y-condiciones',1),(8,'Sucursales','<section class=\"py-5 text-center\"> <div class=\"container\"> <p>Visitanos y obten los mejores precios del mercado, cualquier art&iacute;culo que necestas para vivir mejor</p> <a class=\"btn btn-info\" href=\"../../../tienda\">VER PRODUCTOS</a></div> </section> <div class=\"py-5 bg-light\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-md-4\"> <div class=\"card mb-4 box-shadow hov-img0\"><img src=\"https://abelosh.com/tienda_virtual/Assets/images/s1.jpg\" alt=\"Tienda Uno\" width=\"100%\" height=\"100%\" /> <div class=\"card-body\"> <p class=\"card-text\">En el albor de la innovaci&oacute;n, M&amp;G Store emerge como basti&oacute;n de la modernidad y el progreso. Comprometidos con la excelencia y la vanguardia, nos dedicamos a trascender los l&iacute;mites de lo posible, ofreciendo soluciones que iluminan, transforman y enriquecen cada aspecto de tu vida diaria. Nuestro ethos se cimenta en la pasi&oacute;n por descubrir y la determinaci&oacute;n por ofrecer lo extraordinario, creando un mundo donde cada producto es un pelda&ntilde;o hacia el futuro. En M&amp;G Store, cada desaf&iacute;o es una oportunidad para redefinir lo convencional y cada cliente, un invitado a embarcarse en un viaje sin precedentes hacia horizontes sin explorar.</p> <p>Direcci&oacute;n: Tegucigalpa&nbsp;<br />Tel&eacute;fono: 4654645 <br />Correo: info@</p> </div> </div> </div> <div class=\"col-md-4\"> <div class=\"card mb-4 box-shadow hov-img0\"><img src=\"https://abelosh.com/tienda_virtual/Assets/images/s2.jpg\" alt=\"Sucural dos\" width=\"100%\" height=\"100%\" /> <div class=\"card-body\"> <p class=\"card-text\">En el coraz&oacute;n de la innovaci&oacute;n, M&amp;G Store se erige como un faro de progreso y excelencia. Con un compromiso inquebrantable con la calidad y la vanguardia, nos esforzamos por superar los l&iacute;mites de lo imaginable, entregando soluciones que iluminan, transforman y enriquecen cada faceta de tu vida cotidiana. Nuestra filosof&iacute;a se fundamenta en una pasi&oacute;n incansable por la exploraci&oacute;n y la determinaci&oacute;n de ofrecer lo excepcional, forjando un mundo donde cada producto representa un paso hacia el futuro. En M&amp;G Store, cada desaf&iacute;o se convierte en una oportunidad para reimaginar lo convencional, y cada cliente es un compa&ntilde;ero de viaje hacia destinos nunca antes alcanzados.</p> <p>Direcci&oacute;n: Tegucigalpa&nbsp;<br />Tel&eacute;fono: 4654645 <br />Correo: info@</p> </div> </div> </div> <div class=\"col-md-4\"> <div class=\"card mb-4 box-shadow hov-img0\"><img src=\"https://abelosh.com/tienda_virtual/Assets/images/s3.jpg\" alt=\"Sucural tres\" width=\"100%\" height=\"100%\" /> <div class=\"card-body\"> <p class=\"card-text\">Desde los albores del emprendimiento, M&amp;G Store se destaca como emblema de avance y perfecci&oacute;n. Impulsados por un compromiso firme con la superaci&oacute;n y la innovaci&oacute;n, nuestra misi&oacute;n es desafiar los confines de lo imaginado, brindando soluciones que alumbran, metamorfosean y ennoblecen cada &aacute;mbito de tu existencia diaria. Anclados en el deseo ardiente de descubrimiento y la ambici&oacute;n por presentar lo excepcional, construimos un universo en el que cada elecci&oacute;n es un escal&oacute;n hacia lo venidero. En M&amp;G Store, cada obst&aacute;culo es visto como una ventana hacia la reinvenci&oacute;n de lo establecido, y cada cliente, un aliado en este periplo hacia lo inexplorado.</p> <p>Direcci&oacute;n: Tegucigalpa&nbsp;<br />Tel&eacute;fono: 4654645 <br />Correo: info@</p> </div> </div> </div> </div> </div> </div>','img_b79ee78923fa95348a08a36a90e3651f.jpg','2021-08-11 02:26:45','sucursales',1),(9,'Not Found','<h1>Error 404: P&aacute;gina no encontrada</h1> <p>No se encuentra la p&aacute;gina que ha solicitado.</p>','','2021-08-12 02:30:49','not-found',1);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `idproducto` bigint NOT NULL AUTO_INCREMENT,
  `categoriaid` bigint NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `compra` decimal(11,2) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `stock` int NOT NULL,
  `imagen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ruta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idproducto`),
  KEY `categoriaid` (`categoriaid`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoriaid`) REFERENCES `categoria` (`idcategoria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=422 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (19,8,'12345135','Juego familiar 6 en 1','<p>Regalo de Juguete de Tablero de Ajedrez, Ludo, Backgammon, Damas, Serpientes y Escaleras</p>',150.00,400.00,2,NULL,'2024-03-27 13:30:30','juego-familiar-6-en-1',1),(39,1,'9289613165','Camiseta de manga larga con cuello redondo','<p>Dise&ntilde;o gr&aacute;fico con bloques de color, camisas c&oacute;modas, para primavera, verano y oto&ntilde;o, para hombres, Talla S</p>',155.00,300.00,37,NULL,'2024-03-31 19:03:53','camiseta-de-manga-larga-con-cuello-redondo',1),(86,8,'2482966966','Balón de fútbol','<p>Bal&oacute;n de f&uacute;tbol de PVC de talla 5, resistente al desgaste, suave y c&oacute;modo para partidos de entrenamiento, unisex</p>',103.00,200.00,1,NULL,'2024-04-11 00:22:50','balon-de-futbol',1),(106,5,'3880901052','Cargador Rápido para 3 Dispositivos','<p>40W, USB-C/USB Universal, Carga R&aacute;pida Inteligente, Amplia Compatibilidad, Enchufe USA</p>',49.00,120.00,1,NULL,'2024-04-12 23:49:45','cargador-rapido-para-3-dispositivos',1),(125,1,'1882908','Camiseta estampada elegante','<p>Playera informal de cuello redondo, Remera el&aacute;stica de estilo callejero para hombre, Talla M y S</p>',67.00,250.00,43,NULL,'2024-04-13 22:05:15','camiseta-estampada-elegante',1),(142,5,'3197884929','Soporte Para Teléfono Móvil De Navegación Para Automóvil','<p>Soporte Para Autom&oacute;vil Con Gravedad Antivibraci&oacute;n Soporte Para Tel&eacute;fono M&oacute;vil Al Por Mayor De F&aacute;brica</p>',23.00,100.00,2,NULL,'2024-04-14 14:34:23','soporte-para-telefono-movil-de-navegacion-para-automovil',1),(185,9,'7661047414','Baberos de alimentación de algodón para bebé','<p>Baberos de alimentaci&oacute;n de algod&oacute;n para beb&eacute; con dise&ntilde;o aleatorio, impermeable para reci&eacute;n nacido, regalo de Pascua</p>',13.00,35.00,8,NULL,'2024-04-17 22:42:03','baberos-de-alimentacion-de-algodon-para-bebe',1),(218,1,'5783675781','Chanclas de plataforma','<p>Zapatos De Plataforma Casuales Para Hombres, Zapatillas Antideslizantes De Punta Abierta Para Interiores Y Exteriores, Oscuro / 7.5-8</p>',52.00,160.00,51,NULL,'2024-04-18 00:22:17','chanclas-de-plataforma',1),(225,7,'6457441540','Esponjas de Limpieza Polivalente 4 unidades','<p>Paquete de 4 Esponjas de Limpieza Polivalente de Poliuretano &ndash; Seguras para Cocina y Ba&ntilde;o, No Rayan, Duraderas</p>',17.00,70.00,4,NULL,'2024-04-18 00:37:55','esponjas-de-limpieza-polivalente-4-unidades',1),(227,7,'6792396439','Platos De Imitación De Madera','<p>Conjunto De 4 Platos De Imitaci&oacute;n De Madera Con Patr&oacute;n De Hueso Para Frutas Secas, Dulces De Mel&oacute;n, Pasteles Y Postres Para Acampar Al Aire Libre Y Picnic</p>',60.00,100.00,1,NULL,'2024-04-18 00:42:55','platos-de-imitacion-de-madera',1),(228,7,'3678824694','Paste de limpieza de cocina','<p>Juego de Toallas de Cocina Coloridas y Ecol&oacute;gicas Absorbentes y Duraderas para Limpieza Multisuperficie</p>',5.00,10.00,20,NULL,'2024-04-18 00:47:10','paste-de-limpieza-de-cocina',1),(233,5,'9606898216','Protector de Pico 8 AC USB Type C','<p>Regleta de 8 AC &amp; USB/Type-C - Protecci&oacute;n contra Sobrecargas, Estaci&oacute;n de Carga con Enchufe Plano y Control Remoto, Ideal para Hogar, Oficina, Viajes</p>',116.00,350.00,2,NULL,'2024-04-18 01:02:47','protector-de-pico-8-ac-usb-type-c',1),(237,7,'9824178849','Espátula De Acero Inoxidable Para Freír','<p>1 pieza Esp&aacute;tula De Acero Inoxidable Para Fre&iacute;r Pescado Pinza De Alimentos Pinza De Pescado Clip Antiadherente Esp&aacute;tula De Filete Para Herramientas De Cocina</p>',15.00,60.00,2,NULL,'2024-04-18 01:15:13','espatula-de-acero-inoxidable-para-freir',1),(250,1,'8541367177','Camiseta Atlética Degradada para Hombre','<p>Camiseta Atl&eacute;tica Degradada para Hombre - Tejido Transpirable y de Secado R&aacute;pido con Elasticidad - Vers&aacute;til para Deporte y Uso Casual de Verano, Talla S, M</p>',60.00,250.00,35,NULL,'2024-05-04 13:18:56','camiseta-atletica-degradada-para-hombre',1),(254,9,'8531118489','Rodilleras Y Coderas Elásticas Suaves','<p>Rodilleras Y Coderas El&aacute;sticas Suaves, 5 Colores, Para Beb&eacute;s Y Ni&ntilde;os Peque&ntilde;os, Protector De Seguridad Antideslizante Para Gatear Y Coj&iacute;n Para Piernas</p>',25.00,85.00,3,NULL,'2024-05-04 13:53:33','rodilleras-y-coderas-elasticas-suaves',1),(262,1,'2463069197','Camiseta Playera con estampado gráfico de cerveza divertida para hombre','<p>Camiseta/Playera creativa con estampado gr&aacute;fico de cerveza divertida para hombre, remera informal de manga corta con cuello redondo, ropa para hombre para verano al aire libre, Talla M</p>',86.00,250.00,44,NULL,'2024-05-04 14:19:36','camiseta-playera-con-estampado-grafico-de-cerveza-divertida-para-hombre',1),(280,9,'4257469810','Silbatos Coloridos: Divierte y Haz Inolvidable tu Fiesta de Cumpleaños','<p>Eleve las Celebraciones: Set de 25 Ruidosos Vibrantes y Coloridos, Perfecto para Cumplea&ntilde;os y Eventos Festivos - &iexcl;Diversi&oacute;n para Todas las Edades!</p>',24.00,180.00,2,NULL,'2024-05-04 16:53:15','silbatos-coloridos-divierte-y-haz-inolvidable-tu-fiesta-de-cumpleanos',1),(293,7,'6173055061','Escurridor De Platos Multifuncional Desplegable','<p>Unidad De Rejilla Plegable Para Secar Platos En La Encimera De La Cocina, Soporte De Almacenamiento De Vajilla, Escurridor De Platos Sobre El Fregadero, Cesta De Drenaje Para Lavar Frutas Y Verduras En El Fregadero, F&aacute;cil De Limpiar Y Ahorra Espacio Para Uso En Fiestas Y Restaurantes</p>',110.00,280.00,1,NULL,'2024-05-10 05:44:44','escurridor-de-platos-multifuncional-desplegable',1),(302,9,'6321780727','Lindos Zapatos Cómodos De Dibujos Animados Sin Cordones Para Niñas','<p>Lindos Zapatos C&oacute;modos De Dibujos Animados Sin Cordones Para Ni&ntilde;as, Zapatos Transpirables Antideslizantes Para Caminar En Interiores Y Exteriores, Primavera Y Verano. meses 3-4, 4-5</p>',30.00,150.00,1,NULL,'2024-08-02 22:23:51','lindos-zapatos-comodos-de-dibujos-animados-sin-cordones-para-ninas',1),(303,9,'4542918653','conjunto de verano con estampado de koala para dormir para bebés','<p>2 piezas de conjunto de verano con estampado de koala para dormir para beb&eacute;s, camiseta sin mangas y pantalones cortos casuales, ropa unisex para beb&eacute;s, como regalo, Verde claro / 6-9M</p>',100.00,250.00,1,NULL,'2024-08-02 22:25:43','conjunto-de-verano-con-estampado-de-koala-para-dormir-para-bebes',1),(364,4,'4647325374','190 Piezas de Clips de Retención de Parachoques Remaches de Plástico para Coches.','<p>Juego de 190 Piezas de Sujetadores Automotrices - 6 Tama&ntilde;os de Clips de Varilla de Empuje de PP Duraderos para Asegurar Guardabarros y Parachoques, Empaquetados en Bolsa de Pl&aacute;stico</p>',94.00,450.00,2,NULL,'2024-08-12 22:36:32','190-piezas-de-clips-de-retencin-de-parachoques-remaches-de-plstico-para-coches',1),(371,4,'9832724797','herramienta de mano/tijera profesional/cizalla para tubos de plástico y aluminio, corte perfecto, rapido y practico, herramienta portátil','<p>herramienta de mano/tijera profesional/cizalla para tubos de pl&aacute;stico y aluminio, corte perfecto, rapido y practico, herramienta port&aacute;til</p>',140.00,300.00,1,NULL,'2024-08-12 22:58:17','herramienta-de-mano-tijera-profesional-cizalla-para-tubos-de-plstico-y-aluminio-corte-perfecto-rapido-y-practico-herramienta-porttil',1),(372,4,'7383490684','Arrancador de coche portátil EAFC 8000mAh, carga USB','<p>Arrancador de coche port&aacute;til EAFC 8000mAh, carga USB, banco de energ&iacute;a para bater&iacute;a de 12V para 1.06 galones de gasolina, veh&iacute;culos di&eacute;sel de 67.63 onzas con pinza de arranque inteligente, pantalla LCD, pol&iacute;mero de litio</p>',720.00,1600.00,2,NULL,'2024-08-12 23:02:41','arrancador-de-coche-porttil-eafc-8000mah-carga-usb',1),(381,3,'2343625746','Camisetas creativas para niñas con estampado de corazones 1 pieza','<p>camisetas creativas para ni&ntilde;as con estampado de corazones, suaves y el&aacute;sticas, cuello redondo y mangas cortas, tops de verano casuales para ni&ntilde;as, 13/14 a&ntilde;os</p>',79.00,220.00,130,NULL,'2024-08-12 23:34:56','camisetas-creativas-para-nias-con-estampado-de-corazones-1-pieza',1),(382,3,'5823103100','Camiseta de cuello redondo con estampado de París 1 Pieza','<p>camisetas de cuello redondo con estampado de Par&iacute;s, top casual de manga corta para verano y primavera, ropa de mujer. Talla M</p>',110.00,250.00,90,NULL,'2024-08-12 23:37:15','camiseta-de-cuello-redondo-con-estampado-de-pars-1-pieza',1),(383,3,'1905297460','Camiseta BE HAPPY & Corazón 1 pieza','<p>BE HAPPY &amp; Coraz&oacute;n/Corona/Pintura Dorada Gr&aacute;fico Impreso Camisetas, Camisetas C&oacute;modas y Modernas Para Primavera y Verano, Ropa de Ni&ntilde;as Para Exteriores, 7/8 y 13/14 a&ntilde;os.</p>',64.00,250.00,81,NULL,'2024-08-12 23:44:52','camiseta-be-happy-corazn-1-pieza',1),(384,3,'6092790672','Camisetas casuales y cómodas con estampado de letras de graffiti y gatos de dibujos animados','<p>camisetas casuales y c&oacute;modas con estampado de letras de graffiti y gatos de dibujos animados, para ni&ntilde;as, con cuello redondo y mangas cortas, ideal para primavera y verano, ropa para actividades al aire libre</p>',56.00,220.00,152,NULL,'2024-08-12 23:47:10','camisetas-casuales-y-cmodas-con-estampado-de-letras-de-graffiti-y-gatos-de-dibujos-animados',1),(386,6,'1366479959','Capa Para Cortar El Pelo De Diseño De Paraguas, Ideal Para Envolver Al Cortar El Pelo En La Peluquería, Plegable, Impermeable Y Portátil','<p>Capa Para Cortar El Pelo De Dise&ntilde;o De Paraguas, Ideal Para Envolver Al Cortar El Pelo En La Peluquer&iacute;a, Plegable, Impermeable Y Port&aacute;til, Ideal Para Usar En Casa, Protector Creativo Para La Limpieza Del Hogar</p>',50.00,190.00,1,NULL,'2024-08-12 23:51:25','capa-para-cortar-el-pelo-de-diseo-de-paraguas-ideal-para-envolver-al-cortar-el-pelo-en-la-peluquera-plegable-impermeable-y-porttil',1),(389,6,'3622752349','Estante De Esquina Triangular Para Baño','<p>Estante De Esquina Triangular Para Ba&ntilde;o - Organizador Montado En Pared Resistente Para Champ&uacute; Y Art&iacute;culos De Aseo - F&aacute;cil Instalaci&oacute;n, Dise&ntilde;o Antideslizante</p>',74.00,200.00,4,NULL,'2024-08-13 00:04:23','estante-de-esquina-triangular-para-bao',1),(390,6,'8944830432','Estante de Almacenamiento Montado en la Pared de Acero Inoxidable Sin Taladro','<p>1pc Estante de Almacenamiento Montado en la Pared de Acero Inoxidable Sin Taladro - Estante Colgante Vers&aacute;til para Ba&ntilde;o y Cocina, Estante de Ba&ntilde;o, Armario de Almacenamiento de Ba&ntilde;o</p>',75.00,220.00,2,NULL,'2024-08-13 00:07:08','estante-de-almacenamiento-montado-en-la-pared-de-acero-inoxidable-sin-taladro',1),(391,4,'5334089720','adhesivo para el umbral de la puerta a cuadros con brillo','<p>Mejora y protege con elegante adhesivo para el umbral de la puerta a cuadros con brillo: &iexcl;dise&ntilde;o resistente a los ara&ntilde;azos y duradero de tem&aacute;tica fant&aacute;stica!</p>',85.00,280.00,1,NULL,'2024-08-13 00:09:07','adhesivo-para-el-umbral-de-la-puerta-a-cuadros-con-brillo',1),(394,4,'9086325726','Tubo de Desagüe Flexible Sin Olor para Fregadero - Fácil Instalación, Acero Inoxidable Duradero','<p>Tubo de Desag&uuml;e Flexible Sin Olor para Fregadero - F&aacute;cil Instalaci&oacute;n, Acero Inoxidable Duradero &amp; ABS, Dise&ntilde;o Ahorra Espacio para Cocina y Ba&ntilde;o, Tapete para Grifo de Cocina y Escurridor de Platos para Fregadero</p>',86.00,350.00,2,NULL,'2024-08-13 00:16:50','tubo-de-desage-flexible-sin-olor-para-fregadero-fcil-instalacin-acero-inoxidable-duradero',1),(399,6,'7618650046','Arnés para perros de servicio, chaleco reflectante para perros con parches, arnés ajustable de tela Oxford suave para mascotas, fácil de controlar para perros pequeños, medianos y grandes. Talla M y L','<p>Arn&eacute;s para perros de servicio, chaleco reflectante para perros con parches, arn&eacute;s ajustable de tela Oxford suave para mascotas, f&aacute;cil de controlar para perros peque&ntilde;os, medianos y grandes. Talla M y L</p>',165.00,500.00,3,NULL,'2024-08-13 00:33:44','arns-para-perros-de-servicio-chaleco-reflectante-para-perros-con-parches-arns-ajustable-de-tela-oxford-suave-para-mascotas-fcil-de-controlar-para-perros-pequeos-medianos-y-grandes-talla-m-y-l',1),(407,6,'6071848083','Bolsa de malla flotante para atrapar pelusa en la lavadora, atrapador de pelusa para la ropa 3 piezas','<p>Bolsa de malla flotante para atrapar pelusa en la lavadora, atrapador de pelusa para la ropa, removedor de pelo de mascotas para la ropa, bolsa reutilizable para filtrar el cabello en el hogar, red para atrapar pelusa en la lavadora, suministros de limpieza, dispositivos para el hogar</p>',62.00,250.00,5,NULL,'2024-08-13 00:52:08','bolsa-de-malla-flotante-para-atrapar-pelusa-en-la-lavadora-atrapador-de-pelusa-para-la-ropa-3-piezas',1),(410,5,'6125846829','Auriculares Inalámbricos E7S TWS con Carga y Pantalla Digital','<p class=\"_2FkSakGm\">Auriculares Inal&aacute;mbricos E7S TWS con Carga y Pantalla Digital, Auriculares Deportivos para Correr de Alta Fidelidad y Alta Definici&oacute;n, Auriculares Inal&aacute;mbricos con Micr&oacute;fono Incorporado, Auriculares Inal&aacute;mbricos de Alta Definici&oacute;n, Caja de Carga Port&aacute;til y Ligera Adecuada para Conexi&oacute;n con Android y Apple</p>',70.00,350.00,3,NULL,'2024-09-27 22:22:24','auriculares-inalmbricos-e7s-tws-con-carga-y-pantalla-digital',1),(411,5,'7860765515','Audífonos Inalámbricos SoundMaster - Estéreo Hi-Fi, Control Táctil','<p>Aud&iacute;fonos Inal&aacute;mbricos SoundMaster - Est&eacute;reo Hi-Fi, Control T&aacute;ctil, Aislamiento Ac&uacute;stico, Resistente al Sudor, Bater&iacute;a de Larga Duraci&oacute;n, Estuche de Carga Digital y Micr&oacute;fono para Juegos, Ejercicio y Llamadas Manos Libres</p>',83.00,350.00,5,NULL,'2024-09-27 22:24:54','audfonos-inalmbricos-soundmaster-estreo-hi-fi-control-tctil',1),(414,3,'2136227653','Estuche Organizador de Maquillaje Portátil con Divisor y Cremallera','<p>Bolsa de Aseo Impermeable de Gran Capacidad con Asa - Estuche Organizador de Maquillaje Port&aacute;til con Divisor y Cremallera, colores disponible Albaricoque, Gouache y Marr&oacute;n.</p>',61.00,200.00,6,NULL,'2024-10-11 15:15:27','estuche-organizador-de-maquillaje-porttil-con-divisor-y-cremallera',1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `entradas_A_I` AFTER INSERT ON `producto` FOR EACH ROW BEGIN
    INSERT INTO entradas(idproducto,cantidad,compra,precio)
    VALUES(new.idproducto,new.stock,new.compra,new.precio);
 END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `reembolso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reembolso` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pedidoid` bigint NOT NULL,
  `idtransaccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `datosreembolso` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidoid` (`pedidoid`),
  CONSTRAINT `reembolso_ibfk_1` FOREIGN KEY (`pedidoid`) REFERENCES `pedido` (`idpedido`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `reembolso` WRITE;
/*!40000 ALTER TABLE `reembolso` DISABLE KEYS */;
/*!40000 ALTER TABLE `reembolso` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `idrol` bigint NOT NULL AUTO_INCREMENT,
  `nombrerol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Administrador','Acceso a todo el sistema',1),(2,'Supervisor','Supervisor de tiendas',1),(3,'Cliente','Clientes en general',1),(4,'Vendedor','Operador de tienda',1);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `suscripciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suscripciones` (
  `idsuscripcion` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idsuscripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `suscripciones` WRITE;
/*!40000 ALTER TABLE `suscripciones` DISABLE KEYS */;
INSERT INTO `suscripciones` VALUES (55,'Ana Martínez','ana.martinez@ejemplo.com','2026-11-16 09:09:47'),(56,'Carlos Mejía','carlos.mejia@ejemplo.com','2026-11-10 09:09:47'),(57,'Daniela Castro','daniela.castro@ejemplo.com','2026-11-04 09:09:47'),(58,'Sofía Reyes','sofia.reyes@ejemplo.com','2026-10-28 09:09:47'),(59,'Pedro Lara','pedro.lara@ejemplo.com','2026-10-21 09:09:47');
/*!40000 ALTER TABLE `suscripciones` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tipopago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipopago` (
  `idtipopago` bigint NOT NULL AUTO_INCREMENT,
  `tipopago` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idtipopago`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tipopago` WRITE;
/*!40000 ALTER TABLE `tipopago` DISABLE KEYS */;
INSERT INTO `tipopago` VALUES (1,'PayPal',1),(2,'Efectivo',1),(3,'Transferencia Bancaria',1);
/*!40000 ALTER TABLE `tipopago` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `variante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `variante` (
  `idvariante` bigint NOT NULL AUTO_INCREMENT,
  `productoid` bigint NOT NULL,
  `atributos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'JSON, ej. {"Color":"Rojo","Talla":"M"}',
  `etiqueta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Texto para mostrar, ej. Rojo / M',
  `codigo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(11,2) DEFAULT NULL COMMENT 'NULL = usa el precio del producto',
  `stock` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idvariante`),
  KEY `productoid` (`productoid`),
  CONSTRAINT `variante_ibfk_1` FOREIGN KEY (`productoid`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `variante` WRITE;
/*!40000 ALTER TABLE `variante` DISABLE KEYS */;
INSERT INTO `variante` VALUES (111,383,'{\"Color\":\"Negro\",\"Talla\":\"S\"}','Negro / S',NULL,NULL,7,1,'2026-11-21 03:17:52'),(112,383,'{\"Color\":\"Negro\",\"Talla\":\"M\"}','Negro / M',NULL,NULL,0,1,'2026-11-21 03:17:52'),(113,383,'{\"Color\":\"Negro\",\"Talla\":\"L\"}','Negro / L',NULL,NULL,5,1,'2026-11-21 03:17:52'),(114,383,'{\"Color\":\"Negro\",\"Talla\":\"XL\"}','Negro / XL',NULL,NULL,9,1,'2026-11-21 03:17:52'),(115,383,'{\"Color\":\"Rosa\",\"Talla\":\"S\"}','Rosa / S',NULL,NULL,6,1,'2026-11-21 03:17:52'),(116,383,'{\"Color\":\"Rosa\",\"Talla\":\"M\"}','Rosa / M',NULL,NULL,2,1,'2026-11-21 03:17:52'),(117,383,'{\"Color\":\"Rosa\",\"Talla\":\"L\"}','Rosa / L',NULL,NULL,14,1,'2026-11-21 03:17:52'),(118,383,'{\"Color\":\"Rosa\",\"Talla\":\"XL\"}','Rosa / XL',NULL,NULL,12,1,'2026-11-21 03:17:52'),(119,383,'{\"Color\":\"Crema\",\"Talla\":\"S\"}','Crema / S',NULL,NULL,10,1,'2026-11-21 03:17:52'),(120,383,'{\"Color\":\"Crema\",\"Talla\":\"M\"}','Crema / M',NULL,NULL,13,1,'2026-11-21 03:17:52'),(121,383,'{\"Color\":\"Crema\",\"Talla\":\"L\"}','Crema / L',NULL,NULL,0,1,'2026-11-21 03:17:52'),(122,383,'{\"Color\":\"Crema\",\"Talla\":\"XL\"}','Crema / XL',NULL,NULL,3,1,'2026-11-21 03:17:52'),(123,384,'{\"Color\":\"Gris\",\"Talla\":\"S\"}','Gris / S',NULL,NULL,12,1,'2026-11-21 03:17:52'),(124,384,'{\"Color\":\"Gris\",\"Talla\":\"M\"}','Gris / M',NULL,NULL,10,1,'2026-11-21 03:17:52'),(125,384,'{\"Color\":\"Gris\",\"Talla\":\"L\"}','Gris / L',NULL,NULL,13,1,'2026-11-21 03:17:52'),(126,384,'{\"Color\":\"Gris\",\"Talla\":\"XL\"}','Gris / XL',NULL,NULL,0,1,'2026-11-21 03:17:52'),(127,384,'{\"Color\":\"Negro\",\"Talla\":\"S\"}','Negro / S',NULL,NULL,3,1,'2026-11-21 03:17:52'),(128,384,'{\"Color\":\"Negro\",\"Talla\":\"M\"}','Negro / M',NULL,NULL,8,1,'2026-11-21 03:17:52'),(129,384,'{\"Color\":\"Negro\",\"Talla\":\"L\"}','Negro / L',NULL,NULL,11,1,'2026-11-21 03:17:52'),(130,384,'{\"Color\":\"Negro\",\"Talla\":\"XL\"}','Negro / XL',NULL,NULL,6,1,'2026-11-21 03:17:52'),(131,384,'{\"Color\":\"Durazno\",\"Talla\":\"S\"}','Durazno / S',NULL,NULL,8,1,'2026-11-21 03:17:52'),(132,384,'{\"Color\":\"Durazno\",\"Talla\":\"M\"}','Durazno / M',NULL,NULL,4,1,'2026-11-21 03:17:52'),(133,384,'{\"Color\":\"Durazno\",\"Talla\":\"L\"}','Durazno / L',NULL,NULL,15,1,'2026-11-21 03:17:52'),(134,384,'{\"Color\":\"Durazno\",\"Talla\":\"XL\"}','Durazno / XL',NULL,NULL,10,1,'2026-11-21 03:17:52'),(135,384,'{\"Color\":\"Blanco\",\"Talla\":\"S\"}','Blanco / S',NULL,NULL,9,1,'2026-11-21 03:17:52'),(136,384,'{\"Color\":\"Blanco\",\"Talla\":\"M\"}','Blanco / M',NULL,NULL,7,1,'2026-11-21 03:17:52'),(137,384,'{\"Color\":\"Blanco\",\"Talla\":\"L\"}','Blanco / L',NULL,NULL,0,1,'2026-11-21 03:17:52'),(138,384,'{\"Color\":\"Blanco\",\"Talla\":\"XL\"}','Blanco / XL',NULL,NULL,5,1,'2026-11-21 03:17:52'),(139,384,'{\"Color\":\"Verde menta\",\"Talla\":\"S\"}','Verde menta / S',NULL,NULL,9,1,'2026-11-21 03:17:52'),(140,384,'{\"Color\":\"Verde menta\",\"Talla\":\"M\"}','Verde menta / M',NULL,NULL,6,1,'2026-11-21 03:17:52'),(141,384,'{\"Color\":\"Verde menta\",\"Talla\":\"L\"}','Verde menta / L',NULL,NULL,2,1,'2026-11-21 03:17:52'),(142,384,'{\"Color\":\"Verde menta\",\"Talla\":\"XL\"}','Verde menta / XL',NULL,NULL,14,1,'2026-11-21 03:17:52'),(143,381,'{\"Color\":\"Gris\",\"Talla\":\"6\"}','Gris / 6',NULL,NULL,14,1,'2026-11-21 03:17:52'),(144,381,'{\"Color\":\"Gris\",\"Talla\":\"8\"}','Gris / 8',NULL,NULL,12,1,'2026-11-21 03:17:52'),(145,381,'{\"Color\":\"Gris\",\"Talla\":\"10\"}','Gris / 10',NULL,NULL,10,1,'2026-11-21 03:17:52'),(146,381,'{\"Color\":\"Gris\",\"Talla\":\"12\"}','Gris / 12',NULL,NULL,13,1,'2026-11-21 03:17:52'),(147,381,'{\"Color\":\"Gris\",\"Talla\":\"14\"}','Gris / 14',NULL,NULL,0,1,'2026-11-21 03:17:52'),(148,381,'{\"Color\":\"Negro\",\"Talla\":\"6\"}','Negro / 6',NULL,NULL,3,1,'2026-11-21 03:17:52'),(149,381,'{\"Color\":\"Negro\",\"Talla\":\"8\"}','Negro / 8',NULL,NULL,8,1,'2026-11-21 03:17:52'),(150,381,'{\"Color\":\"Negro\",\"Talla\":\"10\"}','Negro / 10',NULL,NULL,11,1,'2026-11-21 03:17:52'),(151,381,'{\"Color\":\"Negro\",\"Talla\":\"12\"}','Negro / 12',NULL,NULL,6,1,'2026-11-21 03:17:52'),(152,381,'{\"Color\":\"Negro\",\"Talla\":\"14\"}','Negro / 14',NULL,NULL,8,1,'2026-11-21 03:17:52'),(153,381,'{\"Color\":\"Blanco\",\"Talla\":\"6\"}','Blanco / 6',NULL,NULL,4,1,'2026-11-21 03:17:52'),(154,381,'{\"Color\":\"Blanco\",\"Talla\":\"8\"}','Blanco / 8',NULL,NULL,15,1,'2026-11-21 03:17:52'),(155,381,'{\"Color\":\"Blanco\",\"Talla\":\"10\"}','Blanco / 10',NULL,NULL,10,1,'2026-11-21 03:17:52'),(156,381,'{\"Color\":\"Blanco\",\"Talla\":\"12\"}','Blanco / 12',NULL,NULL,9,1,'2026-11-21 03:17:52'),(157,381,'{\"Color\":\"Blanco\",\"Talla\":\"14\"}','Blanco / 14',NULL,NULL,7,1,'2026-11-21 03:17:52'),(158,382,'{\"Color\":\"Gris\",\"Talla\":\"S\"}','Gris / S',NULL,NULL,11,1,'2026-11-21 03:17:52'),(159,382,'{\"Color\":\"Gris\",\"Talla\":\"M\"}','Gris / M',NULL,NULL,6,1,'2026-11-21 03:17:52'),(160,382,'{\"Color\":\"Gris\",\"Talla\":\"L\"}','Gris / L',NULL,NULL,8,1,'2026-11-21 03:17:52'),(161,382,'{\"Color\":\"Gris\",\"Talla\":\"XL\"}','Gris / XL',NULL,NULL,4,1,'2026-11-21 03:17:52'),(162,382,'{\"Color\":\"Negro\",\"Talla\":\"S\"}','Negro / S',NULL,NULL,15,1,'2026-11-21 03:17:52'),(163,382,'{\"Color\":\"Negro\",\"Talla\":\"M\"}','Negro / M',NULL,NULL,10,1,'2026-11-21 03:17:52'),(164,382,'{\"Color\":\"Negro\",\"Talla\":\"L\"}','Negro / L',NULL,NULL,9,1,'2026-11-21 03:17:52'),(165,382,'{\"Color\":\"Negro\",\"Talla\":\"XL\"}','Negro / XL',NULL,NULL,7,1,'2026-11-21 03:17:52'),(166,382,'{\"Color\":\"Blanco\",\"Talla\":\"S\"}','Blanco / S',NULL,NULL,0,1,'2026-11-21 03:17:52'),(167,382,'{\"Color\":\"Blanco\",\"Talla\":\"M\"}','Blanco / M',NULL,NULL,5,1,'2026-11-21 03:17:52'),(168,382,'{\"Color\":\"Blanco\",\"Talla\":\"L\"}','Blanco / L',NULL,NULL,9,1,'2026-11-21 03:17:52'),(169,382,'{\"Color\":\"Blanco\",\"Talla\":\"XL\"}','Blanco / XL',NULL,NULL,6,1,'2026-11-21 03:17:52'),(170,125,'{\"Talla\":\"S\"}','S',NULL,NULL,6,1,'2026-11-21 03:17:52'),(171,125,'{\"Talla\":\"M\"}','M',NULL,NULL,8,1,'2026-11-21 03:17:52'),(172,125,'{\"Talla\":\"L\"}','L',NULL,NULL,4,1,'2026-11-21 03:17:52'),(173,125,'{\"Talla\":\"XL\"}','XL',NULL,NULL,15,1,'2026-11-21 03:17:52'),(174,125,'{\"Talla\":\"XXL\"}','XXL',NULL,NULL,10,1,'2026-11-21 03:17:52'),(175,250,'{\"Talla\":\"S\"}','S',NULL,NULL,13,1,'2026-11-21 03:17:52'),(176,250,'{\"Talla\":\"M\"}','M',NULL,NULL,0,1,'2026-11-21 03:17:52'),(177,250,'{\"Talla\":\"L\"}','L',NULL,NULL,3,1,'2026-11-21 03:17:52'),(178,250,'{\"Talla\":\"XL\"}','XL',NULL,NULL,8,1,'2026-11-21 03:17:52'),(179,250,'{\"Talla\":\"XXL\"}','XXL',NULL,NULL,11,1,'2026-11-21 03:17:52'),(180,262,'{\"Talla\":\"S\"}','S',NULL,NULL,11,1,'2026-11-21 03:17:52'),(181,262,'{\"Talla\":\"M\"}','M',NULL,NULL,6,1,'2026-11-21 03:17:52'),(182,262,'{\"Talla\":\"L\"}','L',NULL,NULL,8,1,'2026-11-21 03:17:52'),(183,262,'{\"Talla\":\"XL\"}','XL',NULL,NULL,4,1,'2026-11-21 03:17:52'),(184,262,'{\"Talla\":\"XXL\"}','XXL',NULL,NULL,15,1,'2026-11-21 03:17:52'),(185,39,'{\"Talla\":\"S\"}','S',NULL,NULL,8,1,'2026-11-21 03:17:52'),(186,39,'{\"Talla\":\"M\"}','M',NULL,NULL,11,1,'2026-11-21 03:17:52'),(187,39,'{\"Talla\":\"L\"}','L',NULL,NULL,6,1,'2026-11-21 03:17:52'),(188,39,'{\"Talla\":\"XL\"}','XL',NULL,NULL,8,1,'2026-11-21 03:17:52'),(189,39,'{\"Talla\":\"XXL\"}','XXL',NULL,NULL,4,1,'2026-11-21 03:17:52'),(195,218,'{\"Talla\":\"36-37\"}','36-37',NULL,NULL,2,1,'2026-11-21 03:17:52'),(196,218,'{\"Talla\":\"38-39\"}','38-39',NULL,NULL,14,1,'2026-11-21 03:17:52'),(197,218,'{\"Talla\":\"40-41\"}','40-41',NULL,NULL,12,1,'2026-11-21 03:17:52'),(198,218,'{\"Talla\":\"42-43\"}','42-43',NULL,NULL,10,1,'2026-11-21 03:17:52'),(199,218,'{\"Talla\":\"44-45\"}','44-45',NULL,NULL,13,1,'2026-11-21 03:17:52');
/*!40000 ALTER TABLE `variante` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


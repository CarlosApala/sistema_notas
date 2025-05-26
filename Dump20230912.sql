-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: db_sistema_escolar
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricula` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `semestre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `curp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_ingreso` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrera_id` bigint unsigned NOT NULL,
  `materia_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumnos_carrera_id_foreign` (`carrera_id`),
  KEY `alumnos_materia_id_foreign` (`materia_id`),
  CONSTRAINT `alumnos_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alumnos_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (1,'Pedro','pedro@gmail.com','18181114','ITSLP','4444210897','6','2023-09-07','Hombre','20','ZAPA000321MSPGRRA1','2023-09-19','Activo','Test','constancia.jpeg',3,3,'2023-09-11 00:21:25','2023-09-13 01:39:17');
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificaciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `calificacion` double(8,2) NOT NULL,
  `alumno_id` bigint unsigned NOT NULL,
  `materia_id` bigint unsigned NOT NULL,
  `profesor_id` bigint unsigned NOT NULL,
  `carrera_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calificaciones_alumno_id_foreign` (`alumno_id`),
  KEY `calificaciones_materia_id_foreign` (`materia_id`),
  CONSTRAINT `calificaciones_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificaciones`
--

LOCK TABLES `calificaciones` WRITE;
/*!40000 ALTER TABLE `calificaciones` DISABLE KEYS */;
INSERT INTO `calificaciones` VALUES (1,10.00,1,1,1,1,'2023-09-11 07:59:06','2023-09-11 07:59:06'),(2,4.00,1,18,1,7,'2023-09-11 11:22:30','2023-09-11 11:31:10');
/*!40000 ALTER TABLE `calificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carreras`
--

DROP TABLE IF EXISTS `carreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carreras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carreras_clave_unique` (`clave`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carreras`
--

LOCK TABLES `carreras` WRITE;
/*!40000 ALTER TABLE `carreras` DISABLE KEYS */;
INSERT INTO `carreras` VALUES (1,'Ingenieria Electrica','IELE-2010-209','Ingenieria Electrica',NULL,'2023-09-05 23:59:46','2023-09-05 23:59:46'),(2,'Ingenieria Mecanica','IMEC-2010-228','Ingenieria Mecanica',NULL,'2023-09-06 00:00:26','2023-09-06 00:00:26'),(3,'Ingenieria en Sistemas Computacionales','ISIC-2010-224','Ingenieria en Sistemas Computacionales',NULL,'2023-09-06 00:01:45','2023-09-06 00:01:45'),(4,'Ingenieria Electronica','IELC-AUT-2010-211','Ingenieria Electronica',NULL,'2023-09-06 00:02:22','2023-09-06 00:02:22'),(5,'Ingenieria en Gestion Empresarial','IGEM 2009-201','Ingenieria en Gestion Empresarial',NULL,'2023-09-06 00:03:01','2023-09-06 00:03:01'),(6,'Ingenieria Industrial','IIND-2010-227','Ingenieria Industrial',NULL,'2023-09-06 00:03:32','2023-09-06 00:03:32'),(7,'Ingenieria Informatica','IINF-2010-220','Ingenieria Informatica',NULL,'2023-09-06 00:03:57','2023-09-06 00:03:57'),(8,'Ingenieria Mecatronica','IMCT-2010-229','Ingenieria Mecatronica',NULL,'2023-09-06 00:04:31','2023-09-06 00:04:31'),(9,'Licenciatura en Administración','LADM-2010-234','Licenciatura en Administración',NULL,'2023-09-06 00:04:59','2023-09-06 00:04:59'),(10,'Licenciatura en Turismo','LTUR-2012-237','Licenciatura en Turismo',NULL,'2023-09-06 00:05:31','2023-09-06 00:05:31');
/*!40000 ALTER TABLE `carreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creditos` int DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrera_id` int unsigned NOT NULL,
  `profesor_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `materias_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (1,'Administracion para Informatica','AGG2',4,'Administracion para Informatica',7,2,'2023-09-08 00:19:10','2023-09-08 01:02:43'),(2,'Fundamentos de Investigacion','AGG1',4,'Fundamentos de Investigacion',7,1,'2023-09-08 00:19:44','2023-09-08 00:19:44'),(3,'Fundamentos de Programacion','AEF-1032',5,'Fundamentos de Programacion',7,1,'2023-09-08 00:20:22','2023-09-08 00:20:22'),(4,'Taller de Etica','DGG1',4,'Taller de Etica',7,1,'2023-09-08 00:21:21','2023-09-08 00:21:21'),(5,'Calculo Diferencial','EGG1',5,'Calculo Diferencial',7,1,'2023-09-08 00:22:39','2023-09-08 00:22:39'),(6,'Desarrollo Sustentable','FGG6',5,'Desarrollo Sustentable',7,1,'2023-09-08 00:23:07','2023-09-08 00:23:07'),(7,'Administracion de los Recursos y Funcion Informatica','AGG4',4,'Administracion de los Recursos y Funcion Informatica',7,1,'2023-09-08 00:24:46','2023-09-08 00:24:46'),(8,'Fisica para Informatica','BGG2',5,'Fisica para Informatica',7,1,'2023-09-08 00:25:25','2023-09-08 00:25:25'),(9,'Programacion Orientada a Objetos','CGG2',5,'Programacion Orientada a Objetos',7,1,'2023-09-08 00:25:57','2023-09-08 00:25:57'),(10,'Contabilidad Financiera','DGG2',4,'Contabilidad Financiera',7,1,'2023-09-08 00:26:25','2023-09-08 00:26:25'),(11,'Calculo Integral','EGG2',5,'Calculo Integral',7,1,'2023-09-08 00:26:53','2023-09-08 00:26:53'),(12,'Matemáticas Discretas','BGG1',5,'Matemáticas Discretas',7,1,'2023-09-08 00:27:36','2023-09-08 00:27:36'),(13,'Fundamentos de Sistemas de Informacion','AGG3',4,'Fundamentos de Sistemas de Informacion',7,1,'2023-09-08 00:28:16','2023-09-08 00:28:16'),(14,'Sistemas Electronicos para Informatica','BGG3',4,'Sistemas Electronicos para Informatica',7,1,'2023-09-08 00:28:54','2023-09-08 00:28:54'),(15,'Estructura de Datos','CGG3',5,'Estructura de Datos',7,1,'2023-09-08 00:29:24','2023-09-08 00:29:24'),(16,'Costos Empresariales','FGG3',4,'Costos Empresariales',7,1,'2023-09-08 00:29:59','2023-09-08 00:29:59'),(17,'Algebra Lineal','EGG3',5,'Algebra Lineal',7,1,'2023-09-08 00:30:21','2023-09-08 00:30:21'),(18,'Probabilidad y Estadistica','DGG3',5,'Probabilidad y Estadistica',7,1,'2023-09-08 00:30:44','2023-09-08 00:30:44'),(19,'Taller de Investigacion I','FGG7',4,'Taller de Investigacion I',7,1,'2023-09-08 00:31:17','2023-09-08 00:31:17'),(20,'Arquitectura de Computadoras','BGG4',5,'Arquitectura de Computadoras',7,2,'2023-09-08 00:31:51','2023-09-08 00:31:51'),(21,'Administracion y Organizacion de Datos','CGG4',5,'Administracion y Organizacion de Datos',7,1,'2023-09-08 00:32:27','2023-09-08 00:32:27'),(22,'Fundamentos de Telecomunicaciones','DGG4',4,'Fundamentos de Telecomunicaciones',7,1,'2023-09-08 00:33:05','2023-09-08 00:33:05'),(23,'Sistemas Operativos I','EGG5',4,'Sistemas Operativos I',7,1,'2023-09-08 00:33:38','2023-09-08 00:33:38'),(24,'Investigacion de Operaciones','FGG4',5,'Investigacion de Operaciones',7,2,'2023-09-08 00:34:19','2023-09-08 00:34:19'),(25,'Analisis y Modelado de Sistemas de Informacion','AGG5',5,'Analisis y Modelado de Sistemas de Informacion',7,1,'2023-09-08 00:36:06','2023-09-08 00:36:06'),(26,'Tecnologias e Interfaces de Computadoras','BGG5',4,'Tecnologias e Interfaces de Computadoras',7,1,'2023-09-08 00:36:44','2023-09-08 00:36:44'),(27,'Fundamentos de Bases de Datos','CGG5',5,'Fundamentos de Bases de Datos',7,1,'2023-09-08 00:37:07','2023-09-08 00:37:07'),(28,'Redes de Computadoras','DGG5',5,'Redes de Computadoras',7,1,'2023-09-08 00:37:30','2023-09-08 00:37:30'),(31,'Sistemas Operativos II','EGG6',5,'Sistemas Operativos II',7,2,'2023-09-08 00:38:48','2023-09-08 00:38:48'),(32,'Taller de Legislacion Informatica','BGG6',3,'Taller de Legislacion Informatica',7,1,'2023-09-08 00:39:24','2023-09-08 00:39:24'),(33,'Desarrollo e Implementacion de Sistemas de Informacion','AGG6',5,'Desarrollo e Implementacion de Sistemas de Informacion',7,1,'2023-09-08 00:41:08','2023-09-08 00:41:08'),(34,'Auditoria en Informatica','DGG8',4,'Auditoria en Informatica',7,1,'2023-09-08 00:41:39','2023-09-08 00:41:39'),(35,'Taller de Base de Datos','CGG6',4,'Taller de Base de Datos',7,1,'2023-09-08 00:42:05','2023-09-08 00:42:05'),(36,'Interconectividad de Redes','DGG6',6,'Interconectividad de Redes',7,1,'2023-09-08 00:42:54','2023-09-08 00:42:54'),(38,'Desarrollo de Aplicaciones Web','EGG7',5,'Desarrollo de Aplicaciones Web',7,3,'2023-09-08 00:43:44','2023-09-08 01:02:00'),(39,'Taller de Investigacion II','FGG8',4,'Taller de Investigacion II',7,1,'2023-09-08 00:44:12','2023-09-08 00:44:12'),(40,'Calidad de los Sistemas de Informacion','AGG7',4,'Calidad de los Sistemas de Informacion',7,1,'2023-09-08 00:44:38','2023-09-08 00:44:38'),(41,'Fundamentos de Gestion de Servicios de TI','BGG7',4,'Fundamentos de Gestion de Servicios de TI',7,1,'2023-09-08 00:45:11','2023-09-08 00:45:11'),(42,'Topicos de Bases de Datos','CGG7',5,'Topicos de Bases de Datos',7,2,'2023-09-08 00:45:44','2023-09-08 00:45:44'),(43,'Administracion de Servidores','DGG7',4,'Administracion de Servidores',7,1,'2023-09-08 00:46:09','2023-09-08 00:46:09'),(44,'Programacion en Ambiente Cliente/Servidor','EGG8',5,'Programacion en Ambiente Cliente/Servidor',7,1,'2023-09-08 00:46:44','2023-09-08 00:46:44'),(45,'Topicos de Seguridad Informatica','HGG6',5,'Topicos de Seguridad Informatica',7,1,'2023-09-08 00:47:16','2023-09-08 00:47:16'),(46,'Taller de Emprendedores','AGG8',5,'Taller de Emprendedores',7,1,'2023-09-08 00:47:42','2023-09-08 00:47:42'),(47,'Estrategias de Servicios de TI','BGG8',5,'Estrategias de Servicios de TI',7,1,'2023-09-08 00:48:05','2023-09-08 00:48:05'),(48,'Inteligencia de Negocios','CGG8',5,'Inteligencia de Negocios',7,1,'2023-09-08 00:48:32','2023-09-08 00:48:32'),(50,'Desarrollo de Aplicaciones para Dispositivos Moviles','EGG9',5,'Desarrollo de Aplicaciones para Dispositivos Moviles',7,3,'2023-09-08 00:49:17','2023-09-08 01:02:30'),(51,'Seguridad Informatica','FGG5',4,'Seguridad Informatica',7,1,'2023-09-08 00:49:39','2023-09-08 00:49:39'),(52,'Topicos Avanzados de Redes','IGG8',5,'Topicos Avanzados de Redes',7,1,'2023-09-08 00:50:01','2023-09-08 00:50:01'),(53,'Gestion de Operaciones','LGG9',5,'Gestion de Operaciones',7,1,'2023-09-08 00:50:28','2023-09-08 00:50:28'),(54,'Seguridad de las Tecnologias de la Informacion','MGG9',5,'Seguridad de las Tecnologias de la Informacion',7,1,'2023-09-08 00:51:00','2023-09-08 00:51:00'),(55,'Auditoria de Seguridad','NGG9',5,'Auditoria de Seguridad',7,2,'2023-09-08 00:51:24','2023-09-08 00:51:24'),(56,'Residencia Profesional','AGG9',10,'Residencia Profesional',7,1,'2023-09-08 00:51:55','2023-09-08 00:51:55'),(57,'Servicio Social','GGG8',10,'Servicio Social',7,1,'2023-09-08 00:52:21','2023-09-08 00:52:21'),(58,'Actividades Complementarias','AGG10',5,'Actividades Complementarias',7,1,'2023-09-08 00:53:07','2023-09-08 00:53:07');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2022_10_26_075851_create_hoteles_table',1),(6,'2022_10_30_200240_create_huespedes_table',1),(7,'2022_10_31_182947_create_piscinas_table',1),(8,'2022_11_12_080451_create_auditorias',1),(9,'2022_11_12_080839_create_servicios',1),(10,'2022_11_12_081128_create_restaurante',1),(11,'2022_11_12_082211_create_bar',1),(12,'2022_11_12_082513_create_categoria_hoteles',1),(13,'2022_11_12_082720_create_disponibilidad_habitaciones',1),(14,'2022_11_12_082914_create_habitaciones',1),(15,'2022_11_12_083735_create_pago',1),(16,'2022_11_12_083927_create_precios',1),(17,'2022_11_12_084027_create_reservas',1),(18,'2022_11_12_085036_create_cuentas',1),(19,'2023_08_31_213030_create_carreras',1),(20,'2023_09_05_053609_create_permission_tables',2),(21,'2023_09_05_055735_create_roles',3),(22,'2023_09_05_181627_create_profesores',4),(23,'2023_09_05_182044_create_materias',4),(24,'2023_09_10_170939_create_alumnos',5),(25,'2023_09_10_172225_create_alumnos',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'crear carreras','web','2023-09-05 16:37:34','2023-09-05 16:37:34'),(2,'editar carreras','web','2023-09-05 16:37:34','2023-09-05 16:37:34');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `experiencia` int NOT NULL,
  `fecha_contratacion` date NOT NULL,
  `carrera_id` int unsigned DEFAULT NULL,
  `materia_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,'Hugo Adan Saavedra','hugo@mail.com','123456789','ITSLP','0001',3,'2023-09-05',3,52,'2023-09-06 03:33:09','2023-09-12 13:34:44'),(2,'Guillermo Romo Villalpando','guillermo@mail.com','4444850358','ITSLP','0002',2,'2023-09-07',3,28,'2023-09-07 15:33:49','2023-09-12 13:47:20'),(3,'Obed Sanchez de la Vega Bautista','obed@mail.com','451028800','ITSLP','0003',5,'2023-09-07',7,50,'2023-09-08 00:54:52','2023-09-10 15:20:16');
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(2,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2023-09-05 12:06:19','2023-09-05 12:06:19'),(2,'maestro','web','2023-09-05 12:06:19','2023-09-05 12:06:19'),(3,'alumno','web','2023-09-05 12:06:19','2023-09-05 12:06:19');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@admin.com',NULL,'Admin','$2y$10$P6aaTGYM9LSAgQswYFV4teRgNi.Bz0d3Wqc3FhSPZTLsecqPeb7tq',NULL,'2023-09-09 09:37:20','2023-09-09 09:37:20'),(2,'Profesor','profesor@profesor.com',NULL,'Profesor','$2y$10$AHSpXY0jgCtkypIdr3rNFOD5YZHW3xPfdmfuP7jdXdLxWLqqGMkIe',NULL,'2023-09-09 09:38:39','2023-09-09 09:38:39'),(3,'Alumno','alumno@alumno.com',NULL,'Alumno','$2y$10$2pyysFFZWKZgC.CvcK2wvOCKLxjjtCCAO1bhfbiDLH1YHAx2SOXLu',NULL,'2023-09-09 09:40:12','2023-09-09 09:40:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-12 13:49:22

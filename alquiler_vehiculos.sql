-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sistema_alquiler_vehiculos
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `alquiler`
--

DROP TABLE IF EXISTS `alquiler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alquiler` (
  `id` int NOT NULL,
  `vehiculo_id` varchar(6) DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `valor_alquiler_id` int DEFAULT NULL,
  `sede_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehiculo_id` (`vehiculo_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `valor_alquiler_id` (`valor_alquiler_id`),
  KEY `sede_id` (`sede_id`),
  CONSTRAINT `alquiler_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculo` (`placa`),
  CONSTRAINT `alquiler_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  CONSTRAINT `alquiler_ibfk_3` FOREIGN KEY (`valor_alquiler_id`) REFERENCES `valor_alquiler` (`id`),
  CONSTRAINT `alquiler_ibfk_4` FOREIGN KEY (`sede_id`) REFERENCES `sede` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alquiler`
--

LOCK TABLES `alquiler` WRITE;
/*!40000 ALTER TABLE `alquiler` DISABLE KEYS */;
INSERT INTO `alquiler` VALUES (1,'ABC123',1,'2025-06-01','2025-06-05',1,1),(2,'DEF456',2,'2025-06-10','2025-06-15',2,2),(3,'ABC123',1,'2025-07-01','2025-07-05',1,1);
/*!40000 ALTER TABLE `alquiler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id` int NOT NULL,
  `nombre_categoria` varchar(10) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_licencia` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_licencia` (`id_licencia`),
  CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`id_licencia`) REFERENCES `licencia` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'A','Motocicletas',1),(2,'B','Carros particulares',2);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `color`
--

DROP TABLE IF EXISTS `color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `color` (
  `id` varchar(7) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color`
--

LOCK TABLES `color` WRITE;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
INSERT INTO `color` VALUES ('C001','Color1'),('C002','Color2'),('C003','Color3'),('C004','Color4'),('C005','Color5');
/*!40000 ALTER TABLE `color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalles_factura`
--

DROP TABLE IF EXISTS `detalles_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalles_factura` (
  `id` int NOT NULL,
  `factura_id` int DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `factura_id` (`factura_id`),
  CONSTRAINT `detalles_factura_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalles_factura`
--

LOCK TABLES `detalles_factura` WRITE;
/*!40000 ALTER TABLE `detalles_factura` DISABLE KEYS */;
INSERT INTO `detalles_factura` VALUES (1,1,'Alquiler de vehículo',620.44),(2,2,'Alquiler de vehículo',901.55);
/*!40000 ALTER TABLE `detalles_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_reserva`
--

DROP TABLE IF EXISTS `estado_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_reserva` (
  `id` int NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_reserva` int DEFAULT NULL,
  `fecha_estado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reserva` (`id_reserva`),
  CONSTRAINT `estado_reserva_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_reserva`
--

LOCK TABLES `estado_reserva` WRITE;
/*!40000 ALTER TABLE `estado_reserva` DISABLE KEYS */;
INSERT INTO `estado_reserva` VALUES (1,'Confirmada',1,'2025-05-30'),(2,'Cancelada',2,'2025-06-01');
/*!40000 ALTER TABLE `estado_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_vehiculo`
--

DROP TABLE IF EXISTS `estado_vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_vehiculo` (
  `id` int NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_estado` date DEFAULT NULL,
  `vehiculo_placa` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehiculo_placa` (`vehiculo_placa`),
  CONSTRAINT `estado_vehiculo_ibfk_1` FOREIGN KEY (`vehiculo_placa`) REFERENCES `vehiculo` (`placa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_vehiculo`
--

LOCK TABLES `estado_vehiculo` WRITE;
/*!40000 ALTER TABLE `estado_vehiculo` DISABLE KEYS */;
INSERT INTO `estado_vehiculo` VALUES (1,'Disponible','2025-06-01','ABC123'),(2,'En mantenimiento','2025-06-10','DEF456');
/*!40000 ALTER TABLE `estado_vehiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `id` int NOT NULL,
  `fecha_emision` date DEFAULT NULL,
  `alquiler_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alquiler_id` (`alquiler_id`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`alquiler_id`) REFERENCES `alquiler` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (1,'2025-06-06',1),(2,'2025-06-16',2);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licencia`
--

DROP TABLE IF EXISTS `licencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `licencia` (
  `id` int NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `fecha_expedicion` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `Id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario_idx` (`Id_usuario`),
  CONSTRAINT `id_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licencia`
--

LOCK TABLES `licencia` WRITE;
/*!40000 ALTER TABLE `licencia` DISABLE KEYS */;
INSERT INTO `licencia` VALUES (1,'LIC123','2023-01-01','2028-01-01','Activa',1),(2,'LIC456','2022-06-15','2027-06-15','Activa',2);
/*!40000 ALTER TABLE `licencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantenimiento`
--

DROP TABLE IF EXISTS `mantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mantenimiento` (
  `id` int NOT NULL,
  `vehiculo_placa` varchar(6) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehiculo_placa` (`vehiculo_placa`),
  CONSTRAINT `mantenimiento_ibfk_1` FOREIGN KEY (`vehiculo_placa`) REFERENCES `vehiculo` (`placa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimiento`
--

LOCK TABLES `mantenimiento` WRITE;
/*!40000 ALTER TABLE `mantenimiento` DISABLE KEYS */;
INSERT INTO `mantenimiento` VALUES (1,'ABC123','2025-05-01','Cambio de aceite'),(2,'DEF456','2025-05-15','Revisión general');
/*!40000 ALTER TABLE `mantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medio_pago`
--

DROP TABLE IF EXISTS `medio_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medio_pago` (
  `id` int NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `pago_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pago_id` (`pago_id`),
  CONSTRAINT `medio_pago_ibfk_1` FOREIGN KEY (`pago_id`) REFERENCES `pago` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medio_pago`
--

LOCK TABLES `medio_pago` WRITE;
/*!40000 ALTER TABLE `medio_pago` DISABLE KEYS */;
INSERT INTO `medio_pago` VALUES (1,'Tarjeta de crédito',1),(2,'Efectivo',2);
/*!40000 ALTER TABLE `medio_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multa`
--

DROP TABLE IF EXISTS `multa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `multa` (
  `id_multa` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado_pagado` tinyint(1) DEFAULT NULL,
  `id_factura` int DEFAULT NULL,
  `id_tipo_multa` int DEFAULT NULL,
  PRIMARY KEY (`id_multa`),
  KEY `id_factura` (`id_factura`),
  KEY `id_tipo_multa` (`id_tipo_multa`),
  CONSTRAINT `multa_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id`),
  CONSTRAINT `multa_ibfk_2` FOREIGN KEY (`id_tipo_multa`) REFERENCES `tipo_multa` (`id_tipo_multa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multa`
--

LOCK TABLES `multa` WRITE;
/*!40000 ALTER TABLE `multa` DISABLE KEYS */;
INSERT INTO `multa` VALUES (1,'2025-06-07',1,1,1),(2,'2025-06-17',0,2,2);
/*!40000 ALTER TABLE `multa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pago` (
  `id` int NOT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `factura_id` int DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `factura_id` (`factura_id`),
  CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` VALUES (1,620.44,1,'2025-06-07'),(2,901.55,2,'2025-06-17');
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'Ubicación 1','3859092214','proveedor1@example.com','11001',NULL),(2,'Ubicación 2','3208014981','proveedor2@example.com','11001',NULL),(3,'Ubicación 3','3512276751','proveedor3@example.com','11001',NULL),(4,'Ubicación 4','3313440438','proveedor4@example.com','11001',NULL),(6,'ubicacion 5',NULL,NULL,NULL,NULL),(7,'ubica','2222222',NULL,NULL,NULL),(8,'ubiacison',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserva` (
  `id_reserva` int NOT NULL,
  `hora` time DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (1,'10:00:00','2025-06-01',1),(2,'14:30:00','2025-06-02',2);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sede`
--

DROP TABLE IF EXISTS `sede`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sede` (
  `id` int NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sede`
--

LOCK TABLES `sede` WRITE;
/*!40000 ALTER TABLE `sede` DISABLE KEYS */;
INSERT INTO `sede` VALUES (1,'Calle 123 #45-67','Sede Norte'),(2,'Av. Siempre Viva 742','Sede Sur');
/*!40000 ALTER TABLE `sede` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios_incluidos`
--

DROP TABLE IF EXISTS `servicios_incluidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios_incluidos` (
  `id` int NOT NULL,
  `alquiler_id` int DEFAULT NULL,
  `tipo_servicios` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alquiler_id` (`alquiler_id`),
  CONSTRAINT `servicios_incluidos_ibfk_1` FOREIGN KEY (`alquiler_id`) REFERENCES `alquiler` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios_incluidos`
--

LOCK TABLES `servicios_incluidos` WRITE;
/*!40000 ALTER TABLE `servicios_incluidos` DISABLE KEYS */;
INSERT INTO `servicios_incluidos` VALUES (1,1,'GPS, Seguro básico'),(2,2,'Seguro total');
/*!40000 ALTER TABLE `servicios_incluidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_multa`
--

DROP TABLE IF EXISTS `tipo_multa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_multa` (
  `id_tipo_multa` int NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_multa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_multa`
--

LOCK TABLES `tipo_multa` WRITE;
/*!40000 ALTER TABLE `tipo_multa` DISABLE KEYS */;
INSERT INTO `tipo_multa` VALUES (1,'Exceso de velocidad','Multa por exceder el límite de velocidad',250.00),(2,'Parqueo indebido','Multa por estacionamiento prohibido',180.00);
/*!40000 ALTER TABLE `tipo_multa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_usuario` (
  `id` int NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Administrador'),(2,'Cliente'),(3,'Trabajador');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_vehiculo`
--

DROP TABLE IF EXISTS `tipo_vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_vehiculo` (
  `id` int NOT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `capacidad_pasajeros` int DEFAULT NULL,
  `numero_puertas` int DEFAULT NULL,
  `trasmision` varchar(255) DEFAULT NULL,
  `tipo_combustible` varchar(255) DEFAULT NULL,
  `valor_dia` decimal(10,2) DEFAULT NULL,
  `color_id` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `color_id` (`color_id`),
  CONSTRAINT `tipo_vehiculo_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_vehiculo`
--

LOCK TABLES `tipo_vehiculo` WRITE;
/*!40000 ALTER TABLE `tipo_vehiculo` DISABLE KEYS */;
INSERT INTO `tipo_vehiculo` VALUES (1,'Tipo1','Desc1',2,3,'Manual','Gasolina',155.11,'C002'),(2,'Tipo2','Desc2',4,4,'Manual','Gasolina',180.31,'C002'),(3,'Tipo3','Desc3',3,4,'Automática','Gasolina',184.03,'C003'),(4,'Tipo4','Desc4',4,4,'Manual','Gasolina',142.67,'C004'),(5,'Tipo5','Desc5',2,5,'Automática','Gasolina',237.15,'C005');
/*!40000 ALTER TABLE `tipo_vehiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `numero_identificacion` varchar(20) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `tipo_usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_usuario_id` (`tipo_usuario_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipo_usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'CC0001','Nombre1','Apellido1','usuario1@example.com','3448262912','Dirección 1','11001',2),(2,'CC0002','Nombre2','Apellido2','usuario2@example.com','3754436557','Dirección 2','11001',1),(3,'CC0003','Nombre3','Apellido3','usuario3@example.com','3703501773','Dirección 3','11001',1),(4,'CC0004','Nombre4','Apellido4','usuario4@example.com','3156432700','Dirección 4','11001',2),(5,'CC0005','Nombre5','Apellido5','usuario5@example.com','3804830987','Dirección 5','11001',1),(6,'CC0006','Nombre6','Apellido6','usuario6@example.com','3241347554','Dirección 6','11001',1),(7,'CC0007','Nombre7','Apellido7','usuario7@example.com','3195876124','Dirección 7','11001',2),(8,'CC0008','Nombre8','Apellido8','usuario8@example.com','3389521163','Dirección 8','11001',2),(9,'CC0009','Nombre9','Apellido9','usuario9@example.com','3124607222','Dirección 9','11001',1),(10,'CC0010','Nombre10','Apellido10','usuario10@example.com','3496045142','Dirección 10','11001',1),(11,'CC0011','Trabajador','Ejemplo','trabajador@example.com','3000000000','Dirección X','11001',3);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valor_alquiler`
--

DROP TABLE IF EXISTS `valor_alquiler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valor_alquiler` (
  `id` int NOT NULL,
  `valor_vehiculo` int DEFAULT NULL,
  `valor_usuario` int DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `valor_vehiculo` (`valor_vehiculo`),
  KEY `valor_usuario` (`valor_usuario`),
  CONSTRAINT `valor_alquiler_ibfk_1` FOREIGN KEY (`valor_vehiculo`) REFERENCES `tipo_vehiculo` (`id`),
  CONSTRAINT `valor_alquiler_ibfk_2` FOREIGN KEY (`valor_usuario`) REFERENCES `tipo_usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valor_alquiler`
--

LOCK TABLES `valor_alquiler` WRITE;
/*!40000 ALTER TABLE `valor_alquiler` DISABLE KEYS */;
INSERT INTO `valor_alquiler` VALUES (1,1,2,155.11),(2,2,1,180.31);
/*!40000 ALTER TABLE `valor_alquiler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculo` (
  `placa` varchar(6) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `kilometraje` int DEFAULT NULL,
  `fecha_adquisicion` date DEFAULT NULL,
  `proveedor_id` int DEFAULT NULL,
  `reserva_id` int DEFAULT NULL,
  `tipo_vehiculo_id` int DEFAULT NULL,
  `id_sede` int DEFAULT NULL,
  PRIMARY KEY (`placa`),
  KEY `proveedor_id` (`proveedor_id`),
  KEY `reserva_id` (`reserva_id`),
  KEY `tipo_vehiculo_id` (`tipo_vehiculo_id`),
  KEY `id_sede` (`id_sede`),
  CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id_proveedor`),
  CONSTRAINT `vehiculo_ibfk_2` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id_reserva`),
  CONSTRAINT `vehiculo_ibfk_3` FOREIGN KEY (`tipo_vehiculo_id`) REFERENCES `tipo_vehiculo` (`id`),
  CONSTRAINT `vehiculo_ibfk_4` FOREIGN KEY (`id_sede`) REFERENCES `sede` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculo`
--

LOCK TABLES `vehiculo` WRITE;
/*!40000 ALTER TABLE `vehiculo` DISABLE KEYS */;
INSERT INTO `vehiculo` VALUES ('ABC123','Toyota','Corolla',40000,'2023-05-10',1,1,1,1),('DEF456','Mazda','3',30000,'2022-08-22',2,2,2,2),('GFR343','Chevrolet','Spark GT2',55000,'2025-07-04',NULL,NULL,NULL,NULL),('GFR345','Chevrolet','Spark GT',45000,'2025-07-04',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `vehiculo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-06 20:02:47

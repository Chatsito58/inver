DROP DATABASE IF EXISTS alquiler_vehiculos;
CREATE DATABASE alquiler_vehiculos;
USE alquiler_vehiculos;

CREATE TABLE alquiler (
  id INT PRIMARY KEY,
  vehiculo_id VARCHAR(6),
  usuario_id INT,
  fecha_inicio DATE,
  fecha_fin DATE,
  valor_alquiler_id INT,
  sede_id INT
);

CREATE TABLE categoria (
  id INT PRIMARY KEY,
  nombre_categoria VARCHAR(10),
  descripcion VARCHAR(255),
  id_licencia INT
);

CREATE TABLE color (
  id VARCHAR(7) PRIMARY KEY,
  nombre VARCHAR(50)
);

CREATE TABLE detalles_factura (
  id INT PRIMARY KEY,
  factura_id INT,
  descripcion VARCHAR(255),
  monto DECIMAL(10,2)
);

CREATE TABLE estado_reserva (
  id INT PRIMARY KEY,
  descripcion VARCHAR(255),
  id_reserva INT,
  fecha_estado DATE
);

CREATE TABLE estado_vehiculo (
  id INT PRIMARY KEY,
  descripcion VARCHAR(255),
  fecha_estado DATE,
  vehiculo_placa VARCHAR(6)
);

CREATE TABLE factura (
  id INT PRIMARY KEY,
  fecha_emision DATE,
  alquiler_id INT
);

CREATE TABLE licencia (
  id INT PRIMARY KEY,
  numero VARCHAR(20),
  fecha_expedicion DATE,
  fecha_vencimiento DATE,
  estado VARCHAR(255),
  id_usuario INT
);

CREATE TABLE mantenimiento (
  id INT PRIMARY KEY,
  vehiculo_placa VARCHAR(6),
  fecha DATE,
  descripcion VARCHAR(255)
);

CREATE TABLE medio_pago (
  id INT PRIMARY KEY,
  descripcion VARCHAR(255),
  pago_id INT
);

CREATE TABLE multa (
  id_multa INT PRIMARY KEY,
  fecha DATE,
  estado_pagado TINYINT,
  id_factura INT,
  id_tipo_multa INT
);

CREATE TABLE pago (
  id INT PRIMARY KEY,
  monto DECIMAL(10,2),
  factura_id INT,
  fecha_pago DATE
);

CREATE TABLE proveedor (
  id_proveedor INT PRIMARY KEY,
  ubicacion VARCHAR(255),
  telefono VARCHAR(15),
  correo VARCHAR(255),
  codigo_postal VARCHAR(10),
  fecha DATETIME
);

CREATE TABLE reserva (
  id_reserva INT PRIMARY KEY,
  hora TIME,
  fecha DATE,
  id_usuario INT
);

CREATE TABLE sede (
  id INT PRIMARY KEY,
  ubicacion VARCHAR(255),
  nombre VARCHAR(255)
);

CREATE TABLE servicios_incluidos (
  id INT PRIMARY KEY,
  alquiler_id INT,
  tipo_servicios VARCHAR(255)
);

CREATE TABLE tipo_multa (
  id_tipo_multa INT PRIMARY KEY,
  nombre VARCHAR(255),
  descripcion VARCHAR(255),
  valor DECIMAL(10,2)
);

CREATE TABLE tipo_usuario (
  id INT PRIMARY KEY,
  descripcion VARCHAR(255)
);

CREATE TABLE tipo_vehiculo (
  id INT PRIMARY KEY,
  tipo VARCHAR(255),
  descripcion VARCHAR(255),
  capacidad_pasajeros INT,
  numero_puertas INT,
  trasmision VARCHAR(255),
  tipo_combustible VARCHAR(255),
  valor_dia DECIMAL(10,2),
  color_id VARCHAR(7)
);

CREATE TABLE usuario (
  id INT PRIMARY KEY,
  numero_identificacion VARCHAR(20),
  nombre VARCHAR(255),
  apellido VARCHAR(255),
  email VARCHAR(255),
  telefono VARCHAR(15),
  direccion VARCHAR(255),
  codigo_postal VARCHAR(10),
  tipo_usuario_id INT
);

CREATE TABLE valor_alquiler (
  id INT PRIMARY KEY,
  valor_vehiculo INT,
  valor_usuario INT,
  valor_total DECIMAL(10,2)
);

CREATE TABLE vehiculo (
  placa VARCHAR(6) PRIMARY KEY,
  marca VARCHAR(255),
  modelo VARCHAR(255),
  kilometraje INT,
  fecha_adquisicion DATE,
  proveedor_id INT,
  reserva_id INT,
  tipo_vehiculo_id INT,
  id_sede INT
);

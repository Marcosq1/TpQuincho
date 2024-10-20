-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Servidor: 127.0.0.1
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de datos: `quincho_bbdd`

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `clientes`
CREATE TABLE `clientes` (
  `id_cliente` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` TEXT NOT NULL,
  `email_cliente` TEXT NOT NULL,
  `telefono_cliente` TEXT NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `reservas`
CREATE TABLE `reservas` (
  `id_reserva` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_reserva` DATE NOT NULL,
  `hora_entrada` TIME NOT NULL,
  `hora_salida` TIME NOT NULL,
  `id_cliente` INT(11) NOT NULL,
  PRIMARY KEY (`id_reserva`),
  UNIQUE KEY `fecha_reserva` (`fecha_reserva`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `categorias`
CREATE TABLE `categorias` (
  `id_categoria` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` VARCHAR(255) NOT NULL,
  `imagen_url` TEXT,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `items` (
  `id_item` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_item` VARCHAR(255) NOT NULL,
  `descripcion_item` TEXT NOT NULL,
  `id_categoria` INT(11) NOT NULL,
  `imagen_url` TEXT,
  PRIMARY KEY (`id_item`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


COMMIT;

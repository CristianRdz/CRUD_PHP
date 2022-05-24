SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
drop database`tienda`;
CREATE DATABASE IF NOT EXISTS `tienda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tienda`;

CREATE TABLE `archivos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombreReferencia` varchar(45) DEFAULT NULL,
  `nombreArchivo` varchar(45) DEFAULT NULL,
  `fModificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `clientes` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `segundoNombre` varchar(45) DEFAULT NULL,
  `apellidoPaterno` varchar(45) NOT NULL,
  `apellidoMaterno` varchar(45) DEFAULT NULL,
  `correoElectronico` varchar(200) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `fModificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `usuarios` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `segundoNombre` varchar(45) DEFAULT NULL,
  `apellidoPaterno` varchar(45) NOT NULL,
  `apellidoMaterno` varchar(45) DEFAULT NULL,
  `correoElectronico` varchar(200) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `fModificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` char(1) NOT NULL DEFAULT '1',
  `nivel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` VALUES(1, 'normal', NULL, 'normal', 'normal', 'normal', 'normal', '$2y$10$UEKhQYM.If0HBnGeLb.rvOlCZXPdFlvEBkS4rNHCMzxKcaoFzgA1W', '2020-11-16', '2020-11-17 02:33:13', '1', 100);

ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);


ALTER TABLE `archivos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: db5015110034.hosting-data.io
-- Tiempo de generación: 31-01-2024 a las 17:19:47
-- Versión del servidor: 8.0.32
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbs12533498`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Asistencia`
--

CREATE TABLE `Asistencia` (
  `IDAsistencia` int NOT NULL,
  `IDUsuario` int DEFAULT NULL,
  `FechaHoraAsistencia` datetime DEFAULT NULL,
  `FechaHoraSalida` datetime NOT NULL,
  `EstadoAsistencia` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Asistencia`
--

INSERT INTO `Asistencia` (`IDAsistencia`, `IDUsuario`, `FechaHoraAsistencia`, `FechaHoraSalida`, `EstadoAsistencia`) VALUES
(63, 1, '2024-01-30 05:17:00', '2024-01-30 16:17:00', 2),
(64, 2, '2024-01-30 15:17:00', '2024-01-30 16:17:00', 1),
(65, 3, '2024-01-30 15:17:00', '2024-01-30 16:17:00', 1),
(66, 4, '2024-01-30 15:17:00', '2024-01-30 16:17:00', 1),
(67, 1, '2024-01-31 08:51:00', '2024-01-31 20:00:00', 1),
(68, 6, '2024-01-31 12:17:00', '2024-01-31 20:17:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `IDUsuario` int NOT NULL,
  `Nombre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`IDUsuario`, `Nombre`) VALUES
(1, 'alexi'),
(2, 'allan'),
(3, 'isaac'),
(4, 'juan'),
(5, 'lucas'),
(6, 'pedro'),
(9, 'isabel'),
(10, 'adolfo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Asistencia`
--
ALTER TABLE `Asistencia`
  ADD PRIMARY KEY (`IDAsistencia`),
  ADD KEY `IDUsuario` (`IDUsuario`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`IDUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Asistencia`
--
ALTER TABLE `Asistencia`
  MODIFY `IDAsistencia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `IDUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Asistencia`
--
ALTER TABLE `Asistencia`
  ADD CONSTRAINT `Asistencia_ibfk_1` FOREIGN KEY (`IDUsuario`) REFERENCES `Usuarios` (`IDUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

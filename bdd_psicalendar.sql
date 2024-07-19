-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2024 a las 12:23:17
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdd_psicalendar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_sugeridas`
--

CREATE TABLE `actividades_sugeridas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frases_motivacionales`
--

CREATE TABLE `frases_motivacionales` (
  `id` int(11) NOT NULL,
  `frase` text NOT NULL,
  `autor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_diarios`
--

CREATE TABLE `registros_diarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `emocion` varchar(20) NOT NULL,
  `intensidad` int(11) NOT NULL,
  `anecdota` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros_diarios`
--

INSERT INTO `registros_diarios` (`id`, `usuario_id`, `fecha`, `emocion`, `intensidad`, `anecdota`) VALUES
(9, 7, '2024-07-19', 'alegre', 2, 'Me paso esto y lo otro'),
(10, 7, '2024-07-18', 'alegre', 1, 'Me paso esto y lo otro'),
(11, 7, '2024-07-17', 'enojado', 1, 'Paso esto y lo otro'),
(12, 9, '2024-07-19', 'alegre', 1, 'Me siento feliz de poder hablar con todos ustedes , hoy fue un buen día aquí en Quito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `usuario`, `password`, `fecha_registro`) VALUES
(7, 'Brandon Ariel Arevalo Cabezas', 'arielare2004@gmail.com', 'Arielcitoops', '$2y$10$iOluo8CBbwv8GVvZFaotSOV9/Cx6.CPVcpgoxrfgEe.f.t31SUxFu', '2024-07-19 08:14:56'),
(9, 'Maria Cecilia Fernandez ', 'mafer213@gmail.com', 'ma_fer1', '$2y$10$cM0lnKIIjskcUdBK.9dexOA0TISDo2iYsaoQAMpZrOE6rz7yv0qnq', '2024-07-19 09:26:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades_sugeridas`
--
ALTER TABLE `actividades_sugeridas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `frases_motivacionales`
--
ALTER TABLE `frases_motivacionales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registros_diarios`
--
ALTER TABLE `registros_diarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`fecha`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades_sugeridas`
--
ALTER TABLE `actividades_sugeridas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `frases_motivacionales`
--
ALTER TABLE `frases_motivacionales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registros_diarios`
--
ALTER TABLE `registros_diarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `registros_diarios`
--
ALTER TABLE `registros_diarios`
  ADD CONSTRAINT `registros_diarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

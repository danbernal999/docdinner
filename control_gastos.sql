-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2025 a las 11:23:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_gastos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_fijos`
--

CREATE TABLE `gastos_fijos` (
  `id` int(11) NOT NULL,
  `nombre_gasto` varchar(100) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_fijos`
--

INSERT INTO `gastos_fijos` (`id`, `nombre_gasto`, `monto`, `fecha`, `categoria`, `descripcion`, `created_at`) VALUES
(31, 'Internet', 90000.00, '2025-03-07', 'Hogar y decoración', 'Internet Claro', '2025-03-29 04:15:29'),
(32, 'Celular', 1200000.00, '2025-03-17', 'Electrónica', 'Telefono Nuevo', '2025-03-29 04:16:05'),
(33, 'Mercado', 400000.00, '2025-03-13', 'Alimentos y bebidas', 'Arroz, yuca etc', '2025-03-29 04:19:10'),
(34, 'Peluqueada', 20000.00, '2025-03-28', 'Salud y belleza', 'Barba', '2025-03-29 04:19:48'),
(35, 'Horno ', 300000.00, '2025-03-19', 'Hogar y decoración', 'Horno Kalley', '2025-03-29 04:33:22'),
(36, 'Audifonos', 510000.00, '2025-04-05', 'Electrónica', 'xd', '2025-04-06 06:13:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_ahorros`
--

CREATE TABLE `historial_ahorros` (
  `id` int(11) NOT NULL,
  `meta_id` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion1` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_ahorros`
--

INSERT INTO `historial_ahorros` (`id`, `meta_id`, `cantidad`, `fecha`, `descripcion1`) VALUES
(52, 19, 50000.00, '2025-05-13 11:27:36', 'd'),
(53, 20, 20000.00, '2025-05-13 11:44:57', ''),
(54, 20, 10000.00, '2025-05-13 11:45:51', 'ssss'),
(55, 19, 1000.00, '2025-05-13 11:52:58', ''),
(56, 19, 10000.00, '2025-05-13 12:01:45', ''),
(58, 20, 50000.00, '2025-05-13 12:03:49', 'dfd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas_ahorro`
--

CREATE TABLE `metas_ahorro` (
  `id` int(11) NOT NULL,
  `nombre_meta` varchar(255) NOT NULL,
  `cantidad_meta` decimal(10,2) NOT NULL,
  `fecha_limite` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creada_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `cumplida` tinyint(1) DEFAULT 0,
  `ahorrado` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metas_ahorro`
--

INSERT INTO `metas_ahorro` (`id`, `nombre_meta`, `cantidad_meta`, `fecha_limite`, `descripcion`, `creada_en`, `cumplida`, `ahorrado`) VALUES
(19, 'Carro', 5000000.00, '2025-05-31', 'ahorro\r\n', '2025-05-13 11:23:25', 0, 61000.00),
(20, 'ahorro para juguetes', 120000.00, '2025-05-14', 'xxxdsss', '2025-05-13 11:44:48', 0, 80000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `fecha_registro`, `ultimo_login`) VALUES
(1, 'Michael17', 'mq1@gmail.com', '$2y$10$aWVXbmxgCj/P19F2laPGf.TIyu9PARcsBVPa./oa5nh10pRxKloWm', '2025-03-27 06:35:31', NULL),
(2, 'Jose', 'j1@gmail.com', '$2y$10$pODXB83rxxIjJCjYV4WIGu/9Ea3vSVP4Cj2lqHqQzwSyQCygfhZOK', '2025-03-27 07:24:37', NULL),
(3, 'Carlos77', 'C11@gmail.com', '$2y$10$Df/iSjijmEMJAItMnCobMubKMGiY9LUWio/3sMAO4thWAxMvBz7Km', '2025-03-28 10:55:33', NULL),
(4, 'Daniel', 'd1@gmail.com', '$2y$10$0O/4zgapVjXR4V8Un1lgUOPLhG7L7t9hBWGdxbOFR0PZNnb846Md.', '2025-03-29 01:02:29', NULL),
(5, 'Maicol Quintero', 'Maicolestebanftw@gmail.com', '$2y$10$5p.pgTQk/POyBVeZiW2YMOXvg1XVl2ATPnCPN2SvNOhSVUliSxTLu', '2025-04-01 03:40:42', NULL),
(6, 'Michael', 'q3@gmail.com', '$2y$10$qM/eIsOTQ7wpl7uOUzwuOOvvxjaJuQ6qy2r/VQrTmnK4pBQrVl9i.', '2025-04-05 03:37:01', NULL),
(8, 'Michael Quintero Moncada', 'Maicol123@gmail.com', '$2y$10$02BK8v/XvRebIh4b2hdC6.G29CsYvX3SHHKRwaK45tW/kIgRU2yse', '2025-04-07 09:41:38', '2025-04-07 11:50:04'),
(9, 'Michael Quintero Moncada', '123@gmail.com', '$2y$10$AxOYsz1nvb/QmcQbcsotvOSVp..o15qNX3p0GOULcWL.Km27xs.K2', '2025-04-11 00:43:07', '2025-04-11 02:43:13'),
(10, 'Michael', '1234@gmail.com', '$2y$10$4vpRlp5KbashoNNa44LfYOgZKBmvXJGQGIXweWKDf1AxthqPMnTi.', '2025-05-09 13:04:03', '2025-05-09 15:04:12'),
(11, 'Prueba', 'prueba2x@gmail.com', '$2y$10$HBe2vl7atZMVoSDWHG7EY.Zri/2S./bnMfCLammtao2C8JjLPlFuO', '2025-05-12 07:43:15', '2025-05-12 09:43:19'),
(12, 'Michael Quintero Moncada', 'pruebam@gmail.com', '$2y$10$yF37pQUum.0CpiT4yKCRbuxYukY843HXb8LveA.InMRAM6KlAuzR2', '2025-05-16 07:05:35', '2025-05-16 09:22:08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gastos_fijos`
--
ALTER TABLE `gastos_fijos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_id` (`meta_id`);

--
-- Indices de la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gastos_fijos`
--
ALTER TABLE `gastos_fijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  ADD CONSTRAINT `historial_ahorros_ibfk_1` FOREIGN KEY (`meta_id`) REFERENCES `metas_ahorro` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-06-2025 a las 01:57:20
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
-- Base de datos: `control_gastos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_fijos`
--

CREATE TABLE `gastos_fijos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_gasto` varchar(100) NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `fecha` date DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_fijos`
--

INSERT INTO `gastos_fijos` (`id`, `usuario_id`, `nombre_gasto`, `monto`, `fecha`, `categoria`, `descripcion`, `created_at`) VALUES
(2, 1, 'Transporte', 100000.00, '2025-06-30', 'Transporte', 'Gasolina', '2025-05-25 00:20:35'),
(3, 1, 'Internet', 50000.00, '2025-06-05', 'Hogar y Decoración', 'Claro', '2025-05-25 00:21:21'),
(4, 1, 'Vivienda', 100000000.00, '2030-03-26', 'Vivienda', 'Apartamento', '2025-05-25 00:22:34'),
(5, 2, 'Compensar', 200000.00, '2025-05-31', 'Salud y Belleza', 'Brackets', '2025-05-25 00:41:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_ahorros`
--

CREATE TABLE `historial_ahorros` (
  `id` int(11) NOT NULL,
  `meta_id` int(11) NOT NULL,
  `cantidad` decimal(20,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion1` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_ahorros`
--

INSERT INTO `historial_ahorros` (`id`, `meta_id`, `cantidad`, `fecha`, `descripcion1`) VALUES
(3, 4, 3000000.00, '2025-05-26 15:56:40', ''),
(4, 4, 3000000.00, '2025-05-26 16:18:11', ''),
(5, 4, 3000000.00, '2025-05-26 16:18:23', ''),
(6, 4, 3000000.00, '2025-05-26 16:20:18', ''),
(7, 4, 4000000.00, '2025-05-26 16:20:34', ''),
(10, 4, 2000000.00, '2025-05-26 21:54:23', ''),
(11, 4, 3000000.00, '2025-05-26 22:21:08', ''),
(13, 7, 2000000.00, '2025-05-26 22:42:12', ''),
(14, 9, 3000000.00, '2025-05-26 22:44:28', ''),
(15, 9, 1000000.00, '2025-05-26 23:03:18', ''),
(16, 10, 500000.00, '2025-05-26 23:05:31', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas_ahorro`
--

CREATE TABLE `metas_ahorro` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_meta` varchar(255) NOT NULL,
  `cantidad_meta` decimal(20,2) DEFAULT NULL,
  `fecha_limite` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creada_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `cumplida` tinyint(1) DEFAULT 0,
  `ahorrado` decimal(20,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metas_ahorro`
--

INSERT INTO `metas_ahorro` (`id`, `usuario_id`, `nombre_meta`, `cantidad_meta`, `fecha_limite`, `descripcion`, `creada_en`, `cumplida`, `ahorrado`) VALUES
(3, 2, 'Guayos', 200000.00, '2025-06-30', 'Croydon', '2025-05-25 01:07:42', 0, 0.00),
(4, 1, 'Vivienda', 5000000.00, '2025-07-31', 'Penhouse', '2025-05-25 01:12:49', 0, 5000000.00),
(5, 2, 'Xbox', 3000000.00, '2025-05-31', 'Xbox One', '2025-05-25 01:16:37', 0, 0.00),
(7, 1, 'Moto', 10000000.00, '2025-05-28', 'Suzuki', '2025-05-26 22:42:03', 0, 2000000.00),
(8, 1, 'Colchon', 600000.00, '2025-05-24', 'Comodísimos', '2025-05-26 22:43:45', 0, 0.00),
(9, 1, 'Guayos', 4000000.00, '2025-05-31', 'Nike', '2025-05-26 22:44:14', 0, 4000000.00),
(10, 1, 'Tatuajes', 1000000.00, '2025-05-29', 'RustyCry', '2025-05-26 22:47:39', 0, 500000.00);

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
  `ultimo_login` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `auth_provider` varchar(50) DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `fecha_registro`, `ultimo_login`, `reset_token`, `reset_expires`, `foto`, `auth_provider`) VALUES
(1, 'Brayan Daniel', 'bblopezbenal123@gmail.com', '$2y$10$WW42vzq8pV6xOUyLthKd2OUXa7/ohTGcEMz4tHddbo3ayeODSo8jy', '2025-05-24 21:22:24', NULL, NULL, NULL, NULL, 'local'),
(2, 'draoky999', 'draoky@gmail.com', '$2y$10$BmJBKLB7BIpjJSx18sgj9uJFWbIEtkGfe0jCX3GerE2QphG6k8PqS', '2025-05-25 00:30:24', NULL, NULL, NULL, NULL, 'local');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gastos_fijos`
--
ALTER TABLE `gastos_fijos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
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
-- Filtros para la tabla `gastos_fijos`
--
ALTER TABLE `gastos_fijos`
  ADD CONSTRAINT `gastos_fijos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  ADD CONSTRAINT `historial_ahorros_ibfk_1` FOREIGN KEY (`meta_id`) REFERENCES `metas_ahorro` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  ADD CONSTRAINT `metas_ahorro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

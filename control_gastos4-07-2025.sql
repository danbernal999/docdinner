-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2025 a las 23:54:18
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
  `valor_sin_iva` decimal(10,2) DEFAULT NULL,
  `valor_iva` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `es_recurrente` tinyint(1) DEFAULT 0,
  `frecuencia_recurrencia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_fijos`
--

INSERT INTO `gastos_fijos` (`id`, `usuario_id`, `nombre_gasto`, `monto`, `valor_sin_iva`, `valor_iva`, `fecha`, `categoria`, `descripcion`, `created_at`, `es_recurrente`, `frecuencia_recurrencia`) VALUES
(9, 10, 'Transporte', 150000.00, NULL, NULL, '2025-06-30', 'Transporte', 'Gasolina', '2025-06-10 00:16:15', 0, NULL),
(10, 10, 'Vivienda', 600000.00, NULL, NULL, '2025-07-01', 'Vivienda', 'Apartamento', '2025-06-13 01:50:39', 0, NULL),
(11, 10, 'CityDent', 62000.00, NULL, NULL, '2025-06-15', 'Salud y Belleza', 'Brackets', '2025-06-13 01:51:19', 0, NULL),
(13, 10, 'Compensar', 700000.00, NULL, NULL, '2025-03-10', 'Salud y Belleza', 'Cordales', '2025-06-19 19:50:27', 0, NULL),
(15, 11, 'Zapatillas', 210000.00, 200000.00, 10000.00, '2025-07-05', 'Ropa y Accesorios', 'ss', '2025-07-04 18:43:02', 0, NULL),
(16, 11, 'Controles', 410000.00, 410000.00, 0.00, '2025-02-28', 'Electrónica', 'sq', '2025-07-04 18:44:00', 0, NULL),
(17, 11, 'Balon Adidas', 250000.00, 250000.00, 0.00, '2025-06-05', 'Deportes y Aire Libre', 'qq', '2025-07-04 18:44:21', 1, 'mensual'),
(18, 11, 'ss', 250000.00, 250000.00, 0.00, '2025-06-04', 'Alimentación', 'ww', '2025-07-04 21:12:37', 1, 'semanal');

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
(20, 13, 50000.00, '2025-06-10 00:05:40', ''),
(21, 14, 950000.00, '2025-06-10 00:11:00', ''),
(22, 15, 80000.00, '2025-06-13 01:57:42', ''),
(23, 16, 600000.00, '2025-07-04 18:49:54', ''),
(24, 16, 300000.00, '2025-07-04 18:50:13', 'Dinero que habia prestado ');

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
(5, 2, 'Xbox', 3000000.00, '2025-05-31', 'Xbox One', '2025-05-25 01:16:37', 0, 0.00),
(13, 10, 'Zapatos Air', 200000.00, '2025-06-14', 'Nike Air', '2025-06-10 00:05:23', 0, 50000.00),
(14, 10, 'Moto', 2000000.00, '2025-08-26', 'Akt 125', '2025-06-10 00:10:42', 0, 950000.00),
(15, 10, 'Guayos', 150000.00, '2025-06-15', 'Nike', '2025-06-13 01:57:35', 0, 80000.00),
(16, 11, 'Telefono De Regalo', 1800000.00, '2025-07-07', 'q', '2025-07-04 18:49:39', 0, 900000.00);

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
  `auth_provider` varchar(50) DEFAULT 'local',
  `saldo_inicial` decimal(15,2) DEFAULT 0.00,
  `presupuesto_mensual` decimal(10,2) DEFAULT 0.00,
  `moneda` varchar(10) DEFAULT 'COP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `fecha_registro`, `ultimo_login`, `reset_token`, `reset_expires`, `foto`, `auth_provider`, `saldo_inicial`, `presupuesto_mensual`, `moneda`) VALUES
(2, 'draoky999', 'draoky@gmail.com', '$2y$10$BmJBKLB7BIpjJSx18sgj9uJFWbIEtkGfe0jCX3GerE2QphG6k8PqS', '2025-05-25 00:30:24', NULL, NULL, NULL, NULL, 'local', 0.00, 0.00, 'COP'),
(10, 'Brayan Bernal', 'bblopezbernal123@gmail.com', '', '2025-06-09 23:20:43', NULL, NULL, NULL, 'uploads/perfil_6854645fb19df.jpeg', 'google', 1200000.00, 0.00, 'COP'),
(11, 'Maicol Quintero', 'maicolestebanftw17@gmail.com', '', '2025-07-04 18:40:50', NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLUSVXAqmPHgQvD_Rmnjdm1Mhd1ItxXBAHj02Rv-O4EvfyQl1M=s96-c', 'google', 0.00, 0.00, 'COP');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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

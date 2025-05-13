-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2025 a las 01:51:22
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

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
(46, 'Moto', 50000.00, '2025-04-06', 'Entretenimiento', 'Claro Internet', '2025-04-04 20:50:46'),
(47, 'Transporte', 100000.00, '2025-04-04', 'Transporte', 'Transmilenio', '2025-04-04 21:17:05'),
(48, 'Comida-Abril', 400000.00, '2025-04-30', 'Alimentación', 'Pal mes', '2025-04-07 18:50:57');

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
(1, 3, 5000000.00, '2025-04-04 21:31:11', ''),
(2, 4, 100000.00, '2025-04-07 18:25:55', ''),
(3, 4, 300000.00, '2025-04-07 18:27:05', ''),
(4, 5, 400000.00, '2025-04-07 18:27:22', ''),
(5, 6, 50.00, '2025-04-07 18:36:37', ''),
(6, 7, 20000000.00, '2025-04-07 18:58:10', ''),
(7, 7, 10000000.00, '2025-04-07 18:58:52', '');

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
  `ahorrado` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metas_ahorro`
--

INSERT INTO `metas_ahorro` (`id`, `nombre_meta`, `cantidad_meta`, `fecha_limite`, `descripcion`, `creada_en`, `cumplida`, `ahorrado`) VALUES
(2, 'moto', 10000.00, '2025-05-31', 'moto akt', '2025-03-30 00:52:29', 0, 0.00),
(4, 'Casa', 10000000.00, '2025-03-29', 'Apartamento', '2025-04-06 20:49:36', 0, 400000.00),
(5, 'Colchon', 400000.00, '2025-04-30', 'Colchones comodísimo para dormir profundamente', '2025-04-07 18:24:49', 0, 400000.00),
(6, 'Guayos', 200000.00, '2025-04-10', 'Para Jugar Futbol', '2025-04-07 18:36:24', 0, 50.00),
(7, 'Camioneta', 80000000.00, '2025-08-30', 'Pa viajar', '2025-04-07 18:57:01', 0, 30000000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `fecha_registro`) VALUES
(1, 'Michael17', 'mq1@gmail.com', '$2y$10$aWVXbmxgCj/P19F2laPGf.TIyu9PARcsBVPa./oa5nh10pRxKloWm', '2025-03-27 06:35:31'),
(2, 'Jose', 'j1@gmail.com', '$2y$10$pODXB83rxxIjJCjYV4WIGu/9Ea3vSVP4Cj2lqHqQzwSyQCygfhZOK', '2025-03-27 07:24:37'),
(3, 'Carlos77', 'C11@gmail.com', '$2y$10$Df/iSjijmEMJAItMnCobMubKMGiY9LUWio/3sMAO4thWAxMvBz7Km', '2025-03-28 10:55:33'),
(4, 'Daniel', 'd1@gmail.com', '$2y$10$0O/4zgapVjXR4V8Un1lgUOPLhG7L7t9hBWGdxbOFR0PZNnb846Md.', '2025-03-29 01:02:29'),
(5, 'Brayan Daniel Bernal Lopez', 'bblopezbenal123@gmail.com', '$2y$10$bcNXdoSNCtkWYQtCGNSLDOSxjw34dz3doIxO2WZWjcKpeDD53/kY2', '2025-03-30 00:45:52'),
(6, 'frankjimenez', 'frankjimenez081@gmail.com', '$2y$10$Nr8ajwOCWUt0uiFOyYRMHOB4mruVkvbkDjf7MfoWNpmczkcv6V1u.', '2025-04-07 18:49:34');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

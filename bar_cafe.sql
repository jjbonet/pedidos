-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2024 a las 23:12:59
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
-- Base de datos: `bar_cafe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_en_pedidos`
--

CREATE TABLE `articulos_en_pedidos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos_en_pedidos`
--

INSERT INTO `articulos_en_pedidos` (`id`, `id_pedido`, `id_articulo`, `cantidad`, `total`) VALUES
(1, 1, 1, 2, 600.00),
(2, 2, 3, 2, 900.00),
(3, 3, 3, 3, 1350.00),
(4, 3, 8, 2, 700.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id`, `nombre`, `precio`) VALUES
(1, 'Café', 300.00),
(2, 'Té', 200.00),
(3, 'Cerveza', 450.00),
(4, 'Sandwich', 500.00),
(5, 'Jugo de Naranja', 250.00),
(6, 'Agua Mineral', 150.00),
(7, 'Hamburguesa', 700.00),
(8, 'Papas Fritas', 350.00),
(9, 'Ensalada', 400.00),
(10, 'Fernet', 1500.00),
(11, 'gintonic', 1830.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id_pedido` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id_pedido`, `fecha`) VALUES
(1, '2024-06-01 18:09:10'),
(2, '2024-06-10 22:52:40'),
(3, '2024-06-10 23:05:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos_en_pedidos`
--
ALTER TABLE `articulos_en_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_articulo` (`id_articulo`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id_pedido`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos_en_pedidos`
--
ALTER TABLE `articulos_en_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos_en_pedidos`
--
ALTER TABLE `articulos_en_pedidos`
  ADD CONSTRAINT `articulos_en_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `ordenes` (`id_pedido`),
  ADD CONSTRAINT `articulos_en_pedidos_ibfk_2` FOREIGN KEY (`id_articulo`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

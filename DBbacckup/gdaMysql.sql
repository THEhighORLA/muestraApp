-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2019 a las 17:01:19
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gdatest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion`
--

CREATE TABLE `accion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` (`id`, `nombre`, `descripcion`) VALUES
(1, 'registro de usuarios', 'Registro de cuentas de usuario'),
(2, 'ver listado de usuarios', 'Permite ver el listado de todos los usuarios del sistema'),
(3, 'ver perfil', 'Permite visualizar el perfil del usuario loggeado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaraccion`
--

CREATE TABLE `asignaraccion` (
  `id_rol` int(11) DEFAULT NULL,
  `id_accion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asignaraccion`
--

INSERT INTO `asignaraccion` (`id_rol`, `id_accion`) VALUES
(1, 1),
(1, 2),
(1, 3),
(3, 2),
(3, 3),
(2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backenduser`
--

CREATE TABLE `backenduser` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `passw` varchar(250) NOT NULL,
  `authkey` varchar(50) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `foto_perfil` varchar(200) DEFAULT NULL,
  `id_rol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `backenduser`
--

INSERT INTO `backenduser` (`id`, `first_name`, `last_name`, `passw`, `authkey`, `email`, `username`, `foto_perfil`, `id_rol`) VALUES
(1, 'Orlando', 'Cuabro', '$2y$13$EaE4hUQXdC4E8SG.0jjRLOlzN9VgHeMn/AyCm6VJ192InLej75nkm', '3W4AvtYG6ZlgoABMFlDPR3iJFCv2rXsn', 'ocuabro@gmail.com', 'oruru', NULL, 1),
(5, 'prueba', 'prueba', '$2y$13$syhjOu/ppKeTIBa1HN7.6eXVZM4BeX5UvIUIiC4cKXwaaBeksXl/m', 'TRyUhYxlOIQmwfuXgsZNZvxRDdZKxi4M', 'asd@asd.asd', 'administrador', NULL, 1),
(6, 'adri', 'arrieta', '$2y$13$0j8hbzbrJ55tQuVxh8hq..J05I5fUpxCqVx8/Rv7x7b1l.2ExpP.u', 'oFQQw8v_AWUFxGmMciEFTTtGAPqhey5e', 'asd@asd.asd2', 'adrimeow', NULL, 1),
(7, 'prueba', 'prueba', '$2y$13$k34hJ5qmUH9t84sdhSamqO3LWc9eljV3gF69OSjEt3ZumFW4yqPoi', 'oEThQCHhSliWWHWhCHuaewy_cfmEKR5i', 'asd@asd.asd3', 'usuario', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `descripcion`) VALUES
(1, 'admin', 'administrador del sistema'),
(2, 'usuario', 'usuario comun del sistema'),
(3, 'superior', 'Usuario con mas privilegios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarios` (
`id` int(10) unsigned
,`first_name` varchar(50)
,`last_name` varchar(50)
,`email` varchar(80)
,`username` varchar(50)
,`nombre` varchar(50)
,`id_rol` int(10)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios`
--
DROP TABLE IF EXISTS `vista_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios`  AS  select `backenduser`.`id` AS `id`,`backenduser`.`first_name` AS `first_name`,`backenduser`.`last_name` AS `last_name`,`backenduser`.`email` AS `email`,`backenduser`.`username` AS `username`,`rol`.`nombre` AS `nombre`,`backenduser`.`id_rol` AS `id_rol` from (`backenduser` join `rol`) where (`backenduser`.`id_rol` = `rol`.`id`) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion`
--
ALTER TABLE `accion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaraccion`
--
ALTER TABLE `asignaraccion`
  ADD KEY `accion_fk` (`id_accion`),
  ADD KEY `rol_fk` (`id_rol`);

--
-- Indices de la tabla `backenduser`
--
ALTER TABLE `backenduser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion`
--
ALTER TABLE `accion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `backenduser`
--
ALTER TABLE `backenduser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaraccion`
--
ALTER TABLE `asignaraccion`
  ADD CONSTRAINT `accion_fk` FOREIGN KEY (`id_accion`) REFERENCES `accion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rol_fk` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `backenduser`
--
ALTER TABLE `backenduser`
  ADD CONSTRAINT `rol_back_fk` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

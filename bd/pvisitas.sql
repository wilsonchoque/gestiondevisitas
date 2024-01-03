-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-12-2023 a las 04:27:39
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pvisitas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_admin`
--

CREATE TABLE `tabla_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `admin_contact_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `admin_profile` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_type` enum('Master','User') COLLATE utf8_unicode_ci NOT NULL,
  `admin_created_on` datetime NOT NULL,
  `admin_status` enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tabla_admin`
--

INSERT INTO `tabla_admin` (`admin_id`, `admin_name`, `admin_contact_no`, `admin_email`, `admin_password`, `admin_profile`, `admin_type`, `admin_created_on`, `admin_status`) VALUES
(1, 'Administrador TIC', '0000000000', 'admin@gore.com', '$2y$10$PrbG2.fQ2yCS0vVskqh09eRhlkbR3dvQcAp6f10zuIfMHxWsfuyam', 'images/300351205.png', 'Master', '2020-11-06 14:17:27', 'Enable'),
(7, 'Seguridad', '991578476', 'control@gore.com', '$2y$10$cDOd3cD2/Vtq1CWp.NIjte9n0nohVPP5udFnbn2vd0kemwU45QX2C', 'images/1242792894.png', 'User', '2023-08-11 06:20:53', 'Enable');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_oficinas`
--

CREATE TABLE `tabla_oficinas` (
  `oficina_id` int(11) NOT NULL,
  `oficina_nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `oficina_personal` text COLLATE utf8_unicode_ci NOT NULL,
  `oficina_creada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tabla_oficinas`
--

INSERT INTO `tabla_oficinas` (`oficina_id`, `oficina_nombre`, `oficina_personal`, `oficina_creada`) VALUES
(10, 'Gobernacion Regional', 'Richard HANCCO SONCCO', '2023-12-04 07:55:51'),
(11, 'Vicegobernacion Regional', 'Eladia Margot DE LA RIVA VALLE', '2023-12-04 07:56:22'),
(12, 'Consejo Regional', 'Alfredo UCHARICO URUCHI', '2023-12-04 07:57:04'),
(13, 'Gerencia General Regional', 'Juan Oscar MACEDO CARDENAS', '2023-12-04 07:58:26'),
(14, 'Organo de Control Institucional', 'David Adolfo SILVA CERVANTES', '2023-12-04 07:59:09'),
(15, 'Procuraduria Publica Regional', 'Gerardo Ivan ZANTALLA PRIETO', '2023-12-04 07:59:47'),
(16, 'Oficina Regional de Gestion del Riesgo de Desastres y Seguridad', 'John Nilton CCAMA LIPA', '2023-12-04 08:00:41'),
(17, 'Oficina de Comunicaciones y R Publicas', 'Higor MAYTA OCHOCHOQUE', '2023-12-04 08:01:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_visitas`
--

CREATE TABLE `tabla_visitas` (
  `visita_id` int(11) NOT NULL,
  `visita_nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `visita_dni` int(12) NOT NULL,
  `visita_apersona` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `visita_aoficina` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `visita_motivo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `visita_entrada` datetime NOT NULL,
  `visita_observaciones` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `visita_salida` datetime NOT NULL,
  `visita_estado` enum('In','Out') COLLATE utf8_unicode_ci NOT NULL,
  `visita_registradapor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tabla_visitas`
--

INSERT INTO `tabla_visitas` (`visita_id`, `visita_nombre`, `visita_dni`, `visita_apersona`, `visita_aoficina`, `visita_motivo`, `visita_entrada`, `visita_observaciones`, `visita_salida`, `visita_estado`, `visita_registradapor`) VALUES
(1, 'ADCO MAMANI BRONDY BERNARDET', 74761018, 'Eladia Margot DE LA RIVA VALLE', 'Vicegobernacion Regional', 'Reunión', '2023-12-26 08:11:40', '-', '2023-12-26 08:21:11', 'Out', 1),
(2, 'ABIEGA CCAHUANA RELY', 75192644, 'Gerardo Ivan ZANTALLA PRIETO', 'Procuraduria Publica Regional', 'Tramite', '2023-12-26 08:13:16', '-', '2023-12-26 08:21:30', 'Out', 1),
(3, 'ADUVIRI GOMEZ YENY', 73450922, 'Alfredo UCHARICO URUCHI', 'Consejo Regional', 'Tramite', '2023-12-26 08:14:11', '-', '2023-12-26 08:21:49', 'Out', 1),
(4, 'AGUILAR RAMIREZ JOHAN DENIS', 76505415, 'Juan Oscar MACEDO CARDENAS', 'Gerencia General Regional', 'Reunión', '2023-12-26 08:14:58', '-', '2023-12-28 10:17:19', 'Out', 1),
(5, 'ANCALLA MAYTA WILLIAM DAVID', 75576250, 'David Adolfo SILVA CERVANTES', 'Organo de Control Institucional', 'Visita', '2023-12-28 10:09:46', '-', '2023-12-28 10:17:29', 'Out', 7),
(6, 'ANCCO FLORES RONALD', 73713194, 'Eladia Margot DE LA RIVA VALLE', 'Vicegobernacion Regional', 'Tramite', '2023-12-28 10:10:51', '-', '2023-12-28 10:17:36', 'Out', 7),
(7, 'APAZA CALCINA EDILSON', 71665669, 'Juan Oscar MACEDO CARDENAS', 'Gerencia General Regional', 'Tramite', '2023-12-28 10:14:49', '-', '2023-12-28 10:20:42', 'Out', 7),
(8, 'APAZA LOPEZ WILLIAMS', 70617025, 'David Adolfo SILVA CERVANTES', 'Organo de Control Institucional', 'Reunion', '2023-12-28 10:17:11', '-', '2023-12-28 10:21:16', 'Out', 1),
(9, 'APAZA RAMOS NIXON DANIEL', 73624466, 'Alfredo UCHARICO URUCHI', 'Consejo Regional', 'Consulta', '2023-12-28 10:18:36', '-', '2023-12-28 10:21:05', 'Out', 1),
(10, 'ARQUERO IQUISE NURIA RUTH', 72556662, 'Gerardo Ivan ZANTALLA PRIETO', 'Procuraduria Publica Regional', 'Tramite', '2023-12-28 10:19:38', '-', '2023-12-28 10:20:53', 'Out', 1),
(11, 'ASQUI LLUTARI PATRICIA LUVI', 70286316, 'Higor MAYTA OCHOCHOQUE', 'Oficina de Comunicaciones y Relaciones Publicas', 'Tramite', '2023-12-28 10:20:32', '-', '2023-12-28 10:24:17', 'Out', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tabla_admin`
--
ALTER TABLE `tabla_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indices de la tabla `tabla_oficinas`
--
ALTER TABLE `tabla_oficinas`
  ADD PRIMARY KEY (`oficina_id`);

--
-- Indices de la tabla `tabla_visitas`
--
ALTER TABLE `tabla_visitas`
  ADD PRIMARY KEY (`visita_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tabla_admin`
--
ALTER TABLE `tabla_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tabla_oficinas`
--
ALTER TABLE `tabla_oficinas`
  MODIFY `oficina_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tabla_visitas`
--
ALTER TABLE `tabla_visitas`
  MODIFY `visita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

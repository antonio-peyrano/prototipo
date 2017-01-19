-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-01-2017 a las 05:09:43
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecole`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catModulos`
--

CREATE TABLE `catModulos` (
  `idModulo` int(11) NOT NULL,
  `Modulo` varchar(250) NOT NULL,
  `URL` varchar(250) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `catModulos`
--

INSERT INTO `catModulos` (`idModulo`, `Modulo`, `URL`, `Status`) VALUES
(1, 'Clientes', '/ecole/php/frontend/clientes/busClientes.php', 0),
(2, 'Usuarios', '/ecole/php/frontend/usuarios/busUsuarios.php', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catNiveles`
--

CREATE TABLE `catNiveles` (
  `idNivel` int(11) NOT NULL,
  `Nivel` varchar(250) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `catNiveles`
--

INSERT INTO `catNiveles` (`idNivel`, `Nivel`, `Status`) VALUES
(1, 'Administrador', 0),
(2, 'Operador', 0),
(3, 'Lector', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catUsuarios`
--

CREATE TABLE `catUsuarios` (
  `idUsuario` int(11) NOT NULL,
  `idNivel` int(11) NOT NULL,
  `Usuario` varchar(250) NOT NULL,
  `Clave` varchar(250) NOT NULL,
  `Correo` varchar(250) NOT NULL,
  `Pregunta` varchar(250) NOT NULL,
  `Respuesta` varchar(250) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `catUsuarios`
--

INSERT INTO `catUsuarios` (`idUsuario`, `idNivel`, `Usuario`, `Clave`, `Correo`, `Pregunta`, `Respuesta`, `Status`) VALUES
(1, 1, 'root', '1OXW3t7Q', 'antonio.peyrano@live.com.mx', 'Su pasatiempo favorito', 'Leer', 0),
(2, 2, 'Cajero_1', 'ttDf1+HRzqM=', 'noname@nomail.com', 'Su primera mascota', 'terry', 0),
(3, 2, 'Cajero_2', 'ttDf1+HRzqQ=', 'noname@nomail.com', 'Su pelicula favorita', 'matrix', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opRelPerUsr`
--

CREATE TABLE `opRelPerUsr` (
  `idRelPerUsr` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idModulo` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `opRelPerUsr`
--

INSERT INTO `opRelPerUsr` (`idRelPerUsr`, `idUsuario`, `idModulo`, `Status`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 2, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opUsrTemp`
--

CREATE TABLE `opUsrTemp` (
  `idUsrtmp` int(11) NOT NULL,
  `idNivel` int(11) NOT NULL,
  `Usuario` varchar(250) NOT NULL,
  `Clave` varchar(250) NOT NULL,
  `Correo` varchar(250) NOT NULL,
  `Pregunta` varchar(250) NOT NULL,
  `Respuesta` varchar(250) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catModulos`
--
ALTER TABLE `catModulos`
  ADD PRIMARY KEY (`idModulo`),
  ADD KEY `idxModulo` (`idModulo`);

--
-- Indices de la tabla `catNiveles`
--
ALTER TABLE `catNiveles`
  ADD PRIMARY KEY (`idNivel`),
  ADD KEY `idxNivel` (`idNivel`);

--
-- Indices de la tabla `catUsuarios`
--
ALTER TABLE `catUsuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idxUsuario` (`idUsuario`);

--
-- Indices de la tabla `opRelPerUsr`
--
ALTER TABLE `opRelPerUsr`
  ADD PRIMARY KEY (`idRelPerUsr`),
  ADD KEY `idxRelPerUsr` (`idRelPerUsr`);

--
-- Indices de la tabla `opUsrTemp`
--
ALTER TABLE `opUsrTemp`
  ADD PRIMARY KEY (`idUsrtmp`),
  ADD KEY `idxUrstmp` (`idUsrtmp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catModulos`
--
ALTER TABLE `catModulos`
  MODIFY `idModulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `catNiveles`
--
ALTER TABLE `catNiveles`
  MODIFY `idNivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `catUsuarios`
--
ALTER TABLE `catUsuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `opRelPerUsr`
--
ALTER TABLE `opRelPerUsr`
  MODIFY `idRelPerUsr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `opUsrTemp`
--
ALTER TABLE `opUsrTemp`
  MODIFY `idUsrtmp` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

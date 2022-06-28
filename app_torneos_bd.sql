-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2022 a las 11:32:06
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `app_torneos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncia`
--

CREATE TABLE `denuncia` (
  `id` int(7) NOT NULL,
  `denunciado` int(7) NOT NULL,
  `denunciante` int(7) DEFAULT NULL,
  `asunto` varchar(64) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `denuncia`
--

INSERT INTO `denuncia` (`id`, `denunciado`, `denunciante`, `asunto`, `descripcion`) VALUES
(24, 131, 132, 'denuncia1', 'desc denucia 1'),
(25, 132, NULL, 'denuncia2', 'denuncia2'),
(28, 131, NULL, 'Denuncia por patan', 'Descripcion denuncia 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `torneo` int(7) NOT NULL,
  `lider` int(7) NOT NULL,
  `jugador1` int(7) DEFAULT NULL,
  `jugador2` int(7) DEFAULT NULL,
  `jugador3` int(7) DEFAULT NULL,
  `jugador4` int(7) DEFAULT NULL,
  `jugador5` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`torneo`, `lider`, `jugador1`, `jugador2`, `jugador3`, `jugador4`, `jugador5`) VALUES
(136, 130, NULL, NULL, NULL, NULL, NULL),
(137, 130, NULL, NULL, NULL, NULL, NULL),
(138, 131, NULL, NULL, NULL, NULL, NULL),
(138, 132, NULL, NULL, NULL, NULL, NULL),
(139, 130, NULL, NULL, NULL, NULL, NULL),
(141, 130, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencia`
--

CREATE TABLE `sugerencia` (
  `id` int(7) NOT NULL,
  `usuario` int(7) NOT NULL,
  `asunto` varchar(64) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sugerencia`
--

INSERT INTO `sugerencia` (`id`, `usuario`, `asunto`, `descripcion`) VALUES
(26, 132, 'Sugerencia 1', 'Sugerencia 1 Desc'),
(27, 131, 'Sugenreica 2', 'Sugerencia 2 Desc\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo`
--

CREATE TABLE `torneo` (
  `id` int(7) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `juego` varchar(64) NOT NULL,
  `plataforma` varchar(30) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `fecha_max` varchar(10) NOT NULL,
  `tipo_torneo` int(1) NOT NULL,
  `localizacion` varchar(255) DEFAULT NULL,
  `premio` varchar(64) DEFAULT NULL,
  `tipo_enfrentamiento` int(1) NOT NULL,
  `num_participantes` int(3) NOT NULL,
  `organizador` int(7) NOT NULL,
  `comunicacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `torneo`
--

INSERT INTO `torneo` (`id`, `nombre`, `juego`, `plataforma`, `fecha`, `hora`, `fecha_max`, `tipo_torneo`, `localizacion`, `premio`, `tipo_enfrentamiento`, `num_participantes`, `organizador`, `comunicacion`) VALUES
(136, 'Torneo League', 'League of Legends', 'PC', '25/6/2023', '20:00', '11/5/2023', 1, 'null', NULL, 1, 12, 131, 'Discord'),
(137, 'ValorantGG', 'Valorant', 'PC', '18/5/2023', '18:00', '11/5/2023', 1, 'null', NULL, 1, 20, 131, 'TS'),
(138, 'ARAM 1vs', 'League of Legends - ARAM', 'PC', '15/5/2022', '20:30', '12/5/2022', 2, 'Plaza Toros', NULL, 1, 2, 131, 'TeamSpeak3'),
(139, 'TorneoCordoba CSGO', 'CS: Global Ofensive', 'PC', '18/5/2023', '12:00', '12/5/2023', 1, 'null', 'null', 1, 30, 132, 'escribir a user2@gmail.com'),
(141, 'torneo brutal2', 'Brawl Stars', 'PC', '18/5/2023', '3:00', '16/5/2023', 1, 'null', '50$', 1, 25, 130, 'ts');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(7) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `contraseña` varchar(65) NOT NULL,
  `fecna` varchar(10) NOT NULL,
  `correo` varchar(64) NOT NULL,
  `permisos` int(1) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `token` text DEFAULT NULL,
  `token_exp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `contraseña`, `fecna`, `correo`, `permisos`, `avatar`, `estado`, `token`, `token_exp`) VALUES
(130, 'admin', '21232f297a57a5a743894a0e4a801fc3', '9/5/2022', 'admin@hotmail.com', 1, 'avatar_2', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTU4MTEwNTMsImV4cCI6MTY1NTgxNDY1MywiZGF0YSI6eyJpZCI6IjEzMCIsIm5vbWJyZSI6ImFkbWluIn19.VtOrQXFljs87LY-J5P0fHFlsFRancjzfGcwJJ6MMPv2H3vk3YARsqJh_UUYoqIuWHkKJDZ5BN1AUL-gGox1_BA', '1655814653'),
(131, 'usuario1', '1a1dc91c907325c69271ddf0c944bc72', '8/5/2022', 'usuario1@gmail.com', 0, 'avatar_2', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTU4MDI3MzgsImV4cCI6MTY1NTgwNjMzOCwiZGF0YSI6eyJpZCI6IjEzMSIsIm5vbWJyZSI6InVzdWFyaW8xIn19.SYXg9qToz0U-FgtKcwjz7VsKdVcHyBzFY_d9Gv2ieZdzo_F9xEZlZvekzN8FVtrp2El4_lexIOfF6u5b_wl9hg', '1655806338'),
(132, 'usuario2', '1a1dc91c907325c69271ddf0c944bc72', '9/5/2022', 'user2@gmail.es', 0, 'avatar_2', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTQ4MTA3MTEsImV4cCI6MTY1NDgxNDMxMSwiZGF0YSI6eyJpZCI6IjEzMiIsIm5vbWJyZSI6InVzdWFyaW8yIn19.XxwvYJG-FZVn3NdwUUtCFqC3m5iRwKF-29FQvXtOxfK8w2KKuDwZrTZ4Ft0S9Y5jFRe2wb0meAw2ZQrwHExx7w', '1654814311');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `denuncia`
--
ALTER TABLE `denuncia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_denunciante` (`denunciante`),
  ADD KEY `fk_denunciado` (`denunciado`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`torneo`,`lider`) USING BTREE,
  ADD KEY `fk_lider` (`lider`),
  ADD KEY `fk_jugador1` (`jugador1`),
  ADD KEY `fk_jugador2` (`jugador2`),
  ADD KEY `fk_jugador3` (`jugador3`),
  ADD KEY `fk_jugador4` (`jugador4`),
  ADD KEY `fk_jugador5` (`jugador5`);

--
-- Indices de la tabla `sugerencia`
--
ALTER TABLE `sugerencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_sujerencia` (`usuario`);

--
-- Indices de la tabla `torneo`
--
ALTER TABLE `torneo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `fk_organizador` (`organizador`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `denuncia`
--
ALTER TABLE `denuncia`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `sugerencia`
--
ALTER TABLE `sugerencia`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `torneo`
--
ALTER TABLE `torneo`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `denuncia`
--
ALTER TABLE `denuncia`
  ADD CONSTRAINT `fk_denunciado` FOREIGN KEY (`denunciado`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_denunciante` FOREIGN KEY (`denunciante`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `fk_jugador1` FOREIGN KEY (`jugador1`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jugador2` FOREIGN KEY (`jugador2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jugador3` FOREIGN KEY (`jugador3`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jugador4` FOREIGN KEY (`jugador4`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jugador5` FOREIGN KEY (`jugador5`) REFERENCES `torneo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lider` FOREIGN KEY (`lider`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_torneo` FOREIGN KEY (`torneo`) REFERENCES `torneo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sugerencia`
--
ALTER TABLE `sugerencia`
  ADD CONSTRAINT `fk_usuario_sujerencia` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `torneo`
--
ALTER TABLE `torneo`
  ADD CONSTRAINT `fk_organizador` FOREIGN KEY (`organizador`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

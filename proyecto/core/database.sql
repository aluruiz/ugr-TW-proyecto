
--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `identificador` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `incidencia` int(11) DEFAULT NULL,
  `comentario` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`identificador`, `usuario`, `incidencia`, `comentario`) VALUES
(1, 1, 2, 'Comentario de prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `identificador` int(11) NOT NULL,
  `incidencia` int(11) NOT NULL,
  `extension` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `identificador` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `positivas` int(11) DEFAULT '0',
  `negativas` int(11) DEFAULT '0',
  `estado` enum('Pendiente','Comprobada','Tramitada','Irresoluble','Resuelta') NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `incidencias`
--

INSERT INTO `incidencias` (`identificador`, `titulo`, `lugar`, `descripcion`, `fecha`, `positivas`, `negativas`, `estado`, `usuario`) VALUES
(1, 'Incidencia de prueba', 'En un rincon de la mancha', 'texto de ejemplo', '2019-07-06 20:26:49', 0, 0, 'Resuelta', 1),
(2, 'Prueba mi Prueba', 'De cuyo nombre no quiero acordarme', 'texto de ejemplo', '2019-07-06 20:26:49', 0, 0, 'Pendiente', 1),
(3, 'caditutoria', 'alguno que no recuerdo', 'Prueba de que ser realizan bien las incidencias', '2019-07-07 09:11:58', 0, 0, 'Tramitada', 1),
(4, 'caditutoria', 'alguno que no recuerdo', 'Prueba de que ser realizan bien las incidencias', '2019-07-07 09:09:20', 0, 0, 'Pendiente', 1),
(5, 'caditutoria', 'alguno que no recuerdo', 'Prueba de que ser realizan bien las incidencias', '2019-07-07 09:10:33', 0, 0, 'Pendiente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `identificador` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`identificador`, `fecha`, `descripcion`) VALUES
(1, '2019-07-07 06:49:17', 'Inicio de sesión correcto: 1'),
(2, '2019-07-07 06:50:36', 'Cierre de sesión correcto: 1'),
(3, '2019-07-07 07:00:02', 'Inicio de sesión correcto: 1'),
(4, '2019-07-07 07:17:46', 'Cierre de sesión correcto: 1'),
(5, '2019-07-07 07:17:54', 'Inicio de sesión correcto: 2'),
(6, '2019-07-07 07:17:57', 'Cierre de sesión correcto: 2'),
(7, '2019-07-07 07:32:16', 'Inicio de sesión correcto: 1'),
(8, '2019-07-07 08:22:51', 'Inicio de sesión correcto: 1'),
(9, '2019-07-07 08:54:31', 'Cierre de sesión correcto: 1'),
(10, '2019-07-07 08:59:55', 'Inicio de sesión correcto: 1'),
(11, '2019-07-07 09:05:13', 'Cierre de sesión correcto: 1'),
(12, '2019-07-07 09:05:20', 'Inicio de sesión correcto: 1'),
(13, '2019-07-07 09:05:49', 'Registrado el usuario: 3'),
(14, '2019-07-07 09:08:48', 'El usuario 1 ha realizado una nueva incidencia: 3'),
(15, '2019-07-07 09:10:33', 'El usuario 1 ha realizado una nueva incidencia: 3'),
(16, '2019-07-07 09:14:06', 'Cierre de sesión correcto: 1'),
(17, '2019-07-07 09:14:12', 'Inicio de sesión correcto: 3'),
(18, '2019-07-07 09:14:19', 'Cierre de sesión correcto: 3'),
(19, '2019-07-07 09:14:22', 'Inicio de sesión correcto: 1'),
(20, '2019-07-07 10:09:34', 'Cierre de sesión correcto: 1'),
(21, '2019-07-07 10:11:08', 'Inicio de sesión correcto: 1'),
(22, '2019-07-07 12:24:06', 'Inicio de sesión correcto: 1'),
(23, '2019-07-07 12:30:32', 'Registrado el usuario: 4'),
(24, '2019-07-07 12:33:54', 'Editado usuario Administrador: '),
(25, '2019-07-07 12:36:09', 'Editado usuario Administrador: '),
(26, '2019-07-07 12:36:09', 'Modificada contraseña de Usuario: '),
(27, '2019-07-07 12:39:27', 'Registrado el usuario: 5'),
(28, '2019-07-07 12:40:29', 'Editado usuario Administrador: '),
(29, '2019-07-07 12:40:49', 'Cierre de sesión correcto: 1'),
(30, '2019-07-07 12:41:10', 'Contraseña incorrecta para el usuario: 2'),
(31, '2019-07-07 12:41:21', 'Contraseña incorrecta para el usuario: 2'),
(32, '2019-07-07 12:41:35', 'Inicio de sesión correcto: 4'),
(33, '2019-07-07 12:41:38', 'Cierre de sesión correcto: 4'),
(34, '2019-07-07 12:41:49', 'Inicio de sesión correcto: 5'),
(35, '2019-07-07 12:41:51', 'Cierre de sesión correcto: 5'),
(36, '2019-07-07 12:42:00', 'Inicio de sesión correcto: 1'),
(37, '2019-07-07 12:42:19', 'Editado usuario Administrador: '),
(38, '2019-07-07 12:42:19', 'Modificada contraseña de Usuario: '),
(39, '2019-07-07 12:42:21', 'Cierre de sesión correcto: 1'),
(40, '2019-07-07 12:42:26', 'Contraseña incorrecta para el usuario: 2'),
(41, '2019-07-07 12:42:50', 'Inicio de sesión correcto: 1'),
(42, '2019-07-07 12:47:16', 'Registrado el usuario: 6'),
(43, '2019-07-07 12:47:29', 'Editado usuario Administrador: '),
(44, '2019-07-07 12:47:33', 'Cierre de sesión correcto: 1'),
(45, '2019-07-07 12:47:46', 'Inicio de sesión correcto: 6'),
(46, '2019-07-07 12:48:59', 'Cierre de sesión correcto: 6'),
(47, '2019-07-07 12:49:06', 'Inicio de sesión correcto: 1'),
(48, '2019-07-07 12:50:06', 'Cierre de sesión correcto: 1'),
(49, '2019-07-07 12:50:47', 'Inicio de sesión correcto: 5'),
(50, '2019-07-07 12:51:48', 'Cierre de sesión correcto: 5'),
(51, '2019-07-07 12:54:18', 'Inicio de sesión correcto: 5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabrasclave`
--

CREATE TABLE `palabrasclave` (
  `clave` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `palabrasclave`
--

INSERT INTO `palabrasclave` (`clave`) VALUES
('algo'),
('farola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relclaveincidencia`
--

CREATE TABLE `relclaveincidencia` (
  `clave` varchar(30) NOT NULL,
  `incidencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relclaveincidencia`
--

INSERT INTO `relclaveincidencia` (`clave`, `incidencia`) VALUES
('algo', 3),
('farola', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `identificador` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `familia` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rango` enum('Administrador','Colaborador') NOT NULL,
  `estado` enum('Inactivo','Activo') NOT NULL,
  `extImagen` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`identificador`, `nombre`, `familia`, `email`, `direccion`, `telefono`, `password`, `rango`, `estado`, `extImagen`) VALUES
(1, 'Growlithe', 'Growlithe', 'growlithe@admin.com', '22222', '999 222222', '$2y$10$j0CEuY9o3Rbkp2jt8LWlmOQej3Pd7aSvT207CB966c3RQPf.iJyve', 'Administrador', 'Activo', 'png'),
(4, 'Pikachu', 'Pichu', 'pikapi@gmail.com', '11111', '999 111111', '$2y$10$Yhxr2x0S1VRLJ2HwFezqQeCxUPTu3/hBAVfP7Vw2HFabrx/yGPYXK', 'Colaborador', 'Activo', 'png'),
(5, 'Skitty', 'Delcatty', 'lindoskitty@gmail.com', '23023', '999 232323', '$2y$10$sL1Hk3WEEviS1ns/VyOpMu0R85PqkqOSJG9q3FHbvmhQlG4vJs5se', 'Colaborador', 'Inactivo', 'png'),
(6, 'Eevee', 'Eevee', 'eeveelucion@correo.com', '33333', '999 333333', '$2y$10$RovDxzZNjumRceRJ5U7qmu7Vx8GaIxWCeSAW0GHot7PMaJAG8/PkG', 'Colaborador', 'Activo', 'png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `usuario` int(11) NOT NULL,
  `incidencia` int(11) NOT NULL,
  `valoracion` enum('Positiva','Negativa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`identificador`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `incidencia` (`incidencia`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`identificador`),
  ADD KEY `incidencia` (`incidencia`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`identificador`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`identificador`);

--
-- Indices de la tabla `palabrasclave`
--
ALTER TABLE `palabrasclave`
  ADD PRIMARY KEY (`clave`);

--
-- Indices de la tabla `relclaveincidencia`
--
ALTER TABLE `relclaveincidencia`
  ADD PRIMARY KEY (`clave`,`incidencia`),
  ADD KEY `incidencia` (`incidencia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`identificador`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`usuario`,`incidencia`),
  ADD KEY `incidencia` (`incidencia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`identificador`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`incidencia`) REFERENCES `incidencias` (`identificador`);

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`incidencia`) REFERENCES `incidencias` (`identificador`);

--
-- Filtros para la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`identificador`);

--
-- Filtros para la tabla `relclaveincidencia`
--
ALTER TABLE `relclaveincidencia`
  ADD CONSTRAINT `relclaveincidencia_ibfk_1` FOREIGN KEY (`clave`) REFERENCES `palabrasclave` (`clave`),
  ADD CONSTRAINT `relclaveincidencia_ibfk_2` FOREIGN KEY (`incidencia`) REFERENCES `incidencias` (`identificador`);

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`identificador`),
  ADD CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`incidencia`) REFERENCES `incidencias` (`identificador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

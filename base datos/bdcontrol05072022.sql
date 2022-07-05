-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2022 a las 01:02:36
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdcontrol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `idAsistencia` int(11) NOT NULL,
  `idPersonalAsistencia` int(11) DEFAULT NULL,
  `idHorarioAsistencia` int(11) DEFAULT NULL,
  `horaEntrada` datetime DEFAULT NULL,
  `horaSalida` datetime DEFAULT NULL,
  `estadoAsistencia` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `idCargo` int(11) NOT NULL,
  `nombreCargo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `idCarrera` int(11) NOT NULL,
  `idPlanCarrera` int(11) DEFAULT NULL,
  `nombreCarrera` varchar(200) NOT NULL,
  `estadoCarrera` tinyint(1) NOT NULL DEFAULT 1,
  `estadoDel` tinyint(4) NOT NULL,
  `fechaCarrera` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`idCarrera`, `idPlanCarrera`, `nombreCarrera`, `estadoCarrera`, `estadoDel`, `fechaCarrera`) VALUES
(5, 1, 'CONTABILIDAD', 1, 0, '2022-07-05 21:30:23'),
(6, 1, 'ADMINISTRACIÓN DE EMPRESAS', 1, 0, '2022-07-05 21:30:52'),
(7, 1, 'ADMINISTRACIÓN DE NEGOCIOS BANCARIOS Y FINANCIEROS', 1, 0, '2022-07-05 21:30:23'),
(8, 1, 'FARMACIA TÉCNICA', 1, 0, '2022-07-05 21:30:32'),
(9, 1, 'ENFERMERÍA TÉCNICA', 1, 0, '2022-07-05 21:31:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `idCurso` int(11) NOT NULL,
  `idCarreraCurso` int(11) DEFAULT NULL,
  `nombreCurso` varchar(254) NOT NULL,
  `periodo` varchar(5) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `correlativo` varchar(10) NOT NULL,
  `creditosCurso` int(11) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`idCurso`, `idCarreraCurso`, `nombreCurso`, `periodo`, `codigo`, `correlativo`, `creditosCurso`, `tipo`, `estado`, `fechaRegistro`) VALUES
(1, NULL, 'COMUNICACIÓN EFECTIVA', '1', 'AE009', '', 2, 'T', 1, '2022-07-05 20:39:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallehorario`
--

CREATE TABLE `detallehorario` (
  `idDetalle` int(11) NOT NULL,
  `idHorarioCurso` int(11) DEFAULT NULL,
  `dia` tinyint(4) DEFAULT NULL,
  `horaEntrada` time DEFAULT NULL,
  `horaSalida` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `idDocente` int(11) NOT NULL,
  `idPersonalDocente` int(11) DEFAULT NULL,
  `estadoDocente` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idHorario` int(11) NOT NULL,
  `idPersonalHorario` int(11) DEFAULT NULL,
  `diaHorario` tinyint(4) NOT NULL,
  `horaEntrada` time NOT NULL,
  `horaSalida` time NOT NULL,
  `estadoHorario` tinyint(4) NOT NULL,
  `fechaHorario` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_curso`
--

CREATE TABLE `horario_curso` (
  `idHorarioCurso` int(11) NOT NULL,
  `idDocenteHor` int(11) DEFAULT NULL,
  `idSeccionHor` int(11) DEFAULT NULL,
  `idCursoHor` int(11) DEFAULT NULL,
  `estadoCursoSeccion` tinyint(4) NOT NULL,
  `estadoDel` tinyint(4) NOT NULL,
  `fechaCursoSeccion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `idLocal` int(11) NOT NULL,
  `idSedeLocal` int(11) DEFAULT NULL,
  `codigoModular` varchar(45) NOT NULL,
  `codigoLocal` varchar(45) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `distrito` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `estadoLocal` tinyint(1) NOT NULL DEFAULT 1,
  `estadoDel` tinyint(4) NOT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`idLocal`, `idSedeLocal`, `codigoModular`, `codigoLocal`, `departamento`, `provincia`, `distrito`, `direccion`, `estadoLocal`, `estadoDel`, `fechaRegistro`) VALUES
(3, 5, '1536663', '1234561', '{\"ubigeo\":\"3518\",\"nombre\":\"Huanuco\"}', '{\"ubigeo\":\"3519\",\"nombre\":\"Huanuco\"}', '{\"ubigeo\":\"3520\",\"nombre\":\"Huanuco\"}', 'JR. BOLIVAR N° 449-451', 1, 0, '2022-07-05 20:47:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `local_carrera`
--

CREATE TABLE `local_carrera` (
  `idLocalCarrera` int(11) NOT NULL,
  `idLocal` int(11) DEFAULT NULL,
  `idCarrera` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `fechaRegistro` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `local_carrera`
--

INSERT INTO `local_carrera` (`idLocalCarrera`, `idLocal`, `idCarrera`, `estado`, `fechaRegistro`) VALUES
(1, 3, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPago` int(11) NOT NULL,
  `idPersonalPago` int(11) DEFAULT NULL,
  `montoPago` decimal(10,2) NOT NULL,
  `horas` int(11) NOT NULL,
  `minutis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `idPeriodo` int(11) NOT NULL,
  `yearPeriodo` int(11) NOT NULL,
  `etapaPeriodo` int(11) NOT NULL,
  `nombrePeriodo` varchar(45) NOT NULL,
  `estadoPeriodo` tinyint(4) NOT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `idPersonal` int(11) NOT NULL,
  `idPersonaPersonal` int(11) DEFAULT NULL,
  `idCargo` int(11) DEFAULT NULL,
  `correoPersonal` varchar(200) DEFAULT NULL,
  `celularPersonal` text DEFAULT NULL,
  `direccionPersonal` text DEFAULT NULL,
  `imagen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `idPersona` int(11) NOT NULL,
  `dniPersona` varchar(15) NOT NULL,
  `nombresPersona` varchar(100) NOT NULL,
  `apellidoPaternoPersona` varchar(100) NOT NULL,
  `apellidoMaternoPersona` varchar(100) NOT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idPersona`, `dniPersona`, `nombresPersona`, `apellidoPaternoPersona`, `apellidoMaternoPersona`, `fechaRegistro`) VALUES
(2, '72884584', 'CHRISTIAN IMER', 'VILCA', 'JUSTINIANO', '2022-07-05 17:19:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_lectivo`
--

CREATE TABLE `plan_lectivo` (
  `idPlan` int(11) NOT NULL,
  `nombrePlan` varchar(100) NOT NULL,
  `estadoPlan` tinyint(4) NOT NULL,
  `estadoDel` tinyint(4) NOT NULL,
  `fechaPlan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `plan_lectivo`
--

INSERT INTO `plan_lectivo` (`idPlan`, `nombrePlan`, `estadoPlan`, `estadoDel`, `fechaPlan`) VALUES
(1, 'Nuevo plan 2019', 1, 1, '2022-07-05 20:58:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `nombreRol` varchar(45) NOT NULL,
  `descripcionRol` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `nombreRol`, `descripcionRol`) VALUES
(2, 'ADMINISTRADOR', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `idSeccion` int(11) NOT NULL,
  `idSeccionLocal` int(11) DEFAULT NULL,
  `idPeriodoSeccion` int(11) DEFAULT NULL,
  `nombreAula` varchar(20) NOT NULL,
  `turno` varchar(20) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `estadoDel` tinyint(4) NOT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `idSede` int(11) NOT NULL,
  `nombreSede` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`idSede`, `nombreSede`) VALUES
(5, 'Huánuco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `idPersonaUsuario` int(11) DEFAULT NULL,
  `idRol` int(11) DEFAULT NULL,
  `nombreUsuario` varchar(45) NOT NULL,
  `contraUsuario` text NOT NULL,
  `estadoDel` tinyint(4) NOT NULL,
  `estadoUsuario` tinyint(4) NOT NULL,
  `fechaUsuario` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idPersonaUsuario`, `idRol`, `nombreUsuario`, `contraUsuario`, `estadoDel`, `estadoUsuario`, `fechaUsuario`) VALUES
(2, 2, 2, 'admin', 'admin', 1, 1, '2022-07-05 17:21:08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`idAsistencia`),
  ADD KEY `idPersonalAsistencia_idx` (`idPersonalAsistencia`),
  ADD KEY `idHorarioAsistencia_idx` (`idHorarioAsistencia`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`idCargo`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`idCarrera`),
  ADD KEY `idPlanCarrera_idx` (`idPlanCarrera`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idCurso`),
  ADD KEY `idCarreraCurso_idx` (`idCarreraCurso`);

--
-- Indices de la tabla `detallehorario`
--
ALTER TABLE `detallehorario`
  ADD PRIMARY KEY (`idDetalle`),
  ADD KEY `idHorarioCurso_idx` (`idHorarioCurso`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`idDocente`),
  ADD KEY `idPersonalDocente_idx` (`idPersonalDocente`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`idHorario`),
  ADD KEY `idPersonalHorario_idx` (`idPersonalHorario`);

--
-- Indices de la tabla `horario_curso`
--
ALTER TABLE `horario_curso`
  ADD PRIMARY KEY (`idHorarioCurso`),
  ADD KEY `idDocenteHor_idx` (`idDocenteHor`),
  ADD KEY `idSeccionHor_idx` (`idSeccionHor`),
  ADD KEY `idCursoHor_idx` (`idCursoHor`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`idLocal`),
  ADD KEY `idSedeLocal_idx` (`idSedeLocal`);

--
-- Indices de la tabla `local_carrera`
--
ALTER TABLE `local_carrera`
  ADD PRIMARY KEY (`idLocalCarrera`),
  ADD KEY `idLocal_idx` (`idLocal`),
  ADD KEY `idCarrera_idx` (`idCarrera`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `idPersonalPago_idx` (`idPersonalPago`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`idPeriodo`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idPersonal`),
  ADD KEY `idPersonaPersonal_idx` (`idPersonaPersonal`),
  ADD KEY `idCargo_idx` (`idCargo`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idPersona`);

--
-- Indices de la tabla `plan_lectivo`
--
ALTER TABLE `plan_lectivo`
  ADD PRIMARY KEY (`idPlan`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`idSeccion`),
  ADD KEY `idSeccionLocal_idx` (`idSeccionLocal`),
  ADD KEY `idPeriodoSeccion_idx` (`idPeriodoSeccion`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`idSede`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idPersonaUsuario_idx` (`idPersonaUsuario`),
  ADD KEY `idRol_idx` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `idCargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `idCarrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idHorario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `idLocal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `local_carrera`
--
ALTER TABLE `local_carrera`
  MODIFY `idLocalCarrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `idPeriodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idPersonal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `plan_lectivo`
--
ALTER TABLE `plan_lectivo`
  MODIFY `idPlan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `idSede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `idHorarioAsistencia` FOREIGN KEY (`idHorarioAsistencia`) REFERENCES `horarios` (`idHorario`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idPersonalAsistencia` FOREIGN KEY (`idPersonalAsistencia`) REFERENCES `personal` (`idPersonal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `idPlanCarrera` FOREIGN KEY (`idPlanCarrera`) REFERENCES `plan_lectivo` (`idPlan`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `idCarreraCurso` FOREIGN KEY (`idCarreraCurso`) REFERENCES `carreras` (`idCarrera`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `detallehorario`
--
ALTER TABLE `detallehorario`
  ADD CONSTRAINT `idHorarioCurso` FOREIGN KEY (`idHorarioCurso`) REFERENCES `horario_curso` (`idHorarioCurso`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `idPersonalDocente` FOREIGN KEY (`idPersonalDocente`) REFERENCES `personal` (`idPersonal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `idPersonalHorario` FOREIGN KEY (`idPersonalHorario`) REFERENCES `personal` (`idPersonal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `horario_curso`
--
ALTER TABLE `horario_curso`
  ADD CONSTRAINT `idCursoHor` FOREIGN KEY (`idCursoHor`) REFERENCES `cursos` (`idCurso`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idDocenteHor` FOREIGN KEY (`idDocenteHor`) REFERENCES `docentes` (`idDocente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idSeccionHor` FOREIGN KEY (`idSeccionHor`) REFERENCES `seccion` (`idSeccion`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `locales`
--
ALTER TABLE `locales`
  ADD CONSTRAINT `idSedeLocal` FOREIGN KEY (`idSedeLocal`) REFERENCES `sedes` (`idSede`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `local_carrera`
--
ALTER TABLE `local_carrera`
  ADD CONSTRAINT `idCarrera` FOREIGN KEY (`idCarrera`) REFERENCES `carreras` (`idCarrera`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idLocal` FOREIGN KEY (`idLocal`) REFERENCES `locales` (`idLocal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `idPersonalPago` FOREIGN KEY (`idPersonalPago`) REFERENCES `personal` (`idPersonal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `idCargo` FOREIGN KEY (`idCargo`) REFERENCES `cargos` (`idCargo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idPersonaPersonal` FOREIGN KEY (`idPersonaPersonal`) REFERENCES `personas` (`idPersona`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `idPeriodoSeccion` FOREIGN KEY (`idPeriodoSeccion`) REFERENCES `periodos` (`idPeriodo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idSeccionLocal` FOREIGN KEY (`idSeccionLocal`) REFERENCES `local_carrera` (`idLocalCarrera`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `idPersonaUsuario` FOREIGN KEY (`idPersonaUsuario`) REFERENCES `personas` (`idPersona`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `idRol` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `acciones` (
  `idaccion` int NOT NULL,
  `accion` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL
);

INSERT INTO `acciones` (`idaccion`, `accion`, `descripcion`) VALUES
(1, 'VEN', 'Acceso a Venta'),
(2, 'REP', 'Acceso a Reportes'),
(3, 'REP.GEN', 'Acceso a Reportes Generales'),
(4, 'CAT', 'Acceso a Categoria'),
(5, 'CAT.USR', 'Acceso a Usuarios'),
(6, 'CAT.PRD', 'Acceso a Productos');

CREATE TABLE `accionusuario` (
  `accion` varchar(30) NOT NULL,
  `idusuario` int NOT NULL
);

INSERT INTO `accionusuario` (`accion`, `idusuario`) VALUES
('VEN', 1),
('REP', 1),
('REP.GEN', 1),
('CAT', 1),
('CAT.USR', 1),
('CAT.PRD', 1);

CREATE TABLE `productos` (
  `idproducto` int NOT NULL,
  `nombrep` varchar(30) NOT NULL,
  `cantidad` int NOT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(100) NOT NULL
);

CREATE TABLE `usuario` (
  `idusuario` int NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL
);

INSERT INTO `usuario` (`idusuario`, `usuario`, `nombre`, `tel`, `correo`, `contraseña`, `activo`) VALUES
(1, 'admin', 'Administrador', 'xxxxxxxxxx', 'correo', '202cb962ac59075b964b07152d234b70', 1);

ALTER TABLE `acciones`
  ADD PRIMARY KEY (`idaccion`);

ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

ALTER TABLE `acciones`
  MODIFY `idaccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `productos`
  MODIFY `idproducto` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuario`
  MODIFY `idusuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;